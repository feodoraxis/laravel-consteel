<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    private $posts_per_page = 16;
    private $current_page   = 1;
    private $categories = [];

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

        $query->orderBy('sort')
            ->offset( $offset )
            ->limit( $this->posts_per_page );

        $result = $query->get();

        return self::handleObjects($result);
    }

    /**
     * @param int $category_id
     * @return array
     */
    public function filterRender( int $category_id ):array
    {
        $this->setCategories( $category_id );

        $result = self::query()
            ->select('characteristics', 'sort')
            ->distinct()
            ->whereIn('category', $this->categories)
            ->where([
                ['status', '=', self::STATUS_PUBLISHED],
                ['characteristics', '!=', ''],
                ['characteristics', '!=', '1'],
                ['characteristics', '!=', '{}'],
                ['characteristics', '!=', '[]'],
            ])
            ->orderBy('sort')
            ->get();

        $data = json_decode($result, true);

        if ( empty($data) || json_last_error() ) {
            return [];
        }

        $chars_ids = $chars_values = $check_chars_values = [];
        foreach ( $data as $item ) {
            $json = json_decode($item['characteristics'], true);
            if ( is_array($json) && !json_last_error() ) {
                foreach ( $json as $val ) {
                    foreach ( $val as $key => $v ) {
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

//        dd($chars_data);

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
                                        data-max="' . $pages . '",
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
     * @param $objects
     * @param bool $multiple
     * @return array
     */
    private function handleObjects($objects, bool $multiple = true) : array
    {
        $objects = json_decode($objects, true);

        if (empty($objects) || json_last_error()) {
            return [];
        }

        foreach ($objects as &$item) {
            $item['link'] = self::getLink($item['category'], $item['slug']);
            $item['thumbnail_preview'] = Media::getThumbnailData($item['thumbnail_preview']);
            $item['thumbnail_detail'] = Media::getThumbnailData($item['thumbnail_detail']);
            $item['price'] = self::handlePrice($item['price']);

            if ( !empty($item['price_discount']) && $item['price_discount'] !== '0.00' ) {
                $item['price_discount'] = self::handlePrice($item['price_discount']);
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
     * @return array
     */
    private static function handlePrice( string $original_price ):array
    {
        if ( strripos( $original_price, '.00' ) ) {
            $html = '<span>' . number_format(intval($original_price), 2, '.', ' ') . '</span><span> ₽</span>';
        } else {
            $price = explode('.', $original_price);
            $html = '<span>' . number_format(intval($price['0']), 0, '.', ' ') . '.' . $price['1'] . '</span><span> ₽</span>';
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
