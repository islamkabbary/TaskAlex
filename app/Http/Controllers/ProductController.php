<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Repository\ProductRepository;
use App\Http\Traits\ImageTrait;
use App\Models\Image;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    use ImageTrait;
    protected $productRepository;
    protected $model;
    public function __construct(Product $model)
    {
        $this->model = $model;
        $this->productRepository = new ProductRepository($model);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $user = $this->productRepository->showAllproduct();
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
    public function store(ProductRequest $request)
    {
        try {
            $data = $request->only(['name', 'description']);
            $product = $this->productRepository->createproduct($data);
            if ($request->hasFile('image')) {
                $images = $request->file('image');
                foreach ($images as $image) {
                    $image_name = $this->save_file($image, 'images');
                    $product->images()->create(['image' => $image_name]);
                }
            }
            return response()->json(['status' => 1, 'code' => 200, 'data' => $product], Response::HTTP_OK);
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
    public function update(ProductRequest $request, $id)
    {
        try {
            $data = $request->only(['name', 'description']);
            $data = $this->productRepository->updateProduct($data, $id);
            if ($request->hasFile('image')) {
                $images = $request->file('image');
                foreach ($images as $image) {
                    $image_name = $this->update_file($this->model,$image,$id);
                }
            }
            return response()->json(['status' => 1, 'code' => 200, 'data' => $data], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 2, 'code' => 400, 'data' => $th->getMessage(), 'data' => []]);
        }
    }

    public function destroy($id)
    {
        try {
            $data = $this->productRepository->deleteProduct($id);
            $this->model->find($id)->images()->delete();
            return response()->json(['status' => 1, 'code' => 200, 'message' => trans('message.delete-message')], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 1, 'code' => 200, 'message' => trans(''), 'data' => $th->getMessage()], Response::HTTP_OK);
        }
    }
}
