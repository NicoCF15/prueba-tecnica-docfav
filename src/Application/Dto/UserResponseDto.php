<?php

namespace App\Application\Dto;

class UserResponseDto
{
    private bool $success;
    private string $message;
    private ?array $data; // Datos del usuario o nulo si falla
    private ?array $errors; // Lista de errores
    private int $statusCode;

    public function __construct(bool $success, string $message, int $statusCode, ?array $data = null, ?array $errors = null)
    {
        $this->success = $success;
        $this->message = $message;
        $this->statusCode = $statusCode;
        $this->data = $data;
        $this->errors = $errors ?? [];
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function getErrors(): ?array
    {
        return $this->errors;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getDtoData(){
        return [
            "success" => $this->success,
            "message" => $this->message,
            "statusCode" => $this->statusCode,
            "data" => $this->data,
            "errors" => $this->errors
        ];
    }
}

