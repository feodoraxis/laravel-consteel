<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Products extends Model
{
    use HasFactory;

    const STATUS_PUBLISHED = 'published';
    const STATUS_DRAFT     = 'draft';
    const STATUS_TRASH     = 'trash';

    const TYPE_SIMPLE   = 'simple';
    const TYPE_VARIABLE = 'variable';

    const CHARACTERISTICS_TYPE__STRING  = 'string';
    const CHARACTERISTICS_TYPE__INTEGER = 'integer';
    const CHARACTERISTICS_TYPE__FLOAT   = 'float';
    const CHARACTERISTICS_TYPE__COLOR   = 'color';

    const CHARACTERISTICS_OPTIONS__TABLE_NAME = 'products_characteristics_options';

    const PARAMETER_BRAND_ID = 1;

    const VIEWED_PRODUCTS_COOKIE_NAME = 'VIEWED_PRODUCTS';

    private $posts_per_page  = 16;
    private $current_page    = 1;
    private $categories      = [];
    private $viewed_products = [];

    public function __construct()
    {
        $this->posts_per_page = env('PAGINATION', 16);

        if ( isset($_GET['PAGE']) && intval($_GET['PAGE']) > 0 ) {
            $this->current_page = intval($_GET['PAGE']);
        } else {
            $this->current_page = 1;
        }
    }

    /**
     * @param int $current_page
     */
    public function setCurrentPage( int $current_page ) : Void
    {
        $this->current_page = $current_page;
    }

    /**
     * @param int $category_id
     * @return int[]
     */
    private function setCategories( int $category_id ):array
    {
        if ( !empty( $this->categories ) ) {
            return $this->categories;
        }

        $this->categories = [ $category_id ];

        $categories_three = Products_category::getHierarchicalTree( $category_id, 'id' );

        if ( isset( $categories_three['after'] ) && !empty( $categories_three['after'] ) ) {
            foreach ( $categories_three['after'] as $item ) {
                $this->categories[] = $item['id'];
            }
        }

        return $this->categories;
    }

    /**
     * @param int $product_id
     * @return array
     */
    private function viewedProducts(int $product_id):array
    {
        if ( isset($_COOKIE[ self::VIEWED_PRODUCTS_COOKIE_NAME ]) && !empty($_COOKIE[ self::VIEWED_PRODUCTS_COOKIE_NAME ]) ) {
            $this->viewed_products = json_decode($_COOKIE[ self::VIEWED_PRODUCTS_COOKIE_NAME ], true);

            if ( json_last_error() ) {
                $this->viewed_products = [];
            }
        }

        $this->viewed_products[ $product_id ] = [
            'product_id' => $product_id,
            'time' => time()
        ];

        usort($this->viewed_products, function($a, $b) {
            return ($a['time'] - $b['time']);
        });

        if ( count($this->viewed_products) > 4 ) {
            array_shift($this->viewed_products);
        }

        foreach ($this->viewed_products as $item) {
            $viewed_products[] = $item['product_id'];
        }

        setcookie( self::VIEWED_PRODUCTS_COOKIE_NAME, json_encode($this->viewed_products) );

        return $viewed_products;
    }

    public function getByIds( array $ids ):array
    {
        $result = self::query()
            ->whereIn('id', $ids)
            ->get();

        $result = self::handleObjects($result);

        foreach ( $result as &$item ) {
            $this->handleCharacteristics($item);
        }

        return $result;
    }

    private function handleCharacteristics(&$result)
    {
        if ( empty($result['characteristics']) ) {
            return;
        }

        $result['characteristics'] = json_decode($result['characteristics'], true);

        if ( !isset($result['characteristics']) || empty($result['characteristics']) || !is_array($result['characteristics']) || json_last_error() ) {
            return;
        }

        $chars_ids = $characteristics = [];

        foreach ($result['characteristics'] as $characteristic) {
            foreach ( $characteristic as $key => $item ) {
                $chars_ids[] = $key;
                $characteristics[ $key ] = $item;
            }
        }
        $result['characteristics'] = $characteristics;
        $characteristics = [];

        $parameters = Products_characteristics_options::getbyIds( $chars_ids );

        if ( empty($parameters) ) {
            return $result;
        }

        foreach ($parameters as $parameter) {
            $characteristics[ $parameter['id'] ] = array_merge($parameter, [
                'value' => $result['characteristics'][ $parameter['id'] ]
            ]);

            if ( self::PARAMETER_BRAND_ID == $parameter['id'] ) {
                $result['brand'] = $characteristics[ $parameter['id'] ];
            }
        }

        $result['characteristics'] = $characteristics;
    }

    /**
     * @param $slug
     * @return array
     */
    public function getBySlug( $slug ):array
    {
        $result = self::query()
            ->where(self::getTable() . '.slug', '=', $slug)
            ->get();

        $result = self::handleObjects($result, false);

        $this->handleCharacteristics($result);

        if ( intval($result['category']) > 0 ) {
            $similar_products = self::query()
                ->where('category', '=', $result['category'] )
                ->inRandomOrder()
                ->limit(8)
                ->get();

            $result['similar_products'] = self::handleObjects($similar_products);
        }

        $viewed_products_ids = $this->viewedProducts( $result['id'] );

        if ( !empty($viewed_products_ids) ) {
            $viewed_products = self::query()
                ->whereIn('id', $viewed_products_ids)
                ->get();

            $result['viewed_products'] = self::handleObjects($viewed_products);
        }

        return $result;
    }

    /**
     * @param int $category_id
     * @param string $filter
     * @return array
     */
    public function getListByCategoryId( int $category_id, string $filter = '' ) : array
    {
        $offset = ($this->current_page-1) * $this->posts_per_page;
        $this->setCategories( $category_id );

        $query = self::query()
            ->whereIn('category', $this->categories)
            ->where('status', '=', self::STATUS_PUBLISHED);

        if ( isset( $_REQUEST['filter'] ) ) {
            $r['filter'] = $_REQUEST['filter'];
        }

        if ( !empty($filter) ) {
            parse_str($filter , $r);
        }

        if ( isset( $r['filter'] ) ) {
            foreach ( $r['filter'] as $key => $item ) {
                if ( $key == 'price' ) {
                    $query->where([
                        ['price', '>=', $item['from'] ],
                        ['price', '<=', $item['to'] ],
                    ]);
                } else {
                    $query->where(function($q) use ( $key , $item ) {
                        foreach ( $item as $k => $val ) {
                            if ( !$k ) {
                                $q->where('characteristics' , 'like' , '%{"' . $key . '":"' . $val . '"}%');
                            } else {
                                $q->orWhere('characteristics' , 'like' , '%{"' . $key . '":"' . $val . '"}%');
                            }
                        }
                    });
                }
            }
        }

        if ( isset( $_REQUEST['sort'] ) ) {
            switch ($_REQUEST['sort']) {
                case 'price-asc':
                    $query->orderBy('price');
                    break;
                case 'price-desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'has':
                    $query->orderBy('quantity');
                    break;
                case 'has-not':
                    $query->orderBy('quantity', 'desc');
                    break;
            }
        } else {
            $query->orderBy('sort');
        }

        $query->offset( $offset )
            ->limit( $this->posts_per_page );

        $result = $query->get();

        return self::handleObjects($result);
    }

    /**
     * @param string $search_request
     * @param bool $need_categories
     * @return array
     */
    public function getListBySearchRequest( string $search_request, bool $need_categories = false ) : array
    {
        $offset = ($this->current_page-1) * $this->posts_per_page;

        $select = ['*'];
        $where = [
            ['name', 'like', "%{$search_request}%"],
            ['status', '=', self::STATUS_PUBLISHED]
        ];
        $orderby = '.sort';

        if ( $need_categories === true ) {
            $category_table_name = Products_category::getTableName();
            $self_table_name = self::getTable();

            $select = [
                $self_table_name . ".id",
                $self_table_name . ".name",
                $self_table_name . ".slug",
                $self_table_name . ".status",
                $self_table_name . ".sort",
                $self_table_name . ".price",
                $self_table_name . ".category",
                $self_table_name . ".thumbnail_preview",
                $category_table_name . '.id as category_id',
                $category_table_name . '.slug as category_slug',
                $category_table_name . '.name as category_name',
            ];

            $where = [
                [$self_table_name . '.name', 'like', "%{$search_request}%"],
                [$self_table_name . '.status', '=', self::STATUS_PUBLISHED]
            ];

            $orderby = $self_table_name . '.sort';
        }

        $query = self::query()
            ->select($select)
            ->where($where);

        if ( $need_categories === true ) {
            $query->leftJoin($category_table_name , self::getTable() . '.category' , '=' , $category_table_name . '.id');
        }

        $result = $query->orderBy($orderby)
            ->offset( $offset )
            ->limit( $this->posts_per_page )
            ->get();

        $result = self::handleObjects($result);

        if ( $need_categories === false ) {
            return $result;
        }

        if ( empty($result) ) {
            return [];
        }

        $output = [];
        foreach ( $result as $item ) {
            $output['products'][] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'slug' => $item['slug'],
                'sort' => $item['sort'],
                'price' => $item['price'],
                'link' => $item['link'],
                'thumbnail_preview' => $item['thumbnail_preview'],
            ];

            $output['categories'][ $item['category_id'] ] = [
                'id' => $item['category_id'],
                'link' => Products_category::getLink( ['field' => 'slug', 'value' => $item['category_slug'] ] ),
                'name' => $item['category_name'],
            ];
        }

        return $output;
    }

    public function listRenderSearchPreview( array $data ):string
    {
        if ( empty($data['products']) ) {
            return '';
        }

        $output = '<div class="main__search-categories">
                    <b>Категории</b>
                    <div class="catalog__categoryes">
                        <ul>';

        foreach ( $data['categories'] as $category ) {
            $output .= '<li><a class="before" href="' . $category['link'] . '">' . $category['name'] . '</a></li>';
        }

        $output .= '</ul>
                </div>
            </div>
            <div class="main__search-list">
                <b>Товары</b>
                <ul>';

        foreach ( $data['products'] as $product ) {
            $output .= view("catalog.preview-search", ['item' => $product]);
        }

        $output .= '</ul></div>';

        return $output;
    }

    /**
     * @param int $category_id
     * @return array
     */
    public function filterRender( int $category_id ):array
    {
        $this->setCategories( $category_id );
        $where = [
            ['status', '=', self::STATUS_PUBLISHED],
            ['characteristics', '!=', ''],
            ['characteristics', '!=', '1'],
            ['characteristics', '!=', '{}'],
            ['characteristics', '!=', '[]'],
        ];

        $category = Products_category::getCategoryBy('id', $category_id, ['filter']);
        $filter = json_decode($category['filter'], true);

        if ( !json_last_error() && !empty($filter) ) {
            foreach ($filter as $item) {
                $where[] = ['characteristics' , 'like' , '%{"' . $item . '":"%"}%'];
            }
        } else {
            $filter = [];
        }

        $result = self::query()
            ->select('characteristics', 'sort')
            ->distinct()
            ->whereIn('category', $this->categories)
            ->where( $where )
            ->orderBy('sort')
            ->get();

        $data = json_decode($result, true);

        if ( empty($data) || json_last_error() ) {
            return [];
        }

        $chars_ids = $chars_values = $check_chars_values = [];
        foreach ( $data as $item ) {
            $characteristics = json_decode($item['characteristics'], true);

            if ( is_array($characteristics) && !json_last_error() ) {

                foreach ( $characteristics as $val ) {

                    foreach ( $val as $key => $v ) {

                        if ( empty($filter) || in_array($key, $filter) ) {

                            if ( !in_array($key , $chars_ids) ) {
                                $chars_ids[] = $key;
                            }

                            if ( !isset($check_chars_values[ $key ]) ) {
                                $chars_values[ $key ] = $check_chars_values[ $key ] = [];
                            }

                            if ( !in_array($v , $check_chars_values[ $key ]) ) {
                                $chars_values[ $key ][] = [
                                    'name' => $v,
                                    'checked' => isset($_REQUEST['filter'][ $key ]) && in_array($v, $_REQUEST['filter'][ $key ]) ? ' checked' : '',
                                ];

                                $check_chars_values[ $key ][] = $v;
                            }

                        }
                    }
                }
            }
        }

        $chars_data_json = self::query()
            ->from( self::CHARACTERISTICS_OPTIONS__TABLE_NAME )
            ->whereIn('id', $chars_ids)
            ->get();

        $chars_data = json_decode($chars_data_json, true);

        if ( empty($chars_data) || json_last_error() ) {
            return [];
        }

        foreach ( $chars_data as &$item ) {
            $item['values'] = $chars_values[ $item['id'] ];
        }

        return $chars_data;
    }

    /**
     * @param int $category_id
     * @return string
     */
    public function pagination( int $category_id ):string
    {
        $count = self::query()
            ->where([
                ['category', '=', $category_id],
                ['status', '=', self::STATUS_PUBLISHED],
            ])
            ->count();

        if ( $count <= $this->posts_per_page ) {
            return '';
        }

        $pages = ceil($count / $this->posts_per_page);

        $output = '<div class="wrapper">
                    <div class="catalog-pagintaion">
                        <div class="pagination" id="pagination">
                            <div class="pagination-flexbox">
                                <div class="pagination-upload">
                                    <button class="button button-show_more" id="show_more"

                                        data-type="catalog"
                                        data-category="' . $category_id . '"
                                        data-current_page="' . $this->current_page . '"
                                        data-max="' . $pages . '"
                                        data-csrf="' . csrf_token() . '">Показать ещё</button>
                                </div>
                                <div class="pagination-list">
                                    <ul>';

        $parse_url = parse_url($_SERVER['REQUEST_URI']);

        for ( $i = 1; $i <= $pages; $i++ ) {
            if ( $i == $this->current_page ) {
                $output .= '<li data-num="' . $i . '" class="active"><span>' . $i . '</span></li>';
            } else {
                $output .= '<li data-num="' . $i . '"><a href="' . $parse_url['path'] . '?PAGE=' . $i . '"><span>' . $i . '</span></a></li>';
            }
        }

        $output .= '      </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

        return $output;
    }

    /**
     * @param string $search_request
     * @return string
     */
    public function paginationBySearchRequest( string $search_request ):string
    {
        $count = self::query()
            ->where([
                ['name', 'like', "%{$search_request}%"],
                ['status', '=', self::STATUS_PUBLISHED],
            ])
            ->count();

        if ( $count <= $this->posts_per_page ) {
            return '';
        }

        $pages = ceil($count / $this->posts_per_page);

        $output = '<div class="wrapper">
                    <div class="catalog-pagintaion">
                        <div class="pagination" id="pagination">
                            <div class="pagination-flexbox">
                                <div class="pagination-upload">
                                    <button class="button button-show_more" id="show_more_search"

                                        data-type="catalog"
                                        data-request="' . $search_request . '"
                                        data-current_page="' . $this->current_page . '"
                                        data-max="' . $pages . '"
                                        data-csrf="' . csrf_token() . '">Показать ещё</button>
                                </div>
                                <div class="pagination-list">
                                    <ul>';

        $parse_url = parse_url($_SERVER['REQUEST_URI']);

        for ( $i = 1; $i <= $pages; $i++ ) {
            if ( $i == $this->current_page ) {
                $output .= '<li data-num="' . $i . '" class="active"><span>' . $i . '</span></li>';
            } else {
                $output .= '<li data-num="' . $i . '"><a href="' . $parse_url['path'] . '?' . Catalog::SEARCH_VARCHAR_NAME . '=' . $search_request . '&PAGE=' . $i . '"><span>' . $i . '</span></a></li>';
            }
        }

        $output .= '      </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

        return $output;
    }

    /**
     * @param $objects
     * @param bool $multiple
     * @return array
     */
    private function handleObjects($objects, bool $multiple = true) : array
    {
        $objects = json_decode($objects, true);
        $compare = new Compare();

        if (empty($objects) || json_last_error()) {
            return [];
        }

        foreach ($objects as &$item) {
            $item['link'] = self::getLink($item['category'], $item['slug']);

            if ( $item['category'] ) {
                $item['category'] = Products_category::getCategoryBy('id', $item['category']);
            }

            if ( isset($item['thumbnail_preview']) ) {
                $item['thumbnail_preview'] = Media::getThumbnailData($item['thumbnail_preview']);
            } else {
                $item['thumbnail_preview'] = '';
            }

            if ( isset($item['thumbnail_detail']) ) {
                $item['thumbnail_detail'] = Media::getThumbnailData($item['thumbnail_detail']);
            } else {
                $item['thumbnail_detail'] = '';
            }

            if ( isset($item['price']) && !empty($item['price']) && $item['price'] !== '0.00' ) {
                $item['price'] = self::handlePrice($item['price']);
            } else {
                $item['price'] = '';
            }

            if ( $multiple === false ) {

                if ( !empty($item['gallery']) && is_array(json_decode($item['gallery'], true)) ) {
                    $gallery = json_decode($item['gallery'], true);
                }

                if ( isset($gallery) && !json_last_error() ) {
                    $item['gallery'] = Media::getThumbnailsData($gallery);
                    unset($gallery);
                }
            }

            if ( !empty($item['price_discount']) && $item['price_discount'] !== '0.00' ) {
                $item['price_discount'] = self::handlePrice($item['price_discount'], $multiple);
            }

            if ( $compare->isInCompare( $item['id'] ) ) {
                $item['compare_class'] = ' active';
            } else {
                $item['compare_class'] = '';
            }

        }
        unset($item);

        if ( $multiple === true ) {
            return $objects;
        } else {
            return reset($objects);
        }
    }

    /**
     * @param string $original_price
     * @param bool $use_span
     * @return array
     */
    private static function handlePrice( string $original_price, bool $use_span = true ):array
    {
        if ( $use_span === true ) {
            $html_before = '<span>';
            $html_after = '</span><span> ₽</span>';
        } else {
            $html_before = '';
            $html_after = ' ₽';
        }

        if ( strripos( $original_price, '.00' ) ) {
            $html = $html_before . number_format(intval($original_price), 2, '.', ' ') . $html_after;
        } else {
            $price = explode('.', $original_price);
            $html = $html_before . number_format(intval($price['0']), 0, '.', ' ') . '.' . $price['1'] . $html_after;
        }

        return [
            'original' => $original_price,
            'integer' => intval($original_price),
            'html' => $html
        ];
    }

    /**
     * @param int $category_id
     * @param string $slug
     * @return string
     */
    public static function getLink( int $category_id, string $slug ) : string
    {
        return Products_category::getLink([
            'field' => 'id',
            'value' => $category_id
        ]) . $slug . '.html';
    }
}
