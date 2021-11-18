<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateEstateAPIRequest;
use App\Http\Requests\API\UpdateEstateAPIRequest;
use App\Http\Resources\EstateResource;
use App\Models\Estate;
use App\Repositories\EstateRepository;
use App\Services\UploadService;
use App\Services\UtilityService;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class EstateController
 * @package App\Http\Controllers\API
 */

class EstateAPIController extends AppBaseController
{
    /** @var  EstateRepository */
    private $estateRepository;

    public function __construct(EstateRepository $estateRepo)
    {
        $this->estateRepository = $estateRepo;
    }

    /**
     * Display a listing of the Estate.
     * GET|HEAD /estates
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $estates = $this->estateRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(EstateResource::collection($estates), 'Estates retrieved successfully');
    }

    /**
     * Store a newly created Estate in storage.
     * POST /estates
     *
     * @param CreateEstateAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateEstateAPIRequest $request, UploadService $uploadService, UtilityService $utilityService)
    {
        if ($request->has('imageName')){

            $imageUploadAction = $uploadService->uploadImageBase64($request->imageName, "estateImages/");
            if($imageUploadAction['status'] === false){
                $message = "The file upload must be an image!";
                $statuscode = 400;
                return $this->failedResponse($message, $statuscode);
            }
            $filename = $imageUploadAction['data'];
        } else {
            $filename = "default.jpg";
        }
        $request->merge(['imageName' => $filename, 'status' => 'active', 'estateCode' => $utilityService->generateCode(6)]);
        $input = $request->all();
        $estate = $this->estateRepository->create($input);

        return $this->sendResponse( new EstateResource($estate), 'Estate saved successfully');
    }

    /**
     * Display the specified Estate.
     * GET|HEAD /estates/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Estate $estate */
        $estate = $this->estateRepository->find($id);

        if (empty($estate)) {
            return $this->sendError('Estate not found');
        }

        return $this->sendResponse(new EstateResource($estate), 'Estate retrieved successfully');
    }

    /**
     * Update the specified Estate in storage.
     * PUT/PATCH /estates/{id}
     *
     * @param int $id
     * @param UpdateEstateAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEstateAPIRequest $request, UploadService $uploadService)
    {

        /** @var Estate $estate */
        $estate = $this->estateRepository->find($id);

        if (empty($estate)) {
            return $this->sendError('Estate not found');
        }

        if ($request->has('imageName')){
            $imageUploadAction = $uploadService->uploadImageBase64($request->imageName, "estateImages/");
            if($imageUploadAction['status'] === false){
                $message = "The file upload must be an image!";
                $statuscode = 400;
                return $this->failedResponse($message, $statuscode);
            }
            $filename = $imageUploadAction['data'];
            $uploadService->deleteImage($estate->imageName, "estateImages/");
        } else {
            $filename = $estate->imageName;
        }
        $request->merge(['imageName', $filename]);
        $input = $request->all();

        $estate = $this->estateRepository->update($input, $id);

        return $this->sendResponse($estate->toArray(), 'Estate updated successfully');
    }

    /**
     * Remove the specified Estate from storage.
     * DELETE /estates/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Estate $estate */
        $estate = $this->estateRepository->find($id);

        if (empty($estate)) {
            return $this->sendError('Estate not found');
        }

        $estate->delete();

        return $this->sendSuccess('Estate deleted successfully');
    }



    public function validateEstateCode(Request $request)
    {
        $this->validate($request, [
            'estate_code' => 'required|exists:estates,estateCode'
        ]);
        $estate = Estate::where('estateCode', $request->estate_code)->first();

        return $this->sendResponse($estate->toArray(), 'Estate successfully retrieved');
    }

    public function toggleStatus(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:users,id'
        ]);
        return $this->sendResponse(new EstateResource($this->estateRepository->toggleStatus($request->id)), "Estate status successfully toggled.");
    }
}
