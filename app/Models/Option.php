<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    /**
     * @param string $slug
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    static public function getOptionBySlug(string $slug, bool $only_value = true)
    {
        $result = self::query()->where('slug', $slug)->first();

        if ($only_value) {
            return $result['value'];
        }

        return $result;
    }

    /**
     * @return array
     */
    static public function getMainOptionsList():array
    {
        $to_return = [];
        $results = self::query()
                            ->where('slug', '=', 'phone')
                            ->orWhere('slug', '=', 'email')
                            ->orWhere('slug', '=', 'email-support')
                            ->orWhere('slug', '=', 'copyright')
                            ->get();

        foreach ($results as $result) {
            $to_return[ $result['slug'] ] = $result['link'] ?? $result['value'];
        }

        return $to_return;
    }
}
