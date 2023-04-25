<?php

namespace Application\Modules\System\Projects\Actions;

use Application\Modules\System\Projects\Projects_Model;

class GetProjectDetails
{
    public static function boot($urid) {
        if (denied('view_project_details')) return sendError('Forbidden', 500);

        try {
            $record = Projects_Model
                ::with(['category','priority','assignees', 'media'])
                ->where('urid', $urid)
                ->first();

            if (!$record) {
                return sendError('Record Not found', 404);
            }

            return sendResponse('Success', $record);
        } catch (\Exception $exception) {
            return sendError($exception->getMessage(), 500);
        }
    }
}
