<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    /**
     * @param string $position
     * @return array
     */
    static public function getMenu(string $position = 'top') : array
    {
        $to_return = [];
        $result = self::query()
                ->where('position', '=', 'top')
                ->first();

        $menu = json_decode($result['menu'], true);

        if (empty($menu)) {
            return [];
        }

        foreach ($menu as $item) {
            $to_return[] = [
                'title' => $item['0'],
                'link' => $item['1'],
            ];
        }

        return $to_return;
    }
}
