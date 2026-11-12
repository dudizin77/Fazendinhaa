<?php

namespace Source\Controller;

use Source\Controller\Api;
use Source\Models\Fazendinha\Despesa;

class Despesas extends Api
{
    public function listAll(array $data): void
    {
        $userId = null;
        if (isset($_GET['user_id']) && filter_var($_GET['user_id'], FILTER_VALIDATE_INT)) {
            $userId = (int)$_GET['user_id'];
        }
        $despesa = new Despesa();
        $response = $despesa->listAllByUser($userId);

        $this->call(200, "success", "Lista de despesas", "success")
            ->back($response);
    }

    public function listById(array $data): void
    {
        if (!isset($data["id"]) || !filter_var($data["id"], FILTER_VALIDATE_INT)) {
            $this->call(
                400,
                "bad_request",
                "ID da despesa é obrigatório e deve ser um número inteiro",
                "error"
            )->back(null);
            return;
        }

        $userId = null;
        if (isset($_GET['user_id']) && filter_var($_GET['user_id'], FILTER_VALIDATE_INT)) {
            $userId = (int)$_GET['user_id'];
        }
        $despesa = new Despesa();
        $despesaData = $despesa->listById((int)$data["id"], $userId);

        if (!$despesaData) {
            $this->call(
                404,
                "not_found",
                "Despesa não encontrada",
                "error"
            )->back(null);
            return;
        }

        $this->call(200, "success", "Despesa encontrada", "success")
            ->back($despesaData);
    }

    public function insert(array $data): void
    {
        $body = json_decode(file_get_contents("php://input"), true);

        // animal_id e grupo_id são opcionais; validar apenas categorias, descricao, valor e data
        $hasAnimal = isset($body["animal_id"]) && filter_var($body["animal_id"], FILTER_VALIDATE_INT);
        $hasGrupo = isset($body["grupo_id"]) && filter_var($body["grupo_id"], FILTER_VALIDATE_INT);
        if (!isset($body["categoria_id"]) || !filter_var($body["categoria_id"], FILTER_VALIDATE_INT) ||
            empty($body["descricao"]) || !isset($body["valor"]) || empty($body["data_despesa"])) {
            $this->call(400, "bad_request", "Os campos categoria_id, descricao, valor e data_despesa são obrigatórios", "error")->back(null);
            return;
        }

        $animalId = $hasAnimal ? (int)$body["animal_id"] : null;
        $grupoId = $hasGrupo ? (int)$body["grupo_id"] : null;
        $categoriaId = (int)$body["categoria_id"];
        $descricao = trim($body["descricao"]);
        $valor = (float)$body["valor"];
        $dataDespesa = trim($body["data_despesa"]);

        if ($descricao === "" || !is_numeric($valor) || $dataDespesa === "") {
            $this->call(
                400,
                "bad_request",
                "Todos os campos devem ser válidos",
                "error"
            )->back(null);
            return;
        }

        if (!isset($body['user_id']) || !filter_var($body['user_id'], FILTER_VALIDATE_INT)) {
            $this->call(400, "bad_request", "user_id é obrigatório", "error")->back(null);
            return;
        }
        $userId = (int)$body['user_id'];

        $despesa = new Despesa();
        $response = $despesa->create($animalId, $grupoId ?? null, $categoriaId, $descricao, $valor, $dataDespesa, $userId);

        if (!$response) {
            $this->call(
                500,
                "internal_server_error",
                "Não foi possível criar a despesa",
                "error"
            )->back(null);
            return;
        }

        $this->call(201, "created", "Despesa criada com sucesso", "success")
            ->back($response);
    }

    public function update(array $data): void
    {
        if (!isset($data["id"]) || !filter_var($data["id"], FILTER_VALIDATE_INT)) {
            $this->call(
                400,
                "bad_request",
                "ID inválido",
                "error"
            )->back(null);
            return;
        }

        //$body = json_decode(file_get_contents("php://input"), true);

        $hasAnimal = isset($data["animal_id"]) && filter_var($data["animal_id"], FILTER_VALIDATE_INT);
        $hasGrupo = isset($data["grupo_id"]) && filter_var($data["grupo_id"], FILTER_VALIDATE_INT);
        if (!isset($data["categoria_id"]) || !filter_var($data["categoria_id"], FILTER_VALIDATE_INT) || empty($data["descricao"]) || !isset($data["valor"]) || empty($data["data_despesa"])) {
            $this->call(400, "bad_request", "Os campos categoria_id, descricao, valor e data_despesa são obrigatórios", "error")->back(null);
            return;
        }

        $id = (int)$data["id"];
        $animalId = $hasAnimal ? (int)$data["animal_id"] : null;
        $grupoId = $hasGrupo ? (int)$data["grupo_id"] : null;
        $categoriaId = (int)$data["categoria_id"];
        $descricao = trim($data["descricao"]);
        $valor = (float)$data["valor"];
        $dataDespesa = trim($data["data_despesa"]);

        if ($descricao === "" || !is_numeric($valor) || $dataDespesa === "") {
            $this->call(
                400,
                "bad_request",
                "Todos os campos devem ser válidos",
                "error"
            )->back(null);
            return;
        }

        $userId = null;
        if (isset($data['user_id']) && filter_var($data['user_id'], FILTER_VALIDATE_INT)) {
            $userId = (int)$data['user_id'];
        } elseif (isset($_GET['user_id']) && filter_var($_GET['user_id'], FILTER_VALIDATE_INT)) {
            $userId = (int)$_GET['user_id'];
        } else {
            $this->call(400, "bad_request", "user_id é obrigatório", "error")->back(null);
            return;
        }

        $despesa = new Despesa();
        $existing = $despesa->listById($id, $userId);

        if (!$existing) {
            $this->call(
                404,
                "not_found",
                "Despesa não encontrada",
                "error"
            )->back(null);
            return;
        }

        $updated = $despesa->update($id, $animalId, $grupoId ?? null, $categoriaId, $descricao, $valor, $dataDespesa);

        if (!$updated) {
            $this->call(
                500,
                "internal_server_error",
                "Não foi possível atualizar a despesa",
                "error"
            )->back(null);
            return;
        }

        $this->call(200, "success", "Despesa atualizada com sucesso", "success")
            ->back($despesa->listById($id, $userId));
    }

    public function delete(array $data): void
    {
        if (!isset($data["id"]) || !filter_var($data["id"], FILTER_VALIDATE_INT)) {
            $this->call(
                400,
                "bad_request",
                "ID inválido",
                "error"
            )->back(null);
            return;
        }

        $id = (int)$data["id"];
        $userId = null;
        if (isset($data['user_id']) && filter_var($data['user_id'], FILTER_VALIDATE_INT)) {
            $userId = (int)$data['user_id'];
        } elseif (isset($_GET['user_id']) && filter_var($_GET['user_id'], FILTER_VALIDATE_INT)) {
            $userId = (int)$_GET['user_id'];
        } else {
            $this->call(400, "bad_request", "user_id é obrigatório", "error")->back(null);
            return;
        }

        $despesa = new Despesa();
        $existing = $despesa->listById($id, $userId);

        if (!$existing) {
            $this->call(
                404,
                "not_found",
                "Despesa não encontrada",
                "error"
            )->back(null);
            return;
        }

        $deleted = $despesa->delete($id);

        if (!$deleted) {
            $this->call(
                500,
                "internal_server_error",
                "Não foi possível excluir a despesa",
                "error"
            )->back(null);
            return;
        }

        $this->call(200, "success", "Despesa excluída com sucesso", "success")
            ->back(null);
    }
}
