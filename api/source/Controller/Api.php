<?php

namespace source\Controller;


class Api
{
    protected ?array $response = null;
    protected ?object $auth = null;
    protected ?int $userAuthId = null;


    protected function authToken(int $typeId): bool
{
    $token = $this->getBearerToken();

    if (!$token) {
        return false;
    }

    $jwt = new \Source\Core\JWTToken();
    $decoded = $jwt->decode($token);

    if (!$decoded || !isset($decoded->data->id, $decoded->data->type_id)) {
        return false;
    }

    if ((int) $decoded->data->type_id !== $typeId) {
        return false;
    }

    $this->userAuthId = (int) $decoded->data->id;

    return true;
}

    

    public function hello()
    {
        echo "Olá, mundo! Estamos com a API funcionando, graças a Deus!";
    }

    protected function call (int $code, ?string $status = null, ?string $message = null, ?string $type = null): Api
    {
        http_response_code($code);
        if(!empty($status)){
            $this->response = [
                "code" => $code,
                "type" => $type,
                "status" => $status,
                "message" => (!empty($message) ? $message : null)
            ];
        }
        return $this;
    }

    protected function getAuthorizationHeader(): ?string
    {
        if (function_exists('getallheaders')) {
            $headers = getallheaders();
            if (isset($headers['Authorization'])) {
                return trim($headers['Authorization']);
            }
            if (isset($headers['authorization'])) {
                return trim($headers['authorization']);
            }
        }

        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            return trim($_SERVER['HTTP_AUTHORIZATION']);
        }

        if (isset($_SERVER['Authorization'])) {
            return trim($_SERVER['Authorization']);
        }

        return null;
    }

    protected function getBearerToken(): ?string
    {
        $header = $this->getAuthorizationHeader();
        if (empty($header)) {
            return null;
        }

        if (preg_match('/Bearer\s+(.*)$/i', $header, $matches)) {
            return trim($matches[1]);
        }

        return null;
    }

    protected function authorize(): bool
    {
        $token = $this->getBearerToken();
        if (!$token) {
            return false;
        }

        $decoded = JWT::decode($token);
        if (!$decoded) {
            return false;
        }

        $this->auth = $decoded;
        return true;
    }

    protected function requireAuth(): bool
    {
        if (!$this->authorize()) {
            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido)",
                "error"
            )->back(null);
            return false;
        }

        return true;
    }

    protected function back(array | object $data = null): Api
    {
        header('Content-Type: application/json');
        if ($data) {
            $this->response["data"] = $data;
        }
        echo json_encode($this->response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        return $this;
    }


}