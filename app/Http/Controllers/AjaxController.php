<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Http\Requests;
use App\Models\Products_category;

class AjaxController extends Controller
{
    public function index()
    {
        $msg = "This is a simple message.";
        return response()->json(array('msg'=> $msg), 200);
    }

    public function catalog()
    {
        $form = $_POST['form'];

        $Products = new Products;
        $Products->setCurrentPage(intval($form['current_page']) ?? 2);
        $products = $Products->getListByCategoryId(intval($form['category']));

        if ( empty($products) ) {
            return '';
        }

        return Products_category::renderCatalog( $products );
    }

    public function filter()
    {
        $category = intval($_POST['category']);
        $global_filter = $_POST['global_filter'];

        $Products = new Products;
        $Products->setCurrentPage(1);
        $products = $Products->getListByCategoryId($category, $global_filter);

        if ( empty($products) ) {
            return '';
        }

        return Products_category::renderCatalog( $products );
    }
}
