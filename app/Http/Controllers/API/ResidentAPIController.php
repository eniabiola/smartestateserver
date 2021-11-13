<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateResidentAPIRequest;
use App\Http\Requests\API\UpdateResidentAPIRequest;
use App\Http\Resources\ResidentResource;
use App\Models\Estate;
use App\Models\Resident;
use App\Repositories\ResidentRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\DB;
use Response;

/**
 * Class ResidentController
 * @package App\Http\Controllers\API
 */

class ResidentAPIController extends AppBaseController
{
    /** @var  ResidentRepository */
    private $residentRepository;

    public function __construct(ResidentRepository $residentRepo)
    {
        $this->residentRepository = $residentRepo;
    }

    /**
     * Display a listing of the Resident.
     * GET|HEAD /residents
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $residents = $this->residentRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ResidentResource::collection($residents) , 'Residents retrieved successfully');
    }

    /**
     * Store a newly created Resident in storage.
     * POST /residents
     *
     * @param CreateResidentAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateResidentAPIRequest $request, UserRepository $userRepository)
    {
        try {
            DB::beginTransaction();
            $userInput = $request->safe()->only(['surname', 'othernames', 'phone', 'gender', 'email', 'password']);
            $userInput['password'] = bcrypt($request->password);
            $input = $request->safe()->only(['meterNo', 'dateMovedIn', 'houseNo', 'street']);
            $estate_id = Estate::where('estateCode', $request->estateCode)->first()->id;
            $userInput['estate_id'] = $estate_id;

            $user = $userRepository->create($userInput);
            $user->assignRole('resident');

            $input['user_id'] = $user->id;

            $resident = $this->residentRepository->create($input);
            DB::commit();
            return $this->sendResponse(new ResidentResource($resident), 'Resident saved successfully');
        } catch (\Exception $th)
        {
            return $th;
            \Log::debug($th);
            report($th->getMessage());
            return $this->sendError("Resident creation failed", 400);
        }
    }

    /**
     * Display the specified Resident.
     * GET|HEAD /residents/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Resident $resident */
        $resident = $this->residentRepository->find($id);

        if (empty($resident)) {
            return $this->sendError('Resident not found');
        }

        return $this->sendResponse(new ResidentResource($resident), 'Resident retrieved successfully');
    }

    /**
     * Update the specified Resident in storage.
     * PUT/PATCH /residents/{id}
     *
     * @param int $id
     * @param UpdateResidentAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateResidentAPIRequest $request, UserRepository $userRepository)
    {
        $input = $request->all();

        /** @var Resident $resident */
        $resident = $userRepository->find($id);

        if (empty($resident)) {
            return $this->sendError('Resident not found');
        }

        $userInput = $request->safe()->only(['surname', 'othernames', 'phone', 'gender', 'email']);

        $input = $request->safe()->only(['meterNo', 'dateMovedIn', 'houseNo', 'street']);
        $estate_id = Estate::where('estateCode', $request->estateCode)->first()->id;
        $user = $userRepository->update($userInput, $id);
        $input['estate_id'] = $estate_id;
        $resident = Resident::where('user_id', $id)->first();
        $resident = $this->residentRepository->update($input, $resident->id);

        return $this->sendResponse(new ResidentResource($resident), 'Resident updated successfully');
    }

    /**
     * Remove the specified Resident from storage.
     * DELETE /residents/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Resident $resident */
        $resident = $this->residentRepository->find($id);

        if (empty($resident)) {
            return $this->sendError('Resident not found');
        }

        $resident->delete();

        return $this->sendSuccess('Resident deleted successfully');
    }
}
