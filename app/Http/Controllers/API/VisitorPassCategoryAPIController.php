<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateVisitorPassCategoryAPIRequest;
use App\Http\Requests\API\UpdateVisitorPassCategoryAPIRequest;
use App\Models\VisitorPassCategory;
use App\Repositories\VisitorPassCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class VisitorPassCategoryController
 * @package
 */

class VisitorPassCategoryAPIController extends AppBaseController
{
    /** @var  VisitorPassCategoryRepository */
    private $visitorPassCategoryRepository;

    public function __construct(VisitorPassCategoryRepository $visitorPassCategoryRepo)
    {
        $this->visitorPassCategoryRepository = $visitorPassCategoryRepo;
    }

    /**
     * Display a listing of the VisitorPassCategory.
     * GET|HEAD /visitorPassCategories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $visitorPassCategories = $this->visitorPassCategoryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($visitorPassCategories->toArray(), 'Visitor Pass Categories retrieved successfully');
    }

    /**
     * Store a newly created VisitorPassCategory in storage.
     * POST /visitorPassCategories
     *
     * @param CreateVisitorPassCategoryAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateVisitorPassCategoryAPIRequest $request)
    {
        $input = $request->all();

        $visitorPassCategory = $this->visitorPassCategoryRepository->create($input);

        return $this->sendResponse($visitorPassCategory->toArray(), 'Visitor Pass Category saved successfully');
    }

    /**
     * Display the specified VisitorPassCategory.
     * GET|HEAD /visitorPassCategories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var VisitorPassCategory $visitorPassCategory */
        $visitorPassCategory = $this->visitorPassCategoryRepository->find($id);

        if (empty($visitorPassCategory)) {
            return $this->sendError('Visitor Pass Category not found');
        }

        return $this->sendResponse($visitorPassCategory->toArray(), 'Visitor Pass Category retrieved successfully');
    }

    /**
     * Update the specified VisitorPassCategory in storage.
     * PUT/PATCH /visitorPassCategories/{id}
     *
     * @param int $id
     * @param UpdateVisitorPassCategoryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVisitorPassCategoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var VisitorPassCategory $visitorPassCategory */
        $visitorPassCategory = $this->visitorPassCategoryRepository->find($id);

        if (empty($visitorPassCategory)) {
            return $this->sendError('Visitor Pass Category not found');
        }

        $visitorPassCategory = $this->visitorPassCategoryRepository->update($input, $id);

        return $this->sendResponse($visitorPassCategory->toArray(), 'VisitorPassCategory updated successfully');
    }

    /**
     * Remove the specified VisitorPassCategory from storage.
     * DELETE /visitorPassCategories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var VisitorPassCategory $visitorPassCategory */
        $visitorPassCategory = $this->visitorPassCategoryRepository->find($id);

        if (empty($visitorPassCategory)) {
            return $this->sendError('Visitor Pass Category not found');
        }

        $visitorPassCategory->delete();

        return $this->sendSuccess('Visitor Pass Category deleted successfully');
    }
}
