<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateComplainCategoryAPIRequest;
use App\Http\Requests\API\UpdateComplainCategoryAPIRequest;
use App\Http\Resources\ComplainCategoryResource;
use App\Models\ComplainCategory;
use App\Repositories\ComplainCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Response;

/**
 * Class ComplainCategoryController
 * @package
 */

class ComplainCategoryAPIController extends AppBaseController
{
    /** @var  ComplainCategoryRepository */
    private $complainCategoryRepository;

    public function __construct(ComplainCategoryRepository $complainCategoryRepo)
    {
        $this->complainCategoryRepository = $complainCategoryRepo;
    }

    /**
     * Display a listing of the ComplainCategory.
     * GET|HEAD /complainCategories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $complainCategories = $this->complainCategoryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ComplainCategoryResource::collection($complainCategories), 'Complain Categories retrieved successfully');
    }

    /**
     * Store a newly created ComplainCategory in storage.
     * POST /complainCategories
     *
     * @param CreateComplainCategoryAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateComplainCategoryAPIRequest $request)
    {
        $request->merge(['estate_id' => Auth::user()->estate_id, 'status' => 'active']);
        $input = $request->all();

        $complainCategory = $this->complainCategoryRepository->create($input);

        return $this->sendResponse(new ComplainCategoryResource($complainCategory), 'Complain Category saved successfully');
    }

    /**
     * Display the specified ComplainCategory.
     * GET|HEAD /complainCategories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ComplainCategory $complainCategory */
        $complainCategory = $this->complainCategoryRepository->find($id);

        if (empty($complainCategory)) {
            return $this->sendError('Complain Category not found');
        }

        return $this->sendResponse(new ComplainCategoryResource($complainCategory), 'Complain Category retrieved successfully');
    }

    /**
     * Update the specified ComplainCategory in storage.
     * PUT/PATCH /complainCategories/{id}
     *
     * @param int $id
     * @param UpdateComplainCategoryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:complain_categories,name,'.$id
        ]);
        $input = $request->all();

        /** @var ComplainCategory $complainCategory */
        $complainCategory = $this->complainCategoryRepository->find($id);

        if (empty($complainCategory)) {
            return $this->sendError('Complain Category not found');
        }

        $complainCategory = $this->complainCategoryRepository->update($input, $id);

        return $this->sendResponse(new ComplainCategoryResource($complainCategory), 'ComplainCategory updated successfully');
    }

    /**
     * Remove the specified ComplainCategory from storage.
     * DELETE /complainCategories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ComplainCategory $complainCategory */
        $complainCategory = $this->complainCategoryRepository->find($id);

        if (empty($complainCategory)) {
            return $this->sendError('Complain Category not found');
        }

        $complainCategory->delete();

        return $this->sendSuccess('Complain Category deleted successfully');
    }
}
