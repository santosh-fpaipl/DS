<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\OptionSkuResource;
use App\Http\Resources\RangeSkuResource;

class ProductSkuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);

        $product_arr = explode("-", $request->sku);

        return [
            'name' => $this->name,
            'sid' => $this->sid,
            'start_price' => $this->start_price,
            'end_price' => $this->end_price,
            'price' => $this->start_price,
            'moq' => $this->moq,
            'hsncode' => $this->hsncode,
            'gstrate' => $this->gstrate,
            'options'=> new OptionSkuResource($this->options->find($product_arr[1])),
            "ranges" => new RangeSkuResource($this->ranges->find($product_arr[2])),
        ];
    }
}
