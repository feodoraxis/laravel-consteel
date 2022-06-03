<?php

namespace App\Http\Controllers;

use App\Models\Ajax;
use App\Models\Compare;
use App\Models\Products;
use App\Http\Requests;
use App\Models\Products_category;

class AjaxController extends Controller
{
    private $form;
    private $products;
    private $products_list;

    private $ajax;

    public function __construct ()
    {
        $this->ajax = new Ajax();
    }

    public function index()
    {
        $msg = "This is a simple message.";
        return response()->json(array('msg'=> $msg), 200);
    }

    /**
     * @return bool
     */
    private function catalogBefore():bool
    {
        if ( $_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['form']) ) {
            return false;
        }

        $this->form = $_POST['form'];

        $this->products = new Products;
        $this->products->setCurrentPage(intval($this->form['current_page']) ?? 2);

        return true;
    }

    /**
     * @return string
     */
    private function catalogAfter():string
    {
        if ( empty($this->products_list) ) {
            return '';
        }

        return Products_category::renderCatalog( $this->products_list );
    }

    /**
     * @return string
     */
    public function catalog():string
    {
        if ( $this->catalogBefore() === false ) {
            return '';
        }

        $this->products_list = $this->products->getListByCategoryId( intval($this->form['category']) );
        return $this->catalogAfter();
    }

    /**
     * @return string
     */
    public function searchLoad():string
    {
        if ( $this->catalogBefore() === false ) {
            return '';
        }

        $this->products_list = $this->products->getListBySearchRequest( $this->form['request'] );
        return $this->catalogAfter();
    }

    public function search()
    {
        if ( $_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['form']) ) {
            return;
        }

        $form = $_POST['form'];

        $products = new Products;
        $data = $products->getListBySearchRequest($form['request'], true);
        return $products->listRenderSearchPreview($data);
    }

    /**
     * @return string
     */
    public function filter():string
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

    /**
     * @return string
     */
    public function compareToggle():string
    {
        return $this->ajax->compareToggle();
    }

    public function compareClear():string
    {
        return $this->ajax->compareClear();
    }
}
