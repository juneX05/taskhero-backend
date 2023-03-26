<?php

namespace Application\Modules\Core\Media;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Response;

class Media
{
    public static function saveFile(UploadedFile $file) {
        $fileName = hrtime(true) . '.'. $file->clientExtension();
        $file->storeAs('', $fileName, 'uploads');

        $fileModel = new Media_Model();
        $fileModel->name = $fileName;
        $fileModel->original_name = $file->getClientOriginalName();
        $fileModel->extension = '.'.$file->getClientOriginalExtension();
        $fileModel->size = $file->getSize();
        $fileModel->mime_type = $file->getMimeType();
        $fileModel->user_id = request()->user()->id;
        $save = $fileModel->save();

        if ($save) {
            return [
                'status' => true,
                'id' => $fileModel->id
            ];
        }

        return ['status' => false];
    }

    public static function saveFiles($files) {
        $file_ids = [];
        foreach ($files as $file) {
            $file_result = self::saveFile($file);
            if ($file_result['status']) $file_ids[] = $file_result['id'];

            return $file_result;
        }

        return ['status' => true, 'ids' => $file_ids];
    }

    public static function viewFile($urid) {
        $media = Media_Model::whereUrid($urid)->first();
        if (!$media) {
            return '';
        }

        return Response::file(uploads_path() . '/' . $media->name);
    }
}
