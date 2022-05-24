<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    use HasFactory;

    /**
     * @param int $page_id
     * @param array|string[] $select
     * @return array
     */
    static public function getPageData(int $page_id, array $select = ['id', 'name', 'slug', 'content', 'meta', 'meta_description', 'meta_keywords']):array
    {
        $to_return = [];
        $result = self::query()
            ->select($select)
            ->where("id", $page_id)
            ->first();

        foreach ($result->attributes as $key => $item) {
            if ($key == 'content' || $key == 'meta') {
                $to_return[$key] = json_decode($item, true);
            } else {
                $to_return[$key] = $item;
            }
        }

        return $to_return;
    }

    static public function getFrontPage():array
    {
        $result = self::query()
            ->select(['content'])
            ->where("id", 1)
            ->first();

        $content = json_decode($result->attributes['content'], true);

        if (!empty($content['second_section']['categories']) && is_array($content['second_section']['categories'])) {
            $Products_category = new Products_category();
            $content['second_section']['categories'] = $Products_category->getByIds($content['second_section']['categories']);
        }

        if (!empty($content['projects']['projects_ids']) && is_array($content['projects']['projects_ids'])) {
            $Cases = new Cases();
            $content['projects']['list'] = $Cases->getByIds($content['projects']['projects_ids']);
        }

        if (!empty($content['prefers']['prefers_with_icons']) && is_array($content['prefers']['prefers_with_icons'])) {
            $icons = $prefers_with_icons = [];

            foreach ( $content['prefers']['prefers_with_icons'] as $key => $item ) {
                $icons[] = $item['icon_id'];
                $prefers_with_icons[ $item['icon_id'] ]['title'] = $item['title'];
            }

            $json = Media::getByIds($icons);
            $icons = json_decode($json, true);

            foreach ( $icons as $item ) {
                $prefers_with_icons[ $item['id'] ]['icon'] = $item;
            }

            $content['prefers']['prefers_with_icons'] = $prefers_with_icons;

        }

        return $content;
    }
}
