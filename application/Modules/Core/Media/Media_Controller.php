<?php

namespace Application\Modules\Core\Media;

use Application\Modules\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Media_Controller extends BaseController
{

    public function view($urid)
    {
        return Media_Actions::viewFile($urid);
    }

}
