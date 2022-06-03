<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ajax extends Model
{
    use HasFactory;

    /**
     * @return string
     */
    public function compareToggle():string
    {
        $output = [
            'result' => 'removed'
        ];

        if ( !isset($_POST['form']['id']) ) {
            return json_encode($output);
        }

        $id = intval($_POST['form']['id']);

        $compare = new Compare();
        $compare->setProduct( $id );
        $result = $compare->toggle();

        if ( $result === true ) {
            $output['result'] = 'added';
        }

        return json_encode($output);
    }

    public function compareClear():string
    {
        $output = [
            'result' => 'success'
        ];

        $compare = new Compare();
        $compare->clear();

        return json_encode($output);
    }
}
