<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Integer;

class Compare extends Model
{
    use HasFactory;

    const HASH_NAME = 'compare';

    private $products_ids;
    private $product_id;

    public function __construct ( array $attributes = [] )
    {
        parent::__construct($attributes);

        if ( !isset($_SESSION) ) {
            session_start();
        }

        if ( isset($_SESSION[ self::HASH_NAME ]) && !empty($_SESSION[ self::HASH_NAME ]) ) {
            $compare = json_decode($_SESSION[ self::HASH_NAME ]);

            if ( !empty($compare) && is_array($compare) && !json_last_error() ) {
                $this->products_ids = $compare;
                return;
            }
        }

        $this->products_ids = [];
    }

    /**
     * @param int $product_id
     */
    public function setProduct( int $product_id = 0 )
    {
        $this->product_id = $product_id;
    }

    /**
     * @return array
     */
    public function index():array
    {
        $products = new Products();

        if ( empty($this->products_ids) ) {
            return [];
        }

        $output['products_list'] = $products->getByIds( $this->products_ids );
        $i = $f = $s = 0;

        foreach ( $output['products_list'] as $item ) {
            if ( !isset($output['categories'][ $item['category']['id'] ]) ) {
                $i++;

                $output['categories'][ $item['category']['id'] ]['num'] = $i;
                $output['categories'][ $item['category']['id'] ]['class'] = $i == 1 ? ' compare-tab-active' : '';
                $output['categories'][ $item['category']['id'] ]['data'] = $item['category'];
                $output['categories'][ $item['category']['id'] ]['data']['link'] = Products_category::getLink([
                                                                                        'field' => 'slug',
                                                                                        'value' => $item['category']['slug']
                                                                                    ]);
                $output['categories'][ $item['category']['id'] ]['characteristics_names'] = [];
                $output['categories'][ $item['category']['id'] ]['mobile']['first']['list'] = [];
                $output['categories'][ $item['category']['id'] ]['mobile']['second']['list'] = [];
            }

            if ( !empty($item['characteristics']) ) {
                foreach ( $item['characteristics'] as $char ) {
                    $output['categories'][ $item['category']['id'] ]['characteristics_names'][ $char['id'] ] = $char;
                }
            }

            $output['categories'][ $item['category']['id'] ]['list'][] = $item;
        }

        foreach ( $output['categories'] as &$category ) {
            foreach ( $category['list'] as $key => $item ) {
                if ( $key < intval(count($category['list']) / 2) || count($category['list']) == 1 ) {
                    $item['num'] = $f++;
                    $category['mobile']['first']['count'] = $item['num'];
                    $category['mobile']['first']['list'][] = $item;
                } else {
                    $item['num'] = $s++;
                    $category['mobile']['second']['count'] = $item['num'];
                    $category['mobile']['second']['list'][] = $item;
                }
            }
        }

        return $output;
    }

    public function toggle():bool
    {
        if ( $this->isInCompare( $this->product_id ) ) {
            $this->remove();
            return false;
        }

        $this->add();
        return true;
    }

    public function add()
    {
        $this->products_ids[] = $this->product_id;
        $this->updateHash();
    }

    public function isInCompare( int $product_id ):bool
    {
        if ( in_array($product_id, $this->products_ids) ) {
            return true;
        }

        return false;
    }

    public function remove():bool
    {
        if ( empty($this->products_ids) || array_search($this->product_id, $this->products_ids) === false ) {
            return false;
        }

        $key_for_remove = array_search($this->product_id, $this->products_ids);
        unset( $this->products_ids[ $key_for_remove < 1 ? '0' : $key_for_remove ] );
        $this->updateHash();
        return true;
    }

    public function getCount():int
    {
        return count( $this->products_ids );
    }

    public function clear()
    {
        $this->products_ids = [];
        $this->updateHash();
    }

    private function updateHash()
    {
        $this->products_ids = array_values($this->products_ids);
        $products_ids = json_encode($this->products_ids);

        if( empty( $this->products_ids ) || json_last_error() ) {
            $_SESSION[ self::HASH_NAME ] = json_encode([]);
            return;
        }

        $_SESSION[ self::HASH_NAME ] = $products_ids;
    }
}
