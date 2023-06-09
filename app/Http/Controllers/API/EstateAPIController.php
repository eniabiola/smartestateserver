<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateEstateAPIRequest;
use App\Http\Requests\API\UpdateEstateAPIRequest;
use App\Http\Resources\EstateResource;
use App\Jobs\sendUserwelcomeJob;
use App\Mail\UserWelcomeMail;
use App\Models\Estate;
use App\Models\User;
use App\Repositories\EstateRepository;
use App\Repositories\UserRepository;
use App\Services\UploadService;
use App\Services\UtilityService;
use App\Traits\FlutterPaymentTrait;
use http\Url;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Response;

/**
 * Class EstateController
 * @package App\Http\Controllers\API
 */

class EstateAPIController extends AppBaseController
{
    use FlutterPaymentTrait;
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
     * Display a listing of the Estate.
     * GET|HEAD /estates
     *
     * @param Request $request
     * @return Response
     */
    public function indexPaginate(Request $request)
    {
        $estates = $this->estateRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );
        $estates = Estate::query()->orderBy('name', 'ASC');
        return $this->sendResponse(EstateResource::collection($estates->paginate(20))->response()->getData(true), 'Estates retrieved successfully');
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
        // check for image and upload or give default name
        if ($request->has('imageName') && $request->imageName != null){
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

        $request->merge(['imageName' => $filename, 'status' => 'active',
            'estateCode' => $utilityService->generateCode(6), 'country_id' => 156]);
        $input = $request->all();
//        return $input;
        DB::beginTransaction();
        $estate = $this->estateRepository->create($input);
        $password = $utilityService->generateCode(6);

        // Generate estate admin
        $user = User::firstOrCreate([
            "surname" => $estate->contactPerson,
            "othernames" => "",
            "phone" =>$request->contactphone,
            "email" => $estate->contactemail,
            "password" =>  bcrypt($password),
            "estate_id" => $estate->id,
            "isActive" => true,
        ]);

        //Set estate admin Role

        DB::commit();
        $details = [
          "name" => $request->contactPerson,
          "estate_name" => $request->name,
          "email" => $request->contactemail,
          "message" => "An account has been created for you as the estate manager of $request->name estate",
          "password" => $password,
          "url"      => url('/')."/auth/login",
          "from"    => $request->mail_slug
        ];

        $email = new UserWelcomeMail($details);
        Mail::to($details['email'])->queue($email);

        $fields = [
            "account_bank" => $estate->bank->bank_code,
            "account_number" => $estate->accountNumber,
            "business_name" => $estate->accountName,
            "business_email" => $estate->email,
            "business_contact" => $estate->phone,
            "business_contact_mobile" => $estate->phone,
            "business_mobile" => $estate->phone,
            "country" => "NG"
        ];

        $profile_estate_account = $this->profileAccount($fields, $estate->id);
        logger(print_r($profile_estate_account, 1));
        if ($profile_estate_account['status'])
        {
            $message = "Estate saved and account successfully created";
        } else {
            $message = "Estate saved and account creation failed";
        }
        //Job to create estate account
        return $this->sendResponse( new EstateResource($estate), $message);
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
    public function update($id, UpdateEstateAPIRequest $request, UploadService $uploadService, UserRepository $userRepository)
    {

        /** @var Estate $estate */
        $estate = $this->estateRepository->find($id);

        if (empty($estate)) {
            return $this->sendError('Estate not found');
        }

        if ($request->has('imageName') && $request->imageName != null){
            $imageUploadAction = $uploadService->uploadImageBase64($request->imageName, "estateImages/");
            if($imageUploadAction['status'] === false){
                $message = "The file upload must be an image!";
                $statuscode = 400;
                return $this->failedResponse($message, $statuscode);
            }
            $filename = $imageUploadAction['data'];
//            return $filename;
            $uploadService->deleteImage($estate->imageName, "estateImages/");
        } else {
            $filename = $estate->imageName;
        }
        $request->merge(['imageName' => $filename]);
        $input = $request->all();

        $estate = $this->estateRepository->update($input, $id);
//        $user = $userRepository->create();
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
