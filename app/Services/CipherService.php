<?php

namespace App\Services;

class CipherService
{
    protected string $cipher = 'aes-128-ecb';
    protected string $key;

    private const BLOCK_SIZE = 16;

    public function __construct()
    {
        $this->key = config('verifikasi.aes_key');
    }

    public function encrypt(string $plain): string
    {
        $padLength = (int) (ceil(strlen($plain) / self::BLOCK_SIZE) * self::BLOCK_SIZE);
        $padded = str_pad($plain, $padLength, "\0");

        $ciphertext = openssl_encrypt(
            $padded,
            $this->cipher,
            $this->key,
            OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING
        );

        return bin2hex($ciphertext);
    }

    public function decrypt(string $encoded): ?string
    {
        if ($encoded === '' || !ctype_xdigit($encoded) || strlen($encoded) % 2 !== 0) {
            return null;
        }

        $raw = hex2bin($encoded);

        $plaintext = openssl_decrypt(
            $raw,
            $this->cipher,
            $this->key,
            OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING
        );

        if ($plaintext === false) {
            return null;
        }

        return rtrim($plaintext, "\0");
    }
}