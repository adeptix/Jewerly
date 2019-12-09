<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
        return UserResource::collection(User::all());
    }


    public function store(StoreRequest $request)
    {
        $user = User::create(
            $request->validated()
        );

        return response()->json([
            'message' => 'Пользователь создан успешно',
            'user' => new UserResource($user)
        ], 201);
    }


    public function show(User $user)
    {
        UserResource::withoutWrapping();
        return new UserResource($user);

    }


    public function update(UpdateRequest $request, User $user)
    {
        $user->update(
            $request->validated()
        );

        return response()->json([
            'message' => 'Информация о пользователе обновлена',
            'user' => new UserResource($user)
        ], 200);
    }


    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'message' => 'Пользователь удалён',
            'user' => new UserResource($user)
        ], 200);
    }
}
