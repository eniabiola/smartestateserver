<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateResidentAPIRequest;
use App\Http\Requests\API\UpdateResidentAPIRequest;
use App\Http\Resources\ResidentResource;
use App\Jobs\createNewResidentInvoice;
use App\Jobs\sendResidentWelcomeMail;
use App\Mail\GeneralMail;
use Illuminate\Auth\Events\Registered;
use App\Mail\sendResidentWelcomeMail as ResidentMail;
use App\Models\Billing;
use App\Models\Estate;
use App\Models\Resident;
use App\Models\User;
use App\Models\Wallet;
use App\Repositories\ResidentRepository;
use App\Repositories\UserRepository;
use App\Services\UploadService;
use App\Services\UtilityService;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
        if (Auth::user()->hasrole('superadministrator'))
        {
            if ($request->get('estate_id') == null) return $this->sendError("What estate residents will you love to see");
            $estate_id = $request->get('estate_id');
        } else {
            $estate_id = \request()->user()->estate_id;
        }
        $search_request = $request->search ?? null;
        $search = $this->residentRepository->getDataTableSearchParams($search_request);
        $residents = Resident::query()
            ->join('users', 'users.id', 'residents.user_id')
            ->whereHas('user', function ($query) use ($estate_id){
                $query->where('users.estate_id', $estate_id);
            })
            ->select('residents.*')
            ->when($search != null, function ($query) use($search_request, $search){
                $query->where(function($query) use($search_request, $search){
                    foreach($search as $key => $value) {
                        if (in_array($key, $this->residentRepository->getFieldsSearchable())) {
                            $query->orWhere($key, 'LIKE', '%'.$value.'%');
                        }
                    }
                });
            })
            ->orderBy('residents.created_at', 'DESC');
        /*    return $residents->get();
        $residents = $this->residentRepository
            ->searchFields($residents, $request->search ?? null);*/
        return $this->sendResponse(ResidentResource::collection($residents->paginate(20))->response()->getData(true), 'Residents retrieved successfully');
    }

    /**
     * Store a newly created Resident in storage.
     * POST /residents
     *
     * @param CreateResidentAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateResidentAPIRequest $request, UserRepository $userRepository, UploadService $uploadService)
    {
        try {
            DB::beginTransaction();
            $userInput = $request->safe()->only(['surname', 'othernames', 'phone', 'gender', 'email', 'password']);
            $userInput['password'] = bcrypt($request->password);
            $input = $request->safe()->only(['meterNo', 'houseNo', 'street_id']);
            $estate = Estate::where('estateCode', $request->estateCode)->first();
//            return $estate;
            $userInput['estate_id'] = $estate->id;


            if ($request->has('imageName') && $request->imageName != null){
                $imageUploadAction = $uploadService->uploadImageBase64($request->imageName, "userImages/");
                if($imageUploadAction['status'] === false){
                    $message = "The file upload must be an image!";
                    $statuscode = 400;
                    return $this->failedResponse($message, $statuscode);
                }
                $filename = $imageUploadAction['data'];
            } else {
                $filename = "default.jpg";
            }
            $userInput['imageName'] = $filename;
            $userInput['isActive'] = false;
//            return $userInput;
            $user = $userRepository->create($userInput);
//            return $user;
            $user->assignRole('resident');

            $input['user_id'] = $user->id;
            $input['estate_id'] = $estate->id;
            $input['estate_id'] = $estate->id;
            $details = [
                "email" => $user->email,
                "estate" =>  $estate->name,
                "surname" => $user->surname,
                "othernames" => $user->othernames,
            ];
            $resident = $this->residentRepository->create($input);


            $wallet = new Wallet();
            $wallet->prev_balance = 0.00;
            $wallet->amount = 0.00;
            $wallet->current_balance = 0.00;
            $wallet->transaction_type = "opening";
            $wallet->user_id = $user->id;
            $wallet->save();
            DB::commit();

            $user->sendEmailVerificationNotification();
            $email = new ResidentMail($details);
            Mail::to($details['email'])->queue($email);
            $details = [
                "subject" => "New User Alert",
                "name" => $user->surname. " ".$user->othernames,
                "message" => "Dear {$estate->name} administrator, there is a new resident waiting for activation.",
                "email" => $estate->email
            ];
            $email = new GeneralMail($details);
            Mail::to($details['email'])->queue($email);
            createNewResidentInvoice::dispatch($user);

            return $this->sendResponse(new ResidentResource($resident), 'Your account has been successfully created and an email has been sent to verify your email.');
        } catch (\Exception $th)
        {
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
    public function update($id, UpdateResidentAPIRequest $request, UserRepository $userRepository, UploadService $uploadService)
    {
        $input = $request->all();

        /** @var Resident $resident */
        $resident = $this->residentRepository->find($id);

        $resident = Resident::find($id);
        $user = $userRepository->find($resident->user_id);
        if (empty($resident)) {
            return $this->sendError('Resident not found');
        }
        if ($request->has('imageName') && $request->imageName != null){
            $imageUploadAction = $uploadService->uploadImageBase64($request->imageName, "userImages/");
            if($imageUploadAction['status'] === false){
                $message = "The file upload must be an image!";
                $statuscode = 400;
                return $this->failedResponse($message, $statuscode);
            }
            $filename = $imageUploadAction['data'];
//            return $filename;
            $uploadService->deleteImage($user->imageName, "userImages/");
        } else {
            $filename = $user->imageName;
        }
        $userInput = $request->safe()->only(['surname', 'othernames', 'phone', 'gender', 'email']);
        $userInput['imageName'] = $filename;
        $input = $request->safe()->only(['meterNo', 'houseNo', 'street_id']);

        $resident = Resident::find($id);
        $user = $userRepository->update($userInput, $resident->user_id);
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

    public function changeUserStatus(Request $request, UserAPIController $userAPIController)
    {
        $this->validate($request, [
            'id' => 'required|integer|exists:residents,id',
        ]);

        $user = Resident::query()
            ->join('users', 'users.id', 'residents.user_id')
            ->where('residents.id', '=', $request->id)
            ->first();

        return $userAPIController->toggleStatus($request);
    }


}
