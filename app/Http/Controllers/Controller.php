<?php

namespace App\Http\Controllers;

use App\Models\Compare;
use App\Models\Option;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getMainData()
    {
        $options = Option::getMainOptionsList();

        $compare = new Compare();
        $options['compare'] = $compare->getCount();

        return $options;
    }
}
