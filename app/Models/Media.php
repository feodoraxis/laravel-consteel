<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    /**
     * @param int $media_id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getThumbnailData(int $media_id)
    {
        $object = self::query()->where('id', '=', $media_id)->first();

        $array = json_decode($object, true);

        if ( !empty($array) && !json_last_error() ) {
            return $array;
        } else {
            return [];
        }
    }

    public static function getByIds( array $ids ) {
        return self::query()->whereIn('id', $ids)->get();
    }
}
