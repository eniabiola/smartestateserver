<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateModuleAccessAPIRequest;
use App\Http\Requests\API\UpdateModuleAccessAPIRequest;
use App\Http\Resources\ModuleAccessIndex;
use App\Models\ModuleAccess;
use App\Repositories\ModuleAccessRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ModuleAccessController
 * @package App\Http\Controllers\API
 */

class ModuleAccessAPIController extends AppBaseController
{
    /** @var  ModuleAccessRepository */
    private $moduleAccessRepository;

    public function __construct(ModuleAccessRepository $moduleAccessRepo)
    {
        $this->moduleAccessRepository = $moduleAccessRepo;
    }

    /**
     * Display a listing of the ModuleAccess.
     * GET|HEAD /moduleAccesses
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $moduleAccesses = $this->moduleAccessRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse( ModuleAccessIndex::collection($moduleAccesses), 'Module Accesses retrieved successfully');
    }

    /**
     * Store a newly created ModuleAccess in storage.
     * POST /moduleAccesses
     *
     * @param CreateModuleAccessAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateModuleAccessAPIRequest $request)
    {
        $input = $request->all();

        $moduleAccess = $this->moduleAccessRepository->create($input);

        return $this->sendResponse(new ModuleAccessIndex($moduleAccess), 'Module Access saved successfully');
    }

    /**
     * Display the specified ModuleAccess.
     * GET|HEAD /moduleAccesses/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ModuleAccess $moduleAccess */
        $moduleAccess = $this->moduleAccessRepository->find($id);

        if (empty($moduleAccess)) {
            return $this->sendError('Module Access not found');
        }

        return $this->sendResponse(new ModuleAccessIndex($moduleAccess), 'Module Access retrieved successfully');
    }

    /**
     * Update the specified ModuleAccess in storage.
     * PUT/PATCH /moduleAccesses/{id}
     *
     * @param int $id
     * @param UpdateModuleAccessAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateModuleAccessAPIRequest $request)
    {
        $input = $request->all();

        /** @var ModuleAccess $moduleAccess */
        $moduleAccess = $this->moduleAccessRepository->find($id);

        if (empty($moduleAccess)) {
            return $this->sendError('Module Access not found');
        }

        $moduleAccess = $this->moduleAccessRepository->update($input, $id);

        return $this->sendResponse($moduleAccess->toArray(), 'ModuleAccess updated successfully');
    }

    /**
     * Remove the specified ModuleAccess from storage.
     * DELETE /moduleAccesses/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ModuleAccess $moduleAccess */
        $moduleAccess = $this->moduleAccessRepository->find($id);

        if (empty($moduleAccess)) {
            return $this->sendError('Module Access not found');
        }

        $moduleAccess->delete();

        return $this->sendSuccess('Module Access deleted successfully');
    }
}
