<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products_category extends Model
{
    use HasFactory;

    private static $hierarchical_tree;

    static public function index()
    {

    }

    /**
     * @return array
     */
    static public function get():array
    {
        $items = [];
        $json = self::query()->get();
        $temp = json_decode($json, true);

        if (json_last_error() || !is_array($temp) || empty($temp)) {
            return [];
        }

        $i = 1;
        $size = count($temp);
        while ($i < $size) {
            if ($temp[$i - 1]['sort'] <= $temp[ $i ]['sort']) {
                ++$i;
            } else {
                list($temp[$i - 1], $temp[ $i ]) = array($temp[ $i ], $temp[$i - 1]);
                if ($i > 1) {
                    --$i;
                }
            }
        }

        foreach ( $temp as $item ) {
            $item['link'] = self::getLink([
                'field' => 'slug',
                'value' => $item['slug']
            ]);

            $items[ $item['parent'] ]['items'][ $item['id'] ] = $item;
            $items[ $item['parent'] ]['class'] = self::setLevelClass($item['level']);
            $items[ $item['parent'] ]['id'] = 'menu_' . $item['parent'];
        }

        return $items;
    }

    public function getBySlug(string $slug) : array
    {
        $result = self::query()->where('slug', $slug)->get();
        return $this->handleObject($result, false);
    }

    public function getByIds(array $ids):array
    {
        $result = self::query()
            ->select([
                $this->getTable() . '.id',
                $this->getTable() . '.slug',
                $this->getTable() . '.name',
                $this->getTable() . '.sort',
                $this->getTable() . '.thumbnail',
                'media.link as preview_thumbnail',
                'media.meta',
            ])
            ->leftJoin('media', 'media.id', '=', $this->getTable() . '.thumbnail')
            ->whereIn($this->getTable() . '.id', $ids )
            ->get();

        return $this->handleObject($result);
    }

    /**
     * @param array $products
     * @return string
     */
    public static function renderCatalog( array $products ):string
    {
        $output = '';

        foreach ( $products as $product ) {
            $output .= '<div class="col-xl-3 col-lg-4 col-sm-6 catalog__list-item before after">';
            $output .= view("catalog.preview", ['item' => $product]);
            $output .= '</div>';
        }

        return $output;
    }

    /**
     * @param $object
     * @param bool $multiple
     * @return array
     */
    private function handleObject($object, bool $multiple = true) : array
    {
        $object = json_decode($object, true);

        if (empty($object) || json_last_error()) {
            return [];
        }

        foreach ($object as &$item) {
            $item['link'] = self::getLink([
                'field' => 'slug',
                'value' => $item['slug']
            ]);
        }
        unset($item);

        if ( $multiple === true ) {
            return $object;
        } else {
            return reset($object);
        }
    }

    /**
     * @param array $args
     * @return string
     */
    static public function getLink( array $args ) : string
    {
        if ( !isset($args['value']) || empty($args['value']) ) {
            return '';
        }

        $args['field'] = $args['field'] == 'id' ? 'id' : 'slug';

        $output = '/catalog/';

        if ( $args['field'] == 'id' && is_int($args['value']) ) {
            $result = self::query()
                ->select('slug')
                ->where('id' , $args['value'])->first();

            return $output . $result['slug'] . '/';
        } else {
            return $output . $args['value'] . '/';
        }
    }

    /**
     * @param $category
     * @param string $field
     * @return array
     */
    static public function getHierarchicalTree( $category, string $field = 'slug' ):array
    {
        if ( self::$hierarchical_tree !== NULL ) {
            return self::$hierarchical_tree;
        }

        if ( $field == 'slug' ) {
            $current_category_field = 'slug';
        } elseif ( $field == 'id' ) {
            $current_category_field = 'id';
        } else {
            return self::$hierarchical_tree;
        }

        $table_name = self::getTableName();
        $result = self::query()
            ->select('slug', 'name', 'id', 'parent', 'level')
            ->where($current_category_field, '=', $category)
            ->orWhere('id', '=', function( $query ) use ( $category , $current_category_field , $table_name ) {
                $query->from($table_name)
                    ->select('parent')
                    ->where($current_category_field, '=', $category);
            })
            ->orWhere('parent', '=', function( $query ) use ( $category , $current_category_field , $table_name ) {
                $query->from($table_name)
                    ->select('id')
                    ->where($current_category_field, '=', $category);
            })
            ->orWhere('parent', '=', 'id')
            ->orderBy('level')
            ->get();

        $data = json_decode($result, true);

        if ( json_last_error() || empty($data) ) {
            return [];
        }

        $output = $current = $before = $parents = [];
        foreach ( $data as $item ) {
            if ( empty($current) ) {
                $before[ $item['level'] ][ $item['id'] ] = $item;
            } else {
                $output['after'][] = $item;
            }

            if ( $item[ $current_category_field ] == $category ) {
                $output['current'] = $item;
                $current = $item;
                $parents[] = $item['id'];
            }
        }

        krsort($before);

        foreach ( $before as $items ) {
            foreach ( $items as $item ) {
                if ( in_array( $item['id'], $parents ) && $item[ $current_category_field ] !== $category ) {
                    $output['before'][] = $item;
                }

                $parents[] = $item['parent'];
            }
        }

        if ( isset($output['before']) ) {
            krsort($output['before']);
        }

        self::$hierarchical_tree = $output;

        return self::$hierarchical_tree;
    }

    /**
     * @param string $category_slug
     * @return string
     */
    static public function subcategories( string $category_slug ):string
    {

        self::getHierarchicalTree($category_slug);

        if ( !isset(self::$hierarchical_tree['after']) || !is_array(self::$hierarchical_tree['after']) ) {
            return '';
        }

        $output = '<div class="catalog-categoryes">
                    <div class="catalog__categoryes">
                        <ul>';

        foreach ( self::$hierarchical_tree['after'] as $item ) {
            $output .= '<li><a class="before" href="' . self::getLink([ 'field' => 'slug' , 'value' => $item['slug'] ]) . '">' . $item['name'] . '</a></li>';
        }

        $output .= '</ul></div></div>';

        return $output;
    }

    /**
     * @param string $category_slug
     * @return string
     */
    static public function breadcrumbs( string $category_slug ):string
    {
        self::getHierarchicalTree($category_slug);

        $output = '<div class="breadcrumbs"><ol itemscope="" itemtype="http://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscopeitemtype="http://schema.org/ListItem"><a class="before" itemprop="item" href="/"><span itemprop="name">Главная</span>
                        <meta itemprop="position" content="1"></a></li>';

        $i = 2;
        if ( isset( self::$hierarchical_tree['before'] ) && is_array( self::$hierarchical_tree['before'] ) ) {
            foreach ( self::$hierarchical_tree['before'] as $item ) {
                $output .= '<li itemprop="itemListElement" itemscopeitemtype="http://schema.org/ListItem">';
                $output .= '<a class="before" itemprop="item" href="' . self::getLink([ 'field' => 'slug' , 'value' => $item['slug'] ]) . '"><span itemprop="name">' . $item['name'] . '</span><meta itemprop="position" content="' . $i . '"></a></li>';
                $i++;
            }
        }

        $output .= '<span itemprop="name">' . self::$hierarchical_tree['current']['name'] . '</span><meta itemprop="position" content="' . $i . '"></li></ol></div>';

        return $output;
    }

    /**
     * @return string
     */
    public static function getTableName():string
    {
        return (new self())->getTable();
    }

    /**
     * @param $level
     * @return string
     */
    private static function setLevelClass ( $level ):string
    {
        switch ($level) {
            case 1 :
                return 'first';
            case 2 :
                return 'second';
            default :
                return 'last';
        }
    }

}
