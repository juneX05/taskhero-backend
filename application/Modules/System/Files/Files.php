<?php

namespace Application\Modules\System\Files;

use Application\Modules\Core\Media\Media;
use Application\Modules\Core\Media\Media_Actions;

class Files
{
    const TABLE = 'files';
    const PATH = 'Files';

    const COLUMNS = [
        ['name' => 'id', 'type' => 'integer', 'auto_increment' => true, ],
        ['name' => 'project_id', 'type' => 'integer', 'fillable' => true, 'nullable' => true],
        ['name' => 'task_id', 'type' => 'integer', 'fillable' => true, 'nullable' => true],
        ['name' => 'step_id', 'type' => 'integer', 'fillable' => true, 'nullable' => true],
        ['name' => 'media_id', 'type' => 'integer', 'fillable' => true, 'nullable' => false],
    ];

    public static function saveFile($data, $column, $id) {
        $media_result = Media::saveFile($data);
        if (!$media_result['status']) return $media_result;

        $file_data['media_id'] = $media_result['id'];
        $file_data[$column] = $id;

        $file_result = Files_Model::create($file_data);
        if (!$file_result) {
            \Log::info('Failed to save File ->' . json_encode($data));
            return ['status' => false, 'error' => 'Failed to save file'];
        }

        return ['status' => true];
    }

//    public static function saveFiles($data) {
//        foreach ($data as $file) {
//            $result = self::saveFile($file);
//            if (!$result['status']) return ['status' => false, 'error' => 'Failed to save file ->' . json_encode($file)];
//        }
//
//        return ['status' => true];
//    }
}
