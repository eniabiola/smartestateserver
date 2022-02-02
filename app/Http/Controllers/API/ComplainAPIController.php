<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateComplainAPIRequest;
use App\Http\Requests\API\UpdateComplainAPIRequest;
use App\Http\Resources\ComplainAPIResource;
use App\Http\Resources\ComplainCollection;
use App\Http\Resources\ComplainNotification;
use App\Mail\GeneralMail;
use App\Models\Complain;
use App\Models\ComplainCategory;
use App\Repositories\ComplainRepository;
use App\Services\UploadService;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Response;

/**
 * Class ComplainController
 * @package
 */

class ComplainAPIController extends AppBaseController
{
    /** @var  ComplainRepository */
    private $complainRepository;

    public function __construct(ComplainRepository $complainRepo)
    {
        $this->complainRepository = $complainRepo;
    }

    /**
     * Display a listing of the Complain.
     * GET|HEAD /complains
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $complains = $this->complainRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );
        $search = $request->get('search');
        $estate_id = $request->get('estate_id');
        $complains = $this->complainRepository->paginateViewBasedOnRole('20', ['*'], $search, $estate_id);

        return $this->sendResponse(ComplainAPIResource::collection($complains)->response()->getData(true), 'Complains retrieved successfully');
    }

    /**
     * Display a listing of the Invoice based on a particular user.
     * GET|HEAD /complains_per_user/{user_id}
     *
     * @param Request $request
     * @param user_id
     * @return Response
     */
    public function userIndex(Request $request, $user_id)
    {
        $search = $request->get('search');
        $estate_id = $request->get('estate_id');
        $invoices = $this->complainRepository->paginateViewBasedOnUser('20', ['*'], $search, $estate_id, $user_id);

        return $this->sendResponse(ComplainAPIResource::collection($invoices)->response()->getData(true), 'Invoices retrieved successfully');
    }

    /**
     * Store a newly created Complain in storage.
     * POST /complains
     *
     * @param CreateComplainAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateComplainAPIRequest $request, UploadService $uploadService)
    {
        $user = Auth::user();
        $ticket_id = Complain::query()->orderBy('created_at', 'DESC')->first()->id ?? 0;
        $ticket_id = "".str_pad($ticket_id+1, 5, '0', STR_PAD_LEFT);

        if ($request->has('file') && $request->file != null){
            $imageUploadAction = $uploadService->uploadDocBase64($request->file, "complainImages/");
            if($imageUploadAction['status'] === false){
                $message = "Only images and PDF are supported.!";
                $statuscode = 400;
                return $this->sendError($message, $statuscode);
            }
            $filename = $imageUploadAction['data'];
        } else {
            $filename = null;
        }
        $complain_category = ComplainCategory::find($request->complain_category_id);
        $request->merge(['user_id' => $user->id, 'estate_id' => $user->estate_id,
                         'ticket_no' => $ticket_id, 'status' => "active",
                         'file' => $filename]);
        $input = $request->all();

        $user = \request()->user();
        if (!empty($complain_category->email) and !is_null($complain_category->email))
        {
            $details = [
                "subject" => "Raised complaint",
                "name" => "Administrator",
                "message" => "{$user->surname} {$user->othernames} has a complain as regards {$complain_category->name}.",
                "email" => $complain_category->email,
                "url" => "https://vgcpora.baloshapps.com/auth/login",
                "button_text" => "Login to view Complain",
            ];
            $email = new GeneralMail($details);
            Mail::to($details['email'])->queue($email);
        }
        $complain = $this->complainRepository->create($input);

        return $this->sendResponse(new ComplainAPIResource($complain), 'Complain sent successfully');
    }

    /**
     * Display the specified Complain.
     * GET|HEAD /complains/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Complain $complain */
        $complain = $this->complainRepository->find($id);

        if (empty($complain)) {
            return $this->sendError('Complain not found');
        }

        return $this->sendResponse(new ComplainAPIResource($complain), 'Complain retrieved successfully');
    }

    /**
     * Update the specified Complain in storage.
     * PUT/PATCH /complains/{id}
     *
     * @param int $id
     * @param UpdateComplainAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateComplainAPIRequest $request, UploadService $uploadService)
    {
        /** @var Complain $complain */
        $complain = $this->complainRepository->find($id);

        if (empty($complain)) {
            return $this->sendError('Complain not found');
        }

        if ($request->has('file') && $request->file != null){
            $imageUploadAction = $uploadService->uploadImageBase64($request->file, "estateImages/");
            if($imageUploadAction['status'] === false){
                $message = "The file upload must be an image!";
                $statuscode = 400;
                return $this->failedResponse($message, $statuscode);
            }
            $filename = $imageUploadAction['data'];
//            return $filename;
            $uploadService->deleteImage($complain->imageName, "complainImages/");
        } else {
            $filename = $complain->imageName;
        }
        $request->merge(['file' => $filename]);

        $input = $request->all();
        $complain = $this->complainRepository->update($input, $id);

        return $this->sendResponse(new ComplainAPIResource($complain), 'Complain updated successfully');
    }

    /**
     * Remove the specified Complain from storage.
     * DELETE /complains/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Complain $complain */
        $complain = $this->complainRepository->find($id);

        if (empty($complain)) {
            return $this->sendError('Complain not found');
        }

        $complain->delete();

        return $this->sendSuccess('Complain deleted successfully');
    }

    public function closeComplain(Request $request, $id)
    {
        /** @var Complain $complain */
        $complain = $this->complainRepository->find($id);

        if (empty($complain)) {
            return $this->sendError('Complain not found');
        }

        $complain->status = "closed";
        $complain->save();
        return $this->sendResponse(new ComplainAPIResource($complain), 'Complain closed successfully');

    }
}
