<?php
namespace Application\Modules;

use Application\Modules\Core\Logs\Logs_Actions;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    private $record_urid;
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->urid) {
                $model->urid = sha1(hrtime(true));
            }
        });

//        static::saved( function (Model $model) {
//            $data['actor'] = $model->getTable();
//            $data['actor_id'] = $model->urid;
//            $data['action_type'] = 'CREATED';
//            $data['action_type'] = 'CREATE';
//            $data['action_name'] = 'CREATED';
//            Logs_Actions::saveQuickLog();
//        });

    }
}
