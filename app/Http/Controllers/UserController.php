<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    protected $userRepository;
    public function __construct(User $model)
    {
        $this->userRepository = new UserRepository($model);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $user = $this->userRepository->showAllUsers();
            return response()->json(['status' => 1, 'code' => 200, 'data' => $user], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 2, 'code' => 400, 'message' => $th->getMessage(), 'data' => []]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            $data = $request->only(['name', 'email', 'password', 'image']);
            $user = $this->userRepository->createUser($data);
            return response()->json(['status' => 1, 'code' => 200, 'data' => $user], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 2, 'code' => 400, 'message' => $th->getMessage(), 'data' => []]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        try {
            $data = $request->only(['name', 'email', 'password', 'image']);
            $data = $this->userRepository->updateInfoUser($data, $id);
            return response()->json(['status' => 1, 'code' => 200, 'data' => $data]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 2, 'code' => 400, 'data' => $th->getMessage(), 'data' => []]);
        }
    }

    public function forgotPassword(Request $request)
    {
        try {
            $data = $request->only(['email']);
            $user = $this->userRepository->forgotPassword($data);
            return response()->json(['status' => 1, 'code' => 200, 'data' => $user]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 2, 'code' => 400, 'message' => $th->getMessage(), 'data' => []]);
        }
    }

    public function getAllProducts()
    {
        try {
            $user = $this->userRepository->getAllProducts();
            return response()->json(['status' => 1, 'code' => 200, 'data' => $user]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 2, 'code' => 400, 'message' => $th->getMessage(), 'data' => []]);
        }
    }
}
