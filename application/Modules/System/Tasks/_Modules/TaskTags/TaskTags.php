<?php

namespace Application\Modules\System\Tasks\_Modules\TaskTags;

use Application\Modules\Core\Status\Status;
use Application\Modules\System\Tasks\_Modules\Tags\Tags_Model;
use Application\Modules\System\Tasks\Tasks;

class TaskTags
{
    const TABLE = 'task_tags';
    const PATH = 'Tasks/_Modules/TaskTags';

    const COLUMNS = [
        [
            'name' => 'id',
            'type' => 'integer',
            'primary_key' => true,
            'auto_increment' => true,
        ],
        [
            'name' => 'task_id',
            'type' => 'integer',
            'fillable' => true,
        ],
        [
            'name' => 'tag_id',
            'type' => 'integer',
            'fillable' => true,
        ],
    ];

    public static function manageTags($task, $tags) {
        self::removeOldTags($task);

        $tags_ids = self::getNewTags($tags);

        $result = self::processNewTags($tags_ids, $task->id);
        if(!$result['status']) return $result;

        return ['status' => true];
    }

    private static function processNewTags($ids, $task_id) {
        foreach ($ids as $tag) {
            $data = [
                'task_id' => $task_id,
                'tag_id' => $tag,
            ];

            $result = TaskTags_Model::create($data);
            if (!$result) return [
                'status' => false,
                'error' => "Failed to add tag ${$data['tag_id']} to task"
            ];
        }

        return ['status' => true];
    }


    private static function removeOldTags($task) {
        $old_assigned_tags = $task->tags()->get(['tags.title'])->pluck('title');
        TaskTags_Model
            ::where('task_id',$task->id)
            ->delete();

        return $old_assigned_tags;
    }

    private static function getNewTags($tags) {
        $new_tags = gettype($tags) == 'string'
            ? explode(",",$tags)
            : $tags;

        return Tags_Model::whereIn('urid', $new_tags)
            ->pluck('id');
    }

}
