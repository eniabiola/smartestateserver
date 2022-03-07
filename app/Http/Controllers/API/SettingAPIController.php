<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSettingAPIRequest;
use App\Http\Requests\API\UpdateSettingAPIRequest;
use App\Models\Setting;
use App\Repositories\SettingRepository;
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


   /*     $settings = $this->settingRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );*/

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
    public function store(CreateSettingAPIRequest $request)
    {
        $request->merge(['estate_id' => \request()->user()->estate_id]);
        $input = $request->all();

        $setting = $this->settingRepository->create($input);

        return $this->sendResponse($setting->toArray(), 'Setting saved successfully');
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
}
