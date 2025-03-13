<?php

namespace App\DTO;

class ApiResponse
{
    public $success;
    public $message;
    public $data;
    public $errors;
    public $statusCode;

    public function __construct($success, $message, $data = [], $errors = [], $statusCode = 200)
    {
        $this->success = $success;
        $this->message = $message;
        $this->data = $data;
        $this->errors = $errors;
        $this->statusCode = $statusCode;
    }

    public function toArray()
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => $this->data,
            'errors' => $this->errors
        ];
    }

    public function toJson()
    {
        return response()->json($this->toArray(), $this->statusCode);
    }

    public static function success($data = [], $message = 'Success', $statusCode = 200)
    {
        return new self(true, $message, $data, [], $statusCode);
    }

    public static function error($message = 'An error occurred', $statusCode = 400, $errors = [])
    {
        return new self(false, $message, [], $errors, $statusCode);
    }
}
