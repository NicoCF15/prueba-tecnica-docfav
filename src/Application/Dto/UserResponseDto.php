<?php

namespace App\Application\Dto;

/**
* Data transfer object to send a json response to client when a user is succesfully created
*
* The DTO recibe a bool param to indicate if the request is succesful, a data array and a error array.
* @package App\Application\Dto
*/
class UserResponseDto
{
    private bool $success;
    private string $message;
    private ?array $data;
    private ?array $errors; 
    private int $statusCode;

    public function __construct(bool $success, string $message, int $statusCode, ?array $data = null, ?array $errors = null)
    {
        $this->success = $success;
        $this->message = $message;
        $this->statusCode = $statusCode;
        $this->data = $data;
        $this->errors = $errors ?? [];
    }

    /**
    * Getter of success property of DTO
    *
    * @return bool
    */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
    * Getter of message property of DTO
    *
    * @return string
    */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
    * Getter of data property of DTO
    *
    * @return ?array
    */
    public function getData(): ?array
    {
        return $this->data;
    }

     /**
    * Getter of errors property of DTO
    *
    * @return ?array
    */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
    * Getter of status code property of DTO
    *
    * @return int
    */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
    * Getter of DTO data
    *
    * @return array
    */
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

