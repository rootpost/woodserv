<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
//use App\Requests\Product\StoreRequest;


class ProductController extends Controller
{
    public function index()
    {
        $postdata = Product::all();
        return view('admin.products.index', ["postdata" => $postdata]);
    }

    public function show(Product $id)
    {
        return view('admin.products.show', ["product" => $id]);
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        //$data = $request->validated();
        $data = $request->validate([
            'item_code' => 'required|string',
            'item_name' => 'required|string',
            'description' => 'string|max:2000',
            'price' => 'integer',
        ]);

        Product::create([
            'item_code' => $data['item_code'],
            'item_name' => $data['item_name'],
            'description' => $data['description'],
            'price' => $data['price']
        ]);

        $id = Product::orderBy('id', 'desc')->first();
        return redirect()->route('products.index');

        //return route('admin.products.show', ['product' => $product->id]);
    }

    // API methods
    public function products()
    {
        $products = Product::orderBy('id', 'DESC')->get();
        return response()->json([
            'products' => $products
        ], 200);
    }

    public function get_all_product()
    {
        $products = Product::all();
        return response()->json([
            'products' => $products
        ], 200);
    }

    public function search_product(Request $request)
    {
        $search = $request->get('s');
        if ($search != null){
            $products = Product::where('item_name', 'LIKE', "%$search%")->get();
            //$products = Product::whereRaw( 'LOWER("item_name") LIKE ?', "%$search%" )->get();
            return response()->json([
                'products' => $products
            ], 200);
        }else{
            return $this->get_all_product();
        }
    }

    public function create_product(Request $request)
    {
        $formData = [
            'item_code' => null,
            'item_name' => null,
            'description' => null,
            'price' => null
        ];
        return response()->json($formData);
    }

    public function add_product(Request $request)
    {
        $productdata['item_code'] = $request->input("item_code");
        $productdata['item_name'] = $request->input("item_name");
        $productdata['description'] = $request->input("description");
        $productdata['price'] = $request->input("price");
        
        $product = Product::create($productdata);

    }
    
    public function show_product($id) 
    {
        $product = Product::find($id);
        return response()->json([
            'product' => $product
        ], 200);
    }

    public function edit_product($id) 
    {
        $product = Product::find($id);
        return response()->json([
            'product' => $product
        ], 200);
    }

    public function update_product(Request $request, $id) 
    {
        $product = Product::where('id', $id)->first();

        $product->item_code = $request->item_code;
        $product->item_name = $request->item_name;
        $product->description = $request->description;
        $product->price = $request->price;

        $product->update($request->all());
    }

    public function delete_product($id) 
    {
        $product = Product::findOrFail($id);
        $product->delete();
    }
}
