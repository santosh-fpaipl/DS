<?php

namespace App\Http\Providers;
use App\Http\Providers\Provider;
use App\Models\Product;
use App\Models\Option;
use App\Models\Range;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProductAvailableRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SkuResource;
use App\Http\Resources\ProductSkuResource;
use App\Http\Responses\ApiResponse;
use Illuminate\Support\Facades\Log;

class ProductProvider extends provider
{
    /**
    * Get All Products
    */
    public function index(Request $request)
    {
        try{
            $products = Product::with('options')->with('ranges')->get();
        } catch(\Exception $e){
            return ApiResponse::error($e->getMessage(),404);  
        }

        // viar = validInternalApiRequest
        $viar = $this->reqHasApiSecret($request);
        foreach ($products as $product) {
            if($viar){
                $product->viar = true;
            }
        }
        
        return ApiResponse::success(ProductResource::collection($products));
    }

    public function show(ProductAvailableRequest $request, Product $product)
    {
        if($request->has('check') && $request->check == 'available'){
            return ApiResponse::success(['available' => true]);
        }
        // if(!$product->active){
        //     return ApiResponse::error('Product is inactive.',404);
        // }
        // viar = validInternalApiRequest
        $viar = $this->reqHasApiSecret($request);
        if($viar){
            $product->viar = true;
        }
        return ApiResponse::success(new ProductResource($product));
    }
   
    public function allProductSkus(Request $request){

        $sku_datas = [];
        $products = Product::with('options')->with('ranges')->get();
        foreach($products as $product){
            foreach($product['options'] as $option){
                foreach($product['ranges'] as $range){
                    $temp_data =[];
                    $temp_data['sku'] = $product->id."-".$option->id."-".$range->id;
                    $temp_data['name'] = $product->name;
                    $temp_data['image'] = $option->getImage('s100');
                    array_push($sku_datas , $temp_data);
                }
            }
            //$this->command->info($product['name']);
        }

        $sku_new_datas = [];

        foreach($sku_datas as $data){
            $temp_rest_datas = [];
            $sku_arr = explode("-", $data['sku']);
            foreach($sku_datas as $new_data){
                $sku_new_arr = explode("-", $new_data['sku']);
                if($sku_arr[0] == $sku_new_arr[0] 
                    && ($sku_arr[1] != $sku_new_arr[1] 
                    || $sku_arr[2] != $sku_new_arr[2])
                ){
                    $temp_data = [];
                    $temp_data['sku'] = $new_data['sku'];
                    $temp_data['name'] = $new_data['name'];
                    $temp_data['image'] = $new_data['image'];
                    $temp_data['link'] = env('DS_APP').'/api/internal/product/'.$new_data['sku'];

                    array_push($temp_rest_datas, $temp_data);
                }

            }
            $data['related_skus'] = $temp_rest_datas;
            array_push($sku_new_datas, $data);
        }

        $sku_collections = collect($sku_new_datas);

        // viar = validInternalApiRequest
        $viar = $this->reqHasApiSecret($request);
        foreach ($sku_collections as $sku_collection) {
            if($viar){
                $sku_collection['viar'] = true;
            }
        }

        return ApiResponse::success(SkuResource::collection($sku_collections));
    }

    public function showProductSku(Request $request){
        $product_arr = explode("-", $request->sku);
        if(!Product::where('id', $product_arr[0])->exists() || 
            !Option::where('product_id', $product_arr[0])->where('id', $product_arr[1])->exists() || 
            !Range::where('product_id', $product_arr[0])->where('id', $product_arr[2])->exists()
        )
        {
            return ApiResponse::error('SKU does not exist.', 404);
        }
        $product = Product::find($product_arr[0]);

        // viar = validInternalApiRequest
        $viar = $this->reqHasApiSecret($request);
        if($viar){
            $product->viar = true;
        }
        return ApiResponse::success(new ProductSkuResource($product));
    }
}