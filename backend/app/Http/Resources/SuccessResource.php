<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    protected $message;
    protected $statusCode;

    public function __construct($resource, $message = 'Success', $statusCode = 200)
    {
        parent::__construct($resource);
        $this->message = $message;
        $this->statusCode = $statusCode;
    }

    public function toArray(Request $request): array
    {
        return [
            'success' => true,
            'message' => $this->message,
            'data' => $this->resource,
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->statusCode);
    }
}
