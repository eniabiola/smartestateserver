<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateStreetAPIRequest;
use App\Http\Requests\API\UpdateStreetAPIRequest;
use App\Models\Street;
use App\Repositories\StreetRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class StreetController
 * @package
 */

class StreetAPIController extends AppBaseController
{
    /** @var  StreetRepository */
    private $streetRepository;

    public function __construct(StreetRepository $streetRepo)
    {
        $this->streetRepository = $streetRepo;
    }

    /**
     * Display a listing of the Street.
     * GET|HEAD /streets
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $streets = $this->streetRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($streets->toArray(), 'Streets retrieved successfully');
    }

    /**
     * Store a newly created Street in storage.
     * POST /streets
     *
     * @param CreateStreetAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateStreetAPIRequest $request)
    {

        $request->merge(['estate_id' => \request()->user()->estate_id]);
        $input = $request->all();

        $street = $this->streetRepository->create($input);

        return $this->sendResponse($street->toArray(), 'Street saved successfully');
    }

    /**
     * Display the specified Street.
     * GET|HEAD /streets/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Street $street */
        $street = $this->streetRepository->find($id);

        if (empty($street)) {
            return $this->sendError('Street not found');
        }

        return $this->sendResponse($street->toArray(), 'Street retrieved successfully');
    }

    /**
     * Update the specified Street in storage.
     * PUT/PATCH /streets/{id}
     *
     * @param int $id
     * @param UpdateStreetAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStreetAPIRequest $request)
    {
        $input = $request->all();

        /** @var Street $street */
        $street = $this->streetRepository->find($id);

        if (empty($street)) {
            return $this->sendError('Street not found');
        }

        $street = $this->streetRepository->update($input, $id);

        return $this->sendResponse($street->toArray(), 'Street updated successfully');
    }

    /**
     * Remove the specified Street from storage.
     * DELETE /streets/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Street $street */
        $street = $this->streetRepository->find($id);

        if (empty($street)) {
            return $this->sendError('Street not found');
        }

        $street->delete();

        return $this->sendSuccess('Street deleted successfully');
    }
}
