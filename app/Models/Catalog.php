<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use HasFactory;

    /**
     * @param $slug
     * @return array
     */
    public static function category( $slug ):array
    {
        $Products_category = new Products_category;
        $Products = new Products;

        $category_data = $Products_category->getBySlug($slug);

        return [
            'category_data' => $category_data,
            'filter' => $Products->filterRender($category_data['id']),
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
