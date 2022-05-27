<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Menu;
use App\Models\Products;
use App\Models\Products_category;

class CatalogController extends Controller
{
    public function search()
    {
        $main_data = $this->getMainData();
        $main_data['logo'] = '/img/logo-dark.png';

        return view('catalog.search', [
            'page_data'     => Products::search(),

            'main_data'     => $main_data,
            'top_menu'      => Menu::getMenu(),
            'catalog_menu'  => Products_category::get(),
            'main_class'    => '',
            'header_class'  => 'page',
        ]);
    }

    public function category($slug)
    {
        $main_data = $this->getMainData();
        $main_data['logo'] = '/img/logo-dark.png';

        return view('catalog.category', [
            'breadcrumbs'   => Catalog::breadcrumbs($slug),
            'subcategories' => Catalog::subcategories($slug),
            'page_data'     => Catalog::category($slug),
            'main_data'     => $main_data,
            'top_menu'      => Menu::getMenu(),
            'catalog_menu'  => Products_category::get(),
            'main_class'    => '',
            'header_class'  => 'page',
        ]);
    }

    public function detail($slug, $product)
    {

        $main_data = $this->getMainData();
        $main_data['logo'] = '/img/logo-dark.png';

        return view('catalog.detail', [
            'breadcrumbs'   => Catalog::breadcrumbs($slug),
            'subcategories' => Catalog::subcategories($slug),
            'main_data'     => $main_data,
            'top_menu'      => Menu::getMenu(),
            'catalog_menu'  => Products_category::get(),
            'main_class'    => 'main__page product',
            'header_class'  => 'page',
            'page_data'     => Catalog::product($product),
        ]);
    }
}
