<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function getAllProducts()
    {
        $products = Product::all();
        return response()->json([
            'products' => $products
        ], 200);
    }
    public function add_product(Request $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->quantity = $request->quantity;
        $product->price = $request->price;

        if ($request->photo != "") {
            $strpos = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time() . "." . $ex;
            $img = Image::make($request->photo)->resize(200, 200);
            $upload_path = public_path() . "/upload/";
            $img->save($upload_path . $name);
            $product->photo = $name;
        } else {
            $product->photo = "image.png";
        }
        $product->save();
    }

    public function editProduct($id)
    {
        $product = Product::find($id);

        return response()->json([
            'product' => $product
        ], 200);
    }

    public function updateProduct(Request $request, $id)
    {

        $product = Product::find($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->quantity = $request->quantity;
        $product->price = $request->price;

        if ($product->photo != $request->photo) {
            $strpos = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time() . "." . $ex;
            $img = Image::make($request->photo)->resize(200, 200);
            $upload_path = public_path() . "/upload/";
            $image = $upload_path . $product->photo;
            $img->save($upload_path . $name);

            if (file_exists($image)) {
                @unlink($image);
            }
        } else {
            $name = $product->photo;
        }

        $product->photo = $name;
        $product->save();
    }


    public function deleteProduct($id)
    {
        $product = Product::find($id);
        $image_path = public_path() . "/upload/";
        $image = $image_path . $product->photo;
        if (file_exists($image)) {
            @unlink($image);
        }
        $product->delete();
    }
}