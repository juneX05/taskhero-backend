<?php

namespace Application\Modules\System\Projects\_Modules\ProjectBoards;


class ProjectBoards
{
    const TABLE = 'project_boards';
    const PATH = 'Projects/_Modules/ProjectBoards';

    const COLUMNS = [
        ['name' => 'id', 'type' => 'integer', 'auto_increment' => true, ],
        ['name' => 'project_id', 'type' => 'integer', 'fillable' => true,],
        ['name' => 'name', 'type' => 'string', 'fillable' => true,],
        ['name' => 'title', 'type' => 'string', 'fillable' => true,],
        ['name' => 'description', 'type' => 'long_text', 'fillable' => true,],
    ];

    private static function relations() {
        return [

        ];
    }

    public static function getRecord($urid) {
        return ProjectBoards_Model
            ::whereUrid($urid)
            ->with(self::relations())->first();
    }

}
