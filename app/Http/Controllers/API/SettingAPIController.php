<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSettingAPIRequest;
use App\Http\Requests\API\UpdateSettingAPIRequest;
use App\Models\Setting;
use App\Repositories\SettingRepository;
use Crystoline\LaraRestApi\ISchoolFileUpload;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class SettingController
 * @package
 */

class SettingAPIController extends AppBaseController
{
    /** @var  SettingRepository */
    private $settingRepository;

    public function __construct(SettingRepository $settingRepo)
    {
        $this->settingRepository = $settingRepo;
    }

    /**
     * Display a listing of the Setting.
     * GET|HEAD /settings
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $settings = Setting::settings();

        return $this->sendResponse($settings, 'Settings retrieved successfully');
    }

    /**
     * Store a newly created Setting in storage.
     * POST /settings
     *
     * @param CreateSettingAPIRequest $request
     *
     * @return Response
     */

    public function store(Request $request)
    {

        /**@var Setting* */
        $rules = Setting::getValidationRules();
        $data = $request->validate($rules);
        /*$validator = Validator::make($request->all(), $rules);
        $data = $validator->validated();*/
        $validSettings = array_keys($rules);

        foreach ($data as $key => $val) {
            if ($request->hasFile($key) and $request->file($key)->isValid()) {

                //validate file extension
                /* $file = $request->file($key);
                 $ext = $file->getClientOriginalExtension();
                 if (!in_array($ext, ["jpg, jpeg"])) {
                     throw new BamsException("Image must be in jpg");
                 }*/
                $original = setting($key);

                $interfaces = class_implements(self::class);
                $base = (isset($interfaces[ISchoolFileUpload::class])) ? self::fileBasePath($request) : '';
                if ($base) {
                    $base = trim($base, '/,\\') . '/';
                }
                $path = $request->$key->store('public/' . $base . $key);
                $path = str_replace('public/', 'storage/', $path);

                $val = asset($path);
                if ($original) {
                    // $original_path = str_replace('public/', 'storage/', $original);
                    //Storage::delete($original_path);
                }

            }
            if (in_array($key, $validSettings)) {

                if (!is_null($val)) {
                    Setting::set($key, $val, Setting::getDataType($key));
                }
            }
        }

        $s = self::getAllSettings();
        return response()->json($s, 201);
    }

    /**
     * Display the specified Setting.
     * GET|HEAD /settings/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Setting $setting */
        $setting = $this->settingRepository->find($id);

        if (empty($setting)) {
            return $this->sendError('Setting not found');
        }

        return $this->sendResponse($setting->toArray(), 'Setting retrieved successfully');
    }

    /**
     * Update the specified Setting in storage.
     * PUT/PATCH /settings/{id}
     *
     * @param int $id
     * @param UpdateSettingAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSettingAPIRequest $request)
    {
        $input = $request->all();

        /** @var Setting $setting */
        $setting = $this->settingRepository->find($id);

        if (empty($setting)) {
            return $this->sendError('Setting not found');
        }

        $setting = $this->settingRepository->update($input, $id);

        return $this->sendResponse($setting->toArray(), 'Setting updated successfully');
    }

    /**
     * Remove the specified Setting from storage.
     * DELETE /settings/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Setting $setting */
        $setting = $this->settingRepository->find($id);

        if (empty($setting)) {
            return $this->sendError('Setting not found');
        }

        $setting->delete();

        return $this->sendSuccess('Setting deleted successfully');
    }


    public static function getAllSettings()
    {
        $setting = Setting::settings();
        $s = [];
        foreach ($setting as $section) {
            foreach ($section['elements'] as $element) {
                $name = $element['name'];
                $value = setting($name);
                $s[$name] = $value;
            }
        }
        return $s;
    }
}
