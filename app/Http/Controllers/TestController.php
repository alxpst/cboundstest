<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class TestController extends Controller
{    
    /**
     * Возвращает 25 записей
     *
     * @return void
     */
    public function index(Request $request)
    {
        $filter = (
            isset($request['filter'])
            && !empty($request['filter'])
            && strlen($request['filter']) > 1
        )
            ? $request['filter'] : false;
        $query = Product::query();
        if ($filter) {
            $query->where('name', 'like', "%{$filter}%");
        }
        return $query->paginate(25);
    }
    
    /**
     * Возвращает одну запись
     *
     * @param  mixed $id
     * @return void
     */
    public function show($id)
    {
        return Product::findOrFail($id);
    }
    
    /**
     * Создает запись
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        try {
            $product = new Product;
            $product->name = $request['name'];
            $product->price = $request['price'];
            $product->save();
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        };

        return response()->json($product);
    }
    
    /**
     * Обновляет запись
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        try {
            $product->name = $request['name'];
            $product->price = $request['price'];
            $product->update();
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }

        return response()->json($product);
    }
    
    /**
     * Удаляет запись
     *
     * @param  mixed $id
     * @return void
     */
    public function remove($id)
    {
        Product::destroy($id);
    }
}
