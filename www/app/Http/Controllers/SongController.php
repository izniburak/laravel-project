<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Http\Requests\SongRequest;
use App\Song;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = Song::all();
        return $this->apiResponse($users, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SongRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SongRequest $request)
    {
        $data = $request->validated();

        $song = new Song();
        $song->uuid = Str::uuid();
        $this->fillData($song, $data, 'store');
        $song->save();

        return $this->apiResponse($song, Response::HTTP_CREATED);
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
        $category = $this->getSong($id);

        return $this->apiResponse($category, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SongRequest $request
     * @param int         $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SongRequest $request, $id)
    {
        $song = $this->getSong($id);
        $data = $request->validated();

        $this->fillData($song, $data, 'update');
        $song->save();

        return $this->apiResponse($song, Response::HTTP_OK);
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
        $response = $song = $this->getSong($id);
        $song->delete();

        return $this->apiResponse($response, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeFavorites(Request $request, $id)
    {
        $data = $request->validate([
            'user_id' => 'required|string|max:36|min:36'
        ]);

        $song = $this->getSong($id);
        $user = User::whereUuid($data['user_id'])->firstOrFail();
        if (Favorite::where('song_id', $song->id)->where('user_id', $user->id)->doesntExist()) {
            $favorite = new Favorite;
            $favorite->song_id = $song->id;
            $favorite->user_id = $user->id;
            $favorite->save();
        }

        return $this->apiResponse([], Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function deleteFavorites(Request $request, $id)
    {
        $data = $request->validate([
            'user_id' => 'required|string|max:36|min:36'
        ]);

        $song = $this->getSong($id);
        $user = User::whereUuid($data['user_id'])->firstOrFail();
        $favorite = $song->favorites()->where('user_id', $user->id)->firstOrFail();
        $favorite->delete();

        return $this->apiResponse([], Response::HTTP_OK);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse|Song
     */
    private function getSong($id)
    {
        return Song::whereUuid($id)->firstOrFail();
    }

    /**
     * @param Song $model
     * @param array $data
     * @param string $action
     *
     * @return void
     */
    private function fillData(&$model, $data, $action)
    {
        $model->category_id = $data['category_id'];
        $model->name = $data['name'];
        $model->album = $data['album'];
        $model->artist = $data['artist'];
        $model->source = $data['source'];
        $model->image = isset($data['image']) && !empty($data['image'])
            ? $data['image']
            : ($action === 'store' ? null : $model->image);
        $model->status = isset($data['status']) && !empty($data['status'])
            ? $data['status']
            : ($action === 'store' ? '1' : $model->status);
    }
}
