<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use HasFactory;

    const SEARCH_VARCHAR_NAME = 'search';

    public static function search():array
    {
        $output = [
            'list' => [],
            'count' => '0',
            'search_request' => '',
        ];

        if ( !isset($_REQUEST[ self::SEARCH_VARCHAR_NAME ]) || empty($_REQUEST[ self::SEARCH_VARCHAR_NAME ]) ) {
            return $output;
        }

        $search_request = htmlspecialchars($_REQUEST[ self::SEARCH_VARCHAR_NAME ]);

        $Products = new Products;

        $output['list']           = $Products->getListBySearchRequest( $search_request );
        $output['count']          = count($output['list']);
        $output['search_request'] = $search_request;
        $output['pagination']     = $Products->paginationBySearchRequest( $search_request );

        return $output;
    }

    /**
     * @string $product_slug
     * @param string $product_slug
     * @return array
     */
    public static function product( string $product_slug ):array
    {
        $Products = new Products;
        return $Products->getBySlug( $product_slug );
    }

    /**
     * @string $slug
     * @param string $slug
     * @return array
     */
    public static function category( string $slug ):array
    {
        $Products_category = new Products_category;
        $Products = new Products;

        $category_data = $Products_category->getBySlug($slug);
        $sort = 'сначала по дешевле';

        if ( isset($_REQUEST['sort'] ) ) {
            switch ($_REQUEST['sort']) {
                case 'price-desc':
                    $sort = 'сначала по дороже';
                    break;
            }
        }

        return [
            'category_data' => $category_data,
            'filter' => $Products->filterRender($category_data['id']),
            'sort' => $sort,
            'csrf' => csrf_token(),
            'products' => Products_category::renderCatalog( $Products->getListByCategoryId($category_data['id']) ),
            'pagination' => $Products->pagination($category_data['id']),
            'category_id' => $category_data['id'],
        ];
    }

    static public function subcategories( string $category_slug ):string
    {
        return Products_category::subcategories($category_slug);
    }

    /**
     * @param string $category_slug
     * @return string
     */
    public static function breadcrumbs( string $category_slug ):string
    {
        return Products_category::breadcrumbs($category_slug);
    }
}
