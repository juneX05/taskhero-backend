<?php

namespace Application\Modules\Core\Logs;

use Application\Modules\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Logs_Controller extends BaseController
{

    public function view($module, $urid)
    {
        return Logs::pullHistory($urid);
    }

}
