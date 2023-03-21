<?php

namespace Application\Modules\System\Tasks\_Modules\Tags;

class Tags
{
    const TABLE = 'tags';
    const PATH = 'Tasks/_Modules/Tags';

    const COLUMNS = [
        [
            'name' => 'id',
            'type' => 'integer',
            'primary_key' => true,
            'auto_increment' => false,
        ],
        [
            'name' => 'title',
            'type' => 'string',
            'fillable' => true,
        ],
    ];

}
