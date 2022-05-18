<?php

namespace App\Http\Repository;

use App\Models\Product;
use App\Http\Traits\CrudTrait;
use App\Http\Traits\ImageTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepository
{    
    public function __construct($model)
    {
        $this->model = $model;
    }
    
    use ImageTrait , CrudTrait;

    public function showAllUsers()
    {
        return $this->indexTrait($this->model);
    }

    public function createUser($data)
    {
        $data['password'] = Hash::make($data['password']);
        $data['image'] = $this->save_file($data['image'], 'images');
        return $this->storeTrait($this->model,$data);
    }

    public function updateInfoUser($data,$id)
    {
        $old_image_path = $this->getFilePath($this->model, $id, 'images')['image'];
        if ($data->hasFile('image')) {
            $new_image_path = $this->update_file('public/images', $data->photograph, $old_image_path);
            $data = $data->validated();
            $data['image'] = $new_image_path;
        } else {
            $data = $data->validated();
            $data['image'] = $old_image_path;
        }
        if ($data->hasFile('password')) {
            $data['password'] = Hash::make($data['password']);
        }
        return $this->updateTrait($this->model,$data,$id);
    }

    public function forgotPassword($data)
    {
        $data = $data->validated();
        $user = $this->model->where('email', $data['email'])->first();
        if ($user) {
            $user->password = Hash::make($data['password']);
            $user->save();
            return response()->json(['status' => 1, 'code' => 200, 'data' => $user]);
        } else {
            return response()->json(['status' => 2, 'code' => 400, 'message' => 'User not found', 'data' => []]);
        }
    }

    public function getAllProducts()
    {
        return Product::where('user_id', Auth::id())->get();
    }
}