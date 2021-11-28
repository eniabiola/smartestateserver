<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateNotificationGroupAPIRequest;
use App\Http\Requests\API\UpdateNotificationGroupAPIRequest;
use App\Models\NotificationGroup;
use App\Repositories\NotificationGroupRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Response;

/**
 * Class NotificationGroupController
 * @package
 */

class NotificationGroupAPIController extends AppBaseController
{
    /** @var  NotificationGroupRepository */
    private $notificationGroupRepository;

    public function __construct(NotificationGroupRepository $notificationGroupRepo)
    {
        $this->notificationGroupRepository = $notificationGroupRepo;
    }

    /**
     * Display a listing of the NotificationGroup.
     * GET|HEAD /notificationGroups
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $notificationGroups = $this->notificationGroupRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($notificationGroups->toArray(), 'Notification Groups retrieved successfully');
    }

    /**
     * Store a newly created NotificationGroup in storage.
     * POST /notificationGroups
     *
     * @param CreateNotificationGroupAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateNotificationGroupAPIRequest $request)
    {
        $request->merge(['estate_id' => request()->user()->estate_id]);
        $input = $request->all();

        $notificationGroup = $this->notificationGroupRepository->create($input);
        $notificationGroup->users()->sync($request->users);

        return $this->sendResponse($notificationGroup->toArray(), 'Notification Group saved successfully');
    }

    /**
     * Display the specified NotificationGroup.
     * GET|HEAD /notificationGroups/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var NotificationGroup $notificationGroup */
        $notificationGroup = $this->notificationGroupRepository->find($id);

        if (empty($notificationGroup)) {
            return $this->sendError('Notification Group not found');
        }

        return $this->sendResponse($notificationGroup->toArray(), 'Notification Group retrieved successfully');
    }

    /**
     * Update the specified NotificationGroup in storage.
     * PUT/PATCH /notificationGroups/{id}
     *
     * @param int $id
     * @param UpdateNotificationGroupAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNotificationGroupAPIRequest $request)
    {
        $input = $request->all();

        /** @var NotificationGroup $notificationGroup */
        $notificationGroup = $this->notificationGroupRepository->find($id);

        if (empty($notificationGroup)) {
            return $this->sendError('Notification Group not found');
        }

        $notificationGroup = $this->notificationGroupRepository->update($input, $id);

        return $this->sendResponse($notificationGroup->toArray(), 'NotificationGroup updated successfully');
    }

    /**
     * Remove the specified NotificationGroup from storage.
     * DELETE /notificationGroups/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var NotificationGroup $notificationGroup */
        $notificationGroup = $this->notificationGroupRepository->find($id);

        if (empty($notificationGroup)) {
            return $this->sendError('Notification Group not found');
        }

        $notificationGroup->delete();

        return $this->sendSuccess('Notification Group deleted successfully');
    }
}
