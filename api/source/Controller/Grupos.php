<?php

namespace Source\Controller;

use Source\Controller\Api;
use Source\Models\Fazendinha\Grupo;

class Grupos extends Api
{
    public function listAll(array $data): void
    {
        $userId = null;
        if (isset($_GET['user_id']) && filter_var($_GET['user_id'], FILTER_VALIDATE_INT)) {
            $userId = (int)$_GET['user_id'];
        }
        $g = new Grupo();
        $response = $g->listAllByUser($userId);

        $this->call(200, "success", "Lista de grupos", "success")->back($response);
    }

    public function listById(array $data): void
    {
        if (!isset($data["id"]) || !filter_var($data["id"], FILTER_VALIDATE_INT)) {
            $this->call(400, "bad_request", "ID do grupo é obrigatório e deve ser um número inteiro", "error")->back(null);
            return;
        }

        $userId = null;
        if (isset($_GET['user_id']) && filter_var($_GET['user_id'], FILTER_VALIDATE_INT)) {
            $userId = (int)$_GET['user_id'];
        }
        $g = new Grupo();
        $res = $g->listById((int)$data["id"], $userId);
        if (!$res) {
            $this->call(404, "not_found", "Grupo não encontrado", "error")->back(null);
            return;
        }

        $this->call(200, "success", "Grupo encontrado", "success")->back($res);
    }

    public function insert(array $data): void
    {
        //$body = json_decode(file_get_contents("php://input"), true);
        if (empty($data["nome"]) || !isset($data["quantidade"])) {
            $this->call(400, "bad_request", "Campos nome e quantidade são obrigatórios", "error")->back(null);
            return;
        }

        if (!isset($data['user_id']) || !filter_var($data['user_id'], FILTER_VALIDATE_INT)) {
            $this->call(400, "bad_request", "user_id é obrigatório", "error")->back(null);
            return;
        }
        $userId = (int)$data['user_id'];

        $nome = trim($data["nome"]);
        $qtd = (int)$data["quantidade"];

        if ($nome === "" || $qtd < 0) {
            $this->call(400, "bad_request", "Dados inválidos", "error")->back(null);
            return;
        }

        $g = new Grupo();
        $res = $g->create($nome, $qtd, $userId);
        if (!$res) {
            $this->call(500, "internal_server_error", "Não foi possível criar o grupo", "error")->back(null);
            return;
        }

        $this->call(201, "created", "Grupo criado com sucesso", "success")->back($res);
    }

    public function update(array $data): void
    {
        if (!isset($data["id"]) || !filter_var($data["id"], FILTER_VALIDATE_INT)) {
            $this->call(400, "bad_request", "ID inválido", "error")->back(null);
            return;
        }

        //$body = json_decode(file_get_contents("php://input"), true);
        if (empty($data["nome"]) || !isset($data["quantidade"])) {
            $this->call(400, "bad_request", "Campos nome e quantidade são obrigatórios", "error")->back(null);
            return;
        }

        $id = (int)$data["id"];
        $nome = trim($data["nome"]);
        $qtd = (int)$data["quantidade"];

        $userId = null;
        if (isset($_GET['user_id']) && filter_var($_GET['user_id'], FILTER_VALIDATE_INT)) {
            $userId = (int)$_GET['user_id'];
        } elseif (isset($data['user_id']) && filter_var($data['user_id'], FILTER_VALIDATE_INT)) {
            $userId = (int)$data['user_id'];
        } else {
            $this->call(400, "bad_request", "user_id é obrigatório", "error")->back(null);
            return;
        }

        $g = new Grupo();
        $existing = $g->listById($id, $userId);
        if (!$existing) {
            $this->call(404, "not_found", "Grupo não encontrado", "error")->back(null);
            return;
        }

        $updated = $g->update($id, $nome, $qtd);
        if (!$updated) {
            $this->call(500, "internal_server_error", "Não foi possível atualizar o grupo", "error")->back(null);
            return;
        }

        $this->call(200, "success", "Grupo atualizado", "success")->back($g->listById($id, $userId));
    }

    public function delete(array $data): void
    {
        if (!isset($data["id"]) || !filter_var($data["id"], FILTER_VALIDATE_INT)) {
            $this->call(400, "bad_request", "ID inválido", "error")->back(null);
            return;
        }

        $id = (int)$data["id"];
        $userId = null;
        if (isset($_GET['user_id']) && filter_var($_GET['user_id'], FILTER_VALIDATE_INT)) {
            $userId = (int)$_GET['user_id'];
        } else {
            $this->call(400, "bad_request", "user_id é obrigatório", "error")->back(null);
            return;
        }

        $g = new Grupo();
        $existing = $g->listById($id, $userId);
        if (!$existing) {
            $this->call(404, "not_found", "Grupo não encontrado", "error")->back(null);
            return;
        }

        $deleted = $g->delete($id);
        if (!$deleted) {
            $this->call(500, "internal_server_error", "Não foi possível excluir o grupo", "error")->back(null);
            return;
        }

        $this->call(200, "success", "Grupo excluído com sucesso", "success")->back(null);
    }
}
