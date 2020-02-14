<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = Category::all();
        return $this->apiResponse($users, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->validated();

        $category = new Category();
        $category->uuid = Str::uuid();
        $category->name = $data['name'];
        $category->description = $data['description'];
        $category->image = $data['image'] ?? null;
        $category->status = $data['status'] ?? '1';
        $category->save();

        return $this->apiResponse($category, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $category = $this->getCategory($id);

        return $this->apiResponse($category, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryRequest $request
     * @param int             $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = $this->getCategory($id);
        $data = $request->validated();

        $category->name = $data['name'];
        $category->description = $data['description'];
        $category->image = isset($data['image']) && !empty($data['status']) ? $data['image'] : $category->image;
        $category->status = isset($data['status']) && !empty($data['status']) ? $data['status'] : $category->status;
        $category->save();

        return $this->apiResponse($category, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $response = $category = $this->getCategory($id);
        $category->delete();

        return $this->apiResponse($response, Response::HTTP_OK);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse|Category
     */
    private function getCategory($id)
    {
        try {
            return Category::whereUuid($id)->firstOrFail();
        } catch (NotFoundHttpException $e) {
            return $this->apiResponse(
                $this->errorResponse(1001, 'Category not found'),
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
