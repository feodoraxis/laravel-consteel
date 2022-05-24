<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Products_category;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function contacts(Request $request)
    {
        $main_data = $this->getMainData();
        $top_menu = Menu::getMenu();
        $catalog_menu = Products_category::get();

        $main_data['logo'] = '/img/logo-dark.png';

        return view('layouts.contacts', [
            'main_data' => $main_data,
            'top_menu' => $top_menu,
            'catalog_menu' => $catalog_menu,
            'main_class' => 'main__page',
            'header_class' => 'page'
        ]);
    }
}
