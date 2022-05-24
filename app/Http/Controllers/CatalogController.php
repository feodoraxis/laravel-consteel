<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Menu;
use App\Models\Products_category;

class CatalogController extends Controller
{
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
}
