<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = User::all();
        return $this->apiResponse($users, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $user = new User;
        $user->uuid = Str::uuid();
        $this->fillData($user, $data);
        $user->save();
        return $this->apiResponse($user, Response::HTTP_CREATED);
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
        $user = $this->getUser($id);

        return $this->apiResponse($user, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param int         $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request, $id)
    {
        $data = $request->validated();
        $user = $this->getUser($id);
        $this->fillData($user, $data);
        $user->save();

        return $this->apiResponse($user, Response::HTTP_OK);
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
        $response = $user = $this->getUser($id);
        $user->delete();

        return $this->apiResponse($response, Response::HTTP_OK);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function favorites($id)
    {
        $user = $this->getUser($id);
        $favorites = $user->favorites()->get();

        $list = [];
        foreach ($favorites as $favorite) {
            $list[] = $favorite->song;
        }

        return $this->apiResponse($list, Response::HTTP_OK);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse|User
     */
    private function getUser($id)
    {
        return User::whereUuid($id)->firstOrFail();
    }

    /**
     * @param User $model
     * @param array $data
     */
    private function fillData(&$model, $data)
    {
        $model->name = $data['name'];
        $model->email = $data['email'];
        $model->password = bcrypt($data['password']);
    }
}
