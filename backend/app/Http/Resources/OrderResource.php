<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'table' => new TableResource($this->whenLoaded('table')),
            'waiter' => new UserResource($this->whenLoaded('waiter')),
            'cashier' => $this->when($this->cashier, new UserResource($this->whenLoaded('cashier'))),
            'status' => $this->status->description,
            'total_amount' => $this->total_amount,
            'opened_at' => $this->opened_at,
            'closed_at' => $this->closed_at,
            'order_items' => OrderItemResource::collection($this->whenLoaded('orderItems')),
            'created_at' => $this->created_at,
        ];
    }
}
