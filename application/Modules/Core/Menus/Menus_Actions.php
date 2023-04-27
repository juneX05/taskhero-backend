<?php


namespace Application\Modules\Core\Menus;


use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Menus_Actions
{
    private static $ACTOR = 'Menus';

    public static function index() {
//        if (denied('manage_menus')) return error('Forbidden', 403);

        try {
            $data = \DB::table('menus', 'm')
                ->leftJoin('menus as me', 'm.parent', '=', 'me.id')
                ->leftJoin('permissions', 'permissions.name','=','m.permission_name')
                ->orderBy('m.position')
                ->where(['m.status_id' => 1])
                ->get(['m.*', 'me.title as parent_menu', 'permissions.title as permission']);

            return success('Success', $data);
        } catch (Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    private static function validate($data, $record = null) {
        $rules = [
            'name' => ['required', 'string',],
            'title' => ['required', 'string'],
            'icon' => ['required', 'string'],
            'link' => ['nullable', 'string'],
            'parent' => ['nullable', 'integer'],
            'type' => ['required', 'string'],
            'category' => ['nullable', 'string'],
            'auth' => ['nullable', 'integer'],
            'sidebar_visibility' => ['nullable', 'integer'],
            'navbar_visibility' => ['nullable', 'integer'],
            'file_link' => ['nullable', 'string'],
            'permission_name' => ['nullable', 'string'],
        ];

        if ($record == null) {
            $rules['name'][] = Rule::unique('menus');
            $rules['title'][] = Rule::unique('menus');
        } else {
            $rules['name'][] = Rule::unique('menus')->ignore($record->id);
            $rules['title'][] = Rule::unique('menus')->ignore($record->id);
        }

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return ['status' => false, 'error' => $validator->errors()];
        }

        return ['status' => true, 'data' => $validator->validated()];
    }

    private static function validateUpdatePositions($data) {
        $rules = [
            'referred_after_urid' => ['required', 'string'],
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return ['status' => false, 'error' => $validator->errors()];
        }

        return ['status' => true, 'data' => $validator->validated()];
    }

    public static function saveMenu($data) {
        if (denied('manage_menus')) return error('Forbidden', 403);

        try {
            $validation = self::validate($data);
            if(!$validation['status']) return sendValidationError($validation['error']);

            $data = $validation['data'];
            $item = Menus_Model::create($data);

            if (!$item) {
                return error('Failed to save menu', 500);
            }

            $item->position = $item->id;
            $saved = $item->save();

            if (!$saved) {
                return error('Failed to set position', 500);
            }

            logInfo(__FUNCTION__,[
                'actor_id' => $item->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Save Menu',
                'old_data' => null,
                'new_data' => json_encode($item),
            ],'SAVE-MENU');

            return success('Menu saved Successfully', $item);
        } catch (Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    public static function getParentMenus() {
        if (denied('manage_menus')) return error('Forbidden', 403);

        try{
            $data = Menus_Model
                ::whereNull('parent')
                ->whereType('link')
                ->whereStatusId(1)
                ->get();

            return success('Success', $data);
        }
        catch (Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    public static function sidebarMenus() {
        return Menus_Model
            ::whereSidebarVisibility(1)
            ->whereStatusId(1)
            ->orderBy('position')
            ->get();
    }

    public static function getSidebarMenus() {
        try{
            $data = self::sidebarMenus();

            return success('Success', $data);
        }
        catch (Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    public static function getMenuRoutes() {
        try{
            $data = Menus_Model::whereNotNull('link')
                ->where('link',  '!=', '#')
                ->whereStatusId(1)
                ->get();

            return success('Success', $data);
        }
        catch (Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    public static function updateMenu($data) {
        if (denied('manage_menus')) return error('Forbidden', 403);

        try {
            $record = Menus_Model::whereUrid($data['urid'])->first();
            if (!$record) return error('Record not found', 404);

            $validation = self::validate($data, $record);
            if(!$validation['status']) return sendValidationError($validation['error']);

            $data = $validation['data'];

            $old_data = $record->toArray();

            $updated = $record->update($data);

            if (!$updated) return error('Failed to update record', 500);

            logInfo(__FUNCTION__,[
                'actor_id' => $record->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Update Menu',
                'old_data' => json_encode($old_data),
                'new_data' => json_encode($record),
            ],'UPDATE-MENU');

            return success('Success', $data);
        } catch (Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    public static function deleteMenu($data) {
        if (denied('manage_menus')) return error('Forbidden', 403);

        try {
            $model = Menus_Model::whereUrid($data['urid'])->first();
            if (!$model) return error('Record Not Found', 404);

            $old_data = $model->toArray();

            $updated = $model->update([
                'status_id' => 2
            ]);

            if (!$updated) return error('Failed to delete record', 500);

            logInfo(__FUNCTION__,[
                'actor_id' => $model->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Delete Menu',
                'old_data' => json_encode($old_data),
                'new_data' => json_encode($model),
            ],'DELETE-MENU');

            return success('Success', $model);
        } catch (Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    public static function updatePositions($data) {
        if (denied('manage_menus')) return error('Forbidden', 403);

        try {
            $model = Menus_Model
                ::whereUrid($data['urid'])
                ->first();

            if (!$model) return error('Menu Not found', 404);

            $validation = self::validateUpdatePositions($data);
            if(!$validation['status']) return sendValidationError($validation['error']);

            $data = $validation['data'];

            $referred_after_menu = Menus_Model
                ::whereUrid($data['referred_after_urid'])
                ->first();

            if (!$referred_after_menu)
                return error('Menu Not found', 404);

            $menus = Menus_Model::all();
            foreach ($menus as $menu) {
                if ( $menu->position > $referred_after_menu->position) {
                    $referred_menu = Menus_Model::whereUrid($menu->urid)->first();

                    $update = $referred_menu->update(['position' => $menu->position + 1]);
                    if (!$update)
                        return error('Failed to update position in menu ' . json_encode($referred_menu->toArray()), 500);
                }
            }

            $update = $model->update(['position' => $referred_after_menu->position + 1]);
            if (!$update)
                return error('Failed to update position in menu ' . json_encode($model->toArray()), 500);

            $new_menus = Menus_Model::all();

            logInfo(__FUNCTION__,[
                'actor_id' => $model->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Update Menu Positions',
                'old_data' => json_encode($menus),
                'new_data' => json_encode($new_menus),
            ],'UPDATE-MENU_POSITIONS');

            return success('Success', $model);
        } catch (Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }
}
