<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Favorite;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Specification;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $products = Product::all();
        $orders = Order::all();

        return response()->json([
            "users"    => $users,
            "products" => $products,
            "orders"   => $orders
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function addProduct(Request $request)
    {
        try {
            $specification = Specification::create([
                "content" => $request->specification
            ]);
            $specificationId = $specification->id;
            $data = $request->all([
                "name", "price", "image", "percent", "typeProductId", "categoryId"
            ]);
            $product = Product::create([
                "name" => $data['name'],
                "price" => $data["price"],
                "image" => $data["image"],
                "percent" => $data["percent"],
                "specificationId" => $specificationId
            ]);
            $createProductCategories = ProductCategory::create([
                "productId" => $product->id,
                "typeProductId" => $data['typeProductId'],
                "categoryId" => $data['categoryId']
            ]);
            return response()->json([
                "message" => "Товар создан"
            ], 201);
        } catch (\ErrorException $error) {
            return response()->json([
                "message" => "$error"
            ], 500);
        }

    }
    public function addCategory(Request $request)
    {
        //
    }
    public function addTypeProduct(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProduct(Request $request, string $id)
    {
        //
    }
    public function updateCategory(Request $request, string $id)
    {
        //
    }
    public function updateTypeProduct(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteProduct(string $id)
    {
        try {
            if (Favorite::where("productId", $id)) {
                Favorite::where("productId", $id)->delete();
            }
            if (ProductCategory::where("productId", $id)) {
                ProductCategory::where("productId", $id)->delete();
            }
            if (Cart::where("productId", $id)) {
                Cart::where("productId", $id)->delete();
            }
            $product = Product::findOrFail($id)->delete();
            return response()->json([
                "message" => "Товар удален"
            ]);

        } catch (\ErrorException $error) {
            return response()->json([
                "message" => "$error"
            ], 500);
        }
    }
    public function deleteCategory(string $id)
    {
        //
    }
    public function deleteTypeProduct(string $id)
    {
        //
    }
}
