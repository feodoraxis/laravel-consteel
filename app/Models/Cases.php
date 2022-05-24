<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cases extends Model
{
    use HasFactory;

    const PUBLISHED_STATUS = 'published';
    const DRAFT_STATUS = 'draft';
    const TRASH_STATUS = 'trash';

    /**
     * @param array $ids
     * @return array
     */
    public function getByIds( array $ids ) : array
    {
        $result = self::query()
                        ->select([
                            $this->getTable() . '.id',
                            $this->getTable() . '.slug',
                            $this->getTable() . '.name',
                            $this->getTable() . '.thumbnail',
                            $this->getTable() . '.category',
                            $this->getTable() . '.thumbnail',
                            'media.link as preview_thumbnail',
                            'cases_categories.name as category_name',
                            'media.meta'
                        ])
                        ->leftJoin('media',            'media.id',            '=', $this->getTable() . '.thumbnail')
                        ->leftJoin('cases_categories', 'cases_categories.id', '=', $this->getTable() . '.category' )
                        ->whereIn($this->getTable() . '.id', $ids)
                        ->where($this->getTable() . '.status', '=', self::PUBLISHED_STATUS)
                        ->get();


        if ( empty($result) ) {
            return [];
        }

        $return = json_decode($result, true);

        if ( json_last_error() ) {
            return [];
        }

        foreach ($return as &$item) {
            $item['link'] = self::getLink($item['id']);
        }

        unset($item);

        return $return;
    }

    /**
     * @param int $case_id
     * @return string
     */
    public static function getLink( int $case_id ) : string
    {
        return '#';
    }
}
