<?php

namespace App\Libraries;

class Token
{
    private $token;

    public function __construct(string $token = null)
    {
        if ($token === null) {
            $this->token = bin2hex(random_bytes(16));
        } else {
            $this->token = $token;
        }
    }

    /**
     * Método que retorna o valor do token
     */
    public function getValue(): string
    {
        return $this->token;
    }

    /**
     * Método que retorna o hash do token
     */
    public function getHash(): string
    {
        return hash_hmac("sha256", $this->token, "PASSWORD_RECUPERATION_KEY");
    }
}
