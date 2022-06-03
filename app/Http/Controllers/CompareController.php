<?php

namespace App\Http\Controllers;

use App\Models\Compare;
use App\Models\Menu;
use App\Models\Products_category;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function index()
    {
        $main_data = $this->getMainData();
        $main_data['logo'] = '/img/logo-dark.png';

        $compare = new Compare();

        return view('catalog.compare', [
            'page_data'     => $compare->index(),
            'main_data'     => $main_data,
            'top_menu'      => Menu::getMenu(),
            'catalog_menu'  => Products_category::get(),
            'main_class'    => '',
            'header_class'  => 'page',
        ]);
    }
}
