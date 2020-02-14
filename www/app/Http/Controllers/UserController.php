<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->save();
        return $this->apiResponse([], Response::HTTP_OK);
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
        $user = $this->getUser($id);
        $data = $request->validated();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
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
        $user = $this->getUser($id);
        $user->delete();

        return $this->apiResponse($user, Response::HTTP_OK);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse|User
     */
    private function getUser($id)
    {
        try {
            return User::whereUuid($id)->firstOrFail();
        } catch (NotFoundHttpException $e) {
            return $this->apiResponse(
                $this->errorResponse(1001, 'User not found'),
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
