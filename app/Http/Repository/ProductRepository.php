<?php

namespace App\Http\Repository;

use App\Http\Traits\CrudTrait;
use App\Http\Traits\ImageTrait;
use Illuminate\Support\Facades\Hash;

class ProductRepository
{
    public function __construct($model)
    {
        $this->model = $model;
    }

    use ImageTrait, CrudTrait;

    public function showAllProduct()
    {
        return $this->indexTrait($this->model);
    }

    public function createProduct($data)
    {
        // dd($data);
        return $this->storeTrait($this->model, $data);
    }

    public function updateProduct($data, $id)
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
        return $this->updateTrait($this->model, $data, $id);
    }

    public function deleteProduct($id)
    {
        return $this->destroyTrait($this->model, $id);
    }
}
