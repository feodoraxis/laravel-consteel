<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pages;
use App\Models\Products_category;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $main_data = $this->getMainData();
        $top_menu = Menu::getMenu();
        $catalog_menu = Products_category::get();

        $main_data['logo'] = '/img/logo-white.png';

        $page_data = Pages::getFrontPage();

        return view('layouts.index', [
            'main_data' => $main_data,
            'top_menu' => $top_menu,
            'catalog_menu' => $catalog_menu,
            'page_data' => $page_data,
            'main_class' => '',
            'header_class' => 'front',
        ]);
    }
}
