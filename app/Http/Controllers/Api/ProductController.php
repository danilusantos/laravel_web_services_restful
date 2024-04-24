<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private $product;
    private $totalPage = 10;
    private $pathImage = "products";

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductRequest $request)
    {
        $products = $this->product->getResults($request->all(), $this->totalPage);

        return response()->json($products, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $this->saveImage($data, $request);
        }

        $product = $this->product->create($data);

        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$product = $this->product->with(['category'])->find($id)) {
            return response()->json(['error' => 'Not Found'], 404);
        }

        return response()->json($product, 200);
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
        if(! $product = $this->product->find($id)) {
            return response()->json(['error' => true], 404);
        }

        $data = $request->all();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $this->destroyImage($product->image);
            $data = $this->saveImage($data, $request);
        }

        $product->update($data);

        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$product = $this->product->find($id)) {
            return response()->json(['error' => 'Not Found'], 404);
        }

        $this->destroyImage($product->image);

        $product->delete();

        return response()->json(['success' => true], 204);
    }

    private function saveImage($data, $request): array
    {
        $name = Str::slug($request->name);
        $extension = $request->image->extension();

        $nameFile = "{$name}.{$extension}";
        $data['image'] = $nameFile;

        $upload = $request->image->storeAs($this->pathImage, $nameFile);

        if (! $upload) {
            return response()->json(['error' => 'Fail_Upload'], 500);
        }

        return $data;
    }

    private function destroyImage($image): void
    {
        if ($image && Storage::exists("{$this->pathImage}/{$image}")) {
            Storage::delete("{$this->pathImage}/{$image}");
        }
    }
}
