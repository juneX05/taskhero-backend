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
        $old_assigned_tags = self::removeOldTags($task);

        $new_tags = self::getNewTags($tags);
        $tags_ids = $new_tags['ids'];

        $result = self::processNewTags($tags_ids, $task->id);
        if(!$result['status']) return $result;

        $new_assigned_tags = $new_tags['list'];
        logInfo(__FUNCTION__,[
            'actor_id' => $task->urid,
            'actor' => Tasks::class,
            'action_description' => 'Manage Task Assigned Users',
            'old_data' => json_encode($old_assigned_tags),
            'new_data' => json_encode($new_assigned_tags),
        ],'MANAGE-ASSIGNED-USERS');

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
        $new_tags_query = Tags_Model::whereIn('urid', $new_tags);
        $new_assigned_tags_ids = $new_tags_query->pluck('id');

        return [
            'ids' => $new_assigned_tags_ids,
            'list' => $new_tags_query->pluck('title')
        ];
    }

}
