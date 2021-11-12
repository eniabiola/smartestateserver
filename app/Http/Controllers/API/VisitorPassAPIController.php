<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateVisitorPassAPIRequest;
use App\Http\Requests\API\UpdateVisitorPassAPIRequest;
use App\Models\VisitorPass;
use App\Repositories\VisitorPassRepository;
use App\Services\UtilityService;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class VisitorPassController
 * @package
 */

class VisitorPassAPIController extends AppBaseController
{
    /** @var  VisitorPassRepository */
    private $visitorPassRepository;

    public function __construct(VisitorPassRepository $visitorPassRepo)
    {
        $this->visitorPassRepository = $visitorPassRepo;
    }

    /**
     * Display a listing of the VisitorPass.
     * GET|HEAD /visitorPasses
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $visitorPasses = $this->visitorPassRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($visitorPasses->toArray(), 'Visitor Passes retrieved successfully');
    }

    /**
     * Store a newly created VisitorPass in storage.
     * POST /visitorPasses
     *
     * @param CreateVisitorPassAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateVisitorPassAPIRequest $request, UtilityService $utilityService)
    {
        $request->merge(['generatedCode' => $utilityService->generateCode(6)]);
        $request->merge(['generatedDate' => date('Y-m-d H:i:s')]);
        $input = $request->all();

        $visitorPass = $this->visitorPassRepository->create($input);

        return $this->sendResponse($visitorPass->toArray(), 'Visitor Pass saved successfully');
    }

    /**
     * Display the specified VisitorPass.
     * GET|HEAD /visitorPasses/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var VisitorPass $visitorPass */
        $visitorPass = $this->visitorPassRepository->find($id);

        if (empty($visitorPass)) {
            return $this->sendError('Visitor Pass not found');
        }

        return $this->sendResponse($visitorPass->toArray(), 'Visitor Pass retrieved successfully');
    }

    /**
     * Update the specified VisitorPass in storage.
     * PUT/PATCH /visitorPasses/{id}
     *
     * @param int $id
     * @param UpdateVisitorPassAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVisitorPassAPIRequest $request)
    {
        $input = $request->all();

        /** @var VisitorPass $visitorPass */
        $visitorPass = $this->visitorPassRepository->find($id);

        if (empty($visitorPass)) {
            return $this->sendError('Visitor Pass not found');
        }

        $visitorPass = $this->visitorPassRepository->update($input, $id);

        return $this->sendResponse($visitorPass->toArray(), 'VisitorPass updated successfully');
    }

    /**
     * Remove the specified VisitorPass from storage.
     * DELETE /visitorPasses/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var VisitorPass $visitorPass */
        $visitorPass = $this->visitorPassRepository->find($id);

        if (empty($visitorPass)) {
            return $this->sendError('Visitor Pass not found');
        }

        $visitorPass->delete();

        return $this->sendSuccess('Visitor Pass deleted successfully');
    }
}
