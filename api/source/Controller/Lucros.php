<?php

namespace Source\Controller;

use Source\Controller\Api;
use Source\Models\Fazendinha\Lucro;

class Lucros extends Api
{
    public function listAll(array $data): void
    {
        $userId = null;
        if (isset($_GET['user_id']) && filter_var($_GET['user_id'], FILTER_VALIDATE_INT)) {
            $userId = (int)$_GET['user_id'];
        }
        $lucro = new Lucro();
        $response = $lucro->listAllByUser($userId);

        $this->call(200, "success", "Lista de lucros", "success")
            ->back($response);
    }

    public function listById(array $data): void
    {
        if (!isset($data["id"]) || !filter_var($data["id"], FILTER_VALIDATE_INT)) {
            $this->call(
                400,
                "bad_request",
                "ID do lucro é obrigatório e deve ser um número inteiro",
                "error"
            )->back(null);
            return;
        }

        $userId = null;
        if (isset($_GET['user_id']) && filter_var($_GET['user_id'], FILTER_VALIDATE_INT)) {
            $userId = (int)$_GET['user_id'];
        }
        $lucro = new Lucro();
        $lucroData = $lucro->listById((int)$data["id"], $userId);

        if (!$lucroData) {
            $this->call(
                404,
                "not_found",
                "Lucro não encontrado",
                "error"
            )->back(null);
            return;
        }

        $this->call(200, "success", "Lucro encontrado", "success")
            ->back($lucroData);
    }

    public function insert(array $data): void
    {
        //$body = json_decode(file_get_contents("php://input"), true);

        $hasAnimal = isset($data["animal_id"]) && filter_var($data["animal_id"], FILTER_VALIDATE_INT);
        $hasGrupo = isset($data["grupo_id"]) && filter_var($data["grupo_id"], FILTER_VALIDATE_INT);
        if (!isset($data["categoria_id"]) || !filter_var($data["categoria_id"], FILTER_VALIDATE_INT) || empty($data["descricao"]) || !isset($data["valor"]) || empty($data["data_lucro"])) {
            $this->call(400, "bad_request", "Os campos categoria_id, descricao, valor e data_lucro são obrigatórios", "error")->back(null);
            return;
        }

        $animalId = $hasAnimal ? (int)$data["animal_id"] : null;
        $grupoId = $hasGrupo ? (int)$data["grupo_id"] : null;
        $categoriaId = (int)$data["categoria_id"];
        $descricao = trim($data["descricao"]);
        $valor = (float)$data["valor"];
        $dataLucro = trim($data["data_lucro"]);

        if ($descricao === "" || !is_numeric($valor) || $dataLucro === "") {
            $this->call(
                400,
                "bad_request",
                "Todos os campos devem ser válidos",
                "error"
            )->back(null);
            return;
        }

        if (!isset($data['user_id']) || !filter_var($data['user_id'], FILTER_VALIDATE_INT)) {
            $this->call(400, "bad_request", "user_id é obrigatório", "error")->back(null);
            return;
        }
        $userId = (int)$data['user_id'];

        $lucro = new Lucro();
        $response = $lucro->create($animalId, $grupoId ?? null, $categoriaId, $descricao, $valor, $dataLucro, $userId);

        if (!$response) {
            $this->call(
                500,
                "internal_server_error",
                "Não foi possível criar o lucro",
                "error"
            )->back(null);
            return;
        }

        $this->call(201, "created", "Lucro criado com sucesso", "success")
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
        if (!isset($data["categoria_id"]) || !filter_var($data["categoria_id"], FILTER_VALIDATE_INT) || empty($data["descricao"]) || !isset($data["valor"]) || empty($data["data_lucro"])) {
            $this->call(400, "bad_request", "Os campos categoria_id, descricao, valor e data_lucro são obrigatórios", "error")->back(null);
            return;
        }

        $id = (int)$data["id"];
        $animalId = $hasAnimal ? (int)$data["animal_id"] : null;
        $grupoId = $hasGrupo ? (int)$data["grupo_id"] : null;
        $categoriaId = (int)$data["categoria_id"];
        $descricao = trim($data["descricao"]);
        $valor = (float)$data["valor"];
        $dataLucro = trim($data["data_lucro"]);

        if ($descricao === "" || !is_numeric($valor) || $dataLucro === "") {
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

        $lucro = new Lucro();
        $existing = $lucro->listById($id, $userId);

        if (!$existing) {
            $this->call(
                404,
                "not_found",
                "Lucro não encontrado",
                "error"
            )->back(null);
            return;
        }

        $updated = $lucro->update($id, $animalId, $grupoId ?? null, $categoriaId, $descricao, $valor, $dataLucro);

        if (!$updated) {
            $this->call(
                500,
                "internal_server_error",
                "Não foi possível atualizar o lucro",
                "error"
            )->back(null);
            return;
        }

        $this->call(200, "success", "Lucro atualizado com sucesso", "success")
            ->back($lucro->listById($id, $userId));
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

        $lucro = new Lucro();
        $existing = $lucro->listById($id, $userId);

        if (!$existing) {
            $this->call(
                404,
                "not_found",
                "Lucro não encontrado",
                "error"
            )->back(null);
            return;
        }

        $deleted = $lucro->delete($id);

        if (!$deleted) {
            $this->call(
                500,
                "internal_server_error",
                "Não foi possível excluir o lucro",
                "error"
            )->back(null);
            return;
        }

        $this->call(200, "success", "Lucro excluído com sucesso", "success")
            ->back(null);
    }
}
