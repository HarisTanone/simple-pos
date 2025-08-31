<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    protected $message;
    protected $statusCode;
    protected $errors;

    public function __construct($message = 'Error', $statusCode = 400, $errors = null)
    {
        $this->message = $message;
        $this->statusCode = $statusCode;
        $this->errors = $errors;
        parent::__construct(null);
    }

    public function toArray(Request $request): array
    {
        $response = [
            'success' => false,
            'message' => $this->message,
        ];

        if ($this->errors) {
            $response['errors'] = $this->errors;
        }

        return $response;
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->statusCode);
    }
}
