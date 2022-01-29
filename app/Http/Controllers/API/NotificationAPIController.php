<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateNotificationAPIRequest;
use App\Http\Requests\API\UpdateNotificationAPIRequest;
use App\Http\Resources\NotificationCollection;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\UserCollection;
use App\Jobs\sendNotificationMessages;
use App\Models\Notification;
use App\Repositories\NotificationRepository;
use App\Services\UploadService;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class NotificationController
 * @package
 */

class NotificationAPIController extends AppBaseController
{
    /** @var  NotificationRepository */
    private $notificationRepository;

    public function __construct(NotificationRepository $notificationRepo)
    {
        $this->notificationRepository = $notificationRepo;
    }

    /**
     * Display a listing of the Notification.
     * GET|HEAD /notifications
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $estate_id = $request->get('estate_id');
        $notifications = $this->notificationRepository->paginateViewBasedOnRole('20', ['*'], $search, $estate_id);

        return $this->sendResponse(NotificationResource::collection($notifications)->response()->getData(true), 'Notifications retrieved successfully');
    }

    /**
     * Store a newly created Notification in storage.
     * POST /notifications
     *
     * @param CreateNotificationAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateNotificationAPIRequest $request, UploadService $uploadService)
    {
        if ($request->has('file') && $request->file != null){
            $imageUploadAction = $uploadService->uploadImageBase64($request->file, "notificationImages/");
            if($imageUploadAction['status'] === false){
                $message = "The file upload must be an image!";
                $statuscode = 400;
                return $this->failedResponse($message, $statuscode);
            }
            $filename = $imageUploadAction['data'];
        } else {
            $filename = null;
        }

        $request->merge(['file' => $filename, 'created_by' => request()->user()->id, 'estate_id' => request()->user()->estate_id]);

        $input = $request->all();

        $notification = $this->notificationRepository->create($input);

        return $this->sendResponse(new NotificationResource($notification), 'Notification saved successfully');
    }

    /**
     * Display the specified Notification.
     * GET|HEAD /notifications/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Notification $notification */
        $notification = $this->notificationRepository->find($id);

        if (empty($notification)) {
            return $this->sendError('Notification not found');
        }

        return $this->sendResponse(new NotificationResource($notification), 'Notification retrieved successfully');
    }

    /**
     * Update the specified Notification in storage.
     * PUT/PATCH /notifications/{id}
     *
     * @param int $id
     * @param UpdateNotificationAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNotificationAPIRequest $request, UploadService $uploadService)
    {

        /** @var Notification $notification */
        $notification = $this->notificationRepository->find($id);


        if ($request->has('file') && $request->file != null){
            $imageUploadAction = $uploadService->uploadImageBase64($request->file, "notificationImages/");
            if($imageUploadAction['status'] === false){
                $message = "The file upload must be an image!";
                $statuscode = 400;
                return $this->failedResponse($message, $statuscode);
            }
            $filename = $imageUploadAction['data'];
//            return $filename;
            $uploadService->deleteImage($notification->file, "notificationImages/");
        } else {
            $filename = $notification->imageName;
        }
        $request->merge(['file' => $filename]);
        $input = $request->all();

        if (empty($notification)) {
            return $this->sendError('Notification not found');
        }

        $notification = $this->notificationRepository->update($input, $id);

        return $this->sendResponse(new NotificationResource($notification), 'Notification updated successfully');
    }

    /**
     * Remove the specified Notification from storage.
     * DELETE /notifications/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Notification $notification */
        $notification = $this->notificationRepository->find($id);

        if (empty($notification)) {
            return $this->sendError('Notification not found');
        }

        $notification->delete();

        return $this->sendSuccess('Notification deleted successfully');
    }

    public function sendNotificationMessages(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer|exists:notifications,id'
        ]);

        sendNotificationMessages::dispatch($request->id);

        return $this->sendSuccess("Your message has been sent");

    }
}
