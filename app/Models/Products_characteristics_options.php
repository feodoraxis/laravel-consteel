<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products_characteristics_options extends Model
{
    use HasFactory;

    public static function getTableName():string
    {
        return (new self())->getTable();
    }

    public static function getByIds( array $ids ):array
    {
        if ( empty($ids) ) {
            return [];
        }

        $result = self::query()
            ->whereIn('id', $ids)
            ->get();

        $result = json_decode($result, true);

        if ( empty($result) || json_last_error() ) {
            return [];
        }

        return $result;
    }
}
