<?php

// src/Service/EmailService.php
namespace App\Application\Service;

class EmailService
{
    public function sendWelcomeEmail(string $email, string $name): void
    {
        // Simulamos el envío de un correo electrónico.
        echo "Enviando correo de bienvenida a: $name <$email>\n";
    }
}
