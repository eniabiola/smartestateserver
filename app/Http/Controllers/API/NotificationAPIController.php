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
use App\Services\DatatableService;
use App\Services\UploadService;
use Carbon\Carbon;
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

    public function indexDataTable(Request $request, DatatableService $datatableService)
    {
        $date_from = $request->query('date_from') != "null" && $request->query('date_from') != "" ? $request->query('date_from') : null;
        $date_to = $request->query('date_to') != "null" && $request->query('date_to') != "" ? $request->query('date_to') : null;
        $street = $request->query('guest_name') != "null" && $request->query('guest_name') != "" ? $request->query('date_from') : null;
        $status = $request->query('status') != "null" && $request->query('date_to') != "" ? $request->query('date_to') : null;

        $search = [];
        $processedRequest = $datatableService->processRequest($request);
        $search_request = $processedRequest['search'];

        $search = $this->notificationRepository->getDataTableSearchParams($processedRequest, $search_request);

        $builder = $this->notificationRepository->builderBasedOnRole('notifications.estate_id', $request->get('estate_id'))
            ->join('users', 'users.id', 'notifications.created_by')
            ->leftJoin('estates', 'estates.id', 'notifications.estate_id')
            ->select('notifications.*',
                'estates.name AS estates__dot__name',
            )
            ->when($search_request != null, function ($query) use($search_request, $search){
                $query->where(function($query) use($search_request, $search){
                    foreach($search as $key => $value) {
                        if (in_array($key, $this->notificationRepository->getFieldsSearchable())) {
                            $query->orWhere($key, 'LIKE', '%'.$value.'%');
                        }
                    }
                });
            })
            ->when(!is_null($date_from) && !is_null($date_to), function ($query) use($date_from, $date_to){
                $from = Carbon::parse($date_from)->startOfDay()->format("Y-m-d H:i:s");
                $to = Carbon::parse($date_to)->endOfDay()->format("Y-m-d H:i:s");
                $query->whereBetween("visitor_passes.created_at", [$from, $to]);
            })
            ->when(!is_null($status), function ($query) use($status){
                $query->whereBetween("visitorPasss.isActive", $status);
            });

        $columns = $this->notificationRepository->getTableColumns();
        array_push($columns, "users.surname", "users.othernames", "users.phone", "users.email");

        return $datatableService->dataTable2($request, $builder, [
            '*',
            'file_path' => function(Notification $notification){
                return $notification->file ? Storage::url('notificationImages/' .$notification->file) : null;
            },
            'created_by_user' => function (Notification $notification){
                return $notification->createdBy->surname." ".$notification->createdBy->othernames;
            },
            'estate' => function (Notification $notification){
                return $notification->estate->name;
            },
            'receiver' => function (Notification $notification){
                return $notification->receiver_id != null ? $notification->receiver : null;
            },
            'group' => function (Notification $notification){
                return $notification->group_id != null ? $notification->group : null;
            },
            'street' => function (Notification $notification){
                return $notification->street_id != null ? $notification->group : null;
            },
            'created_at' => function (Notification $notification){
                return date("Y-m-d h:i:s a", strtotime($notification->created_at));
            },
            'action' => function (Notification $notification) {

                return "
                <div class='datatable-actions'> <div class='text-center'> <div class='dropdown'> <button class='btn btn-primary dropdown-toggle button' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Actions </button> <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> <button class='dropdown-item'   id='details__$notification->id' type='button'> Details</button> <button id='edit__$notification->id' class='dropdown-item' type='button'> Edit </button> </div> </div> </div> </div>
                ";
            }
        ], $columns);
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
                $message = "Only images and PDF are supported.!";
                $statuscode = 400;
                return $this->sendError($message, $statuscode);
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
