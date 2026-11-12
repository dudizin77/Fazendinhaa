<?php

namespace Source\Core;

class JWT
{
    private const HEADER = [
        "alg" => "HS256",
        "typ" => "JWT"
    ];

    public static function encode(array $payload, int $expiration = 3600): string
    {
        $payload["iat"] = time();
        $payload["exp"] = time() + $expiration;

        $header = json_encode(self::HEADER);
        $payload = json_encode($payload);

        $base64UrlHeader = self::base64UrlEncode($header);
        $base64UrlPayload = self::base64UrlEncode($payload);

        $signature = hash_hmac("sha256", sprintf("%s.%s", $base64UrlHeader, $base64UrlPayload), CONF_JWT_SECRET, true);
        $base64UrlSignature = self::base64UrlEncode($signature);

        return sprintf("%s.%s.%s", $base64UrlHeader, $base64UrlPayload, $base64UrlSignature);
    }

    public static function decode(string $token): object|false
    {
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return false;
        }

        [$header, $payload, $signature] = $parts;
        $data = sprintf("%s.%s", $header, $payload);
        $rawSignature = self::base64UrlDecode($signature);
        $expected = hash_hmac("sha256", $data, CONF_JWT_SECRET, true);

        if (!hash_equals($expected, $rawSignature)) {
            return false;
        }

        $decodedPayload = json_decode(self::base64UrlDecode($payload));
        if (!$decodedPayload || !isset($decodedPayload->exp)) {
            return false;
        }

        if (time() > $decodedPayload->exp) {
            return false;
        }

        return $decodedPayload;
    }

    private static function base64UrlEncode(string $input): string
    {
        return rtrim(strtr(base64_encode($input), '+/', '-_'), '=');
    }

    private static function base64UrlDecode(string $input): string
    {
        $remainder = strlen($input) % 4;
        if ($remainder) {
            $input .= str_repeat('=', 4 - $remainder);
        }
        return base64_decode(strtr($input, '-_', '+/'));
    }
}
