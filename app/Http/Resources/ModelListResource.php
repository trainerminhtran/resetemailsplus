<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ModelListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'sku' => $this->sku,
            'stock_locked' => $this->stock_locked,
            'name' => $this->name,
            'price' => $this->price,
            'normal_stock' => $this->normal_stock,
            'promotion_stock' => $this->promotion_stock,
            'sold' => $this->sold,
            'price_before_discount' => $this->price_before_discount,
            'stock' => $this->stock,
            'reserved_stock' => $this->reserved_stock,
            'in_promotion' => $this->in_promotion,
            'shop_type' => $this->shop_type,
        ];
    }
}
