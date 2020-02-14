<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

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
        $this->fillData($category, $data, 'store');
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
        $data = $request->validated();
        $category = $this->getCategory($id);
        $this->fillData($category, $data, 'update');
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
        return Category::whereUuid($id)->firstOrFail();
    }

    /**
     * @param Category $model
     * @param array $data
     * @param string $action
     *
     * @return void
     */
    private function fillData(&$model, $data, $action)
    {
        $model->name = $data['name'];
        $model->description = $data['description'];
        $model->image = isset($data['image']) && !empty($data['image'])
            ? $data['image']
            : ($action === 'store' ? null : $model->image);
        $model->status = isset($data['status']) && !empty($data['status'])
            ? $data['status']
            : ($action === 'store' ? '1' : $model->status);
    }
}
