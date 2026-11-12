<?php

namespace Source\Controller;

use Source\Controller\Api;
use Source\Models\Fazendinha\Animal;

class Animais extends Api
{
    public function listAll(array $data): void
    {
        $userId = null;
        if (isset($_GET['user_id']) && filter_var($_GET['user_id'], FILTER_VALIDATE_INT)) {
            $userId = (int)$_GET['user_id'];
        }
        $animal = new Animal();
        $response = $animal->listAll($userId);

        $this->call(200, "success", "Lista de animais", "success")
            ->back($response);
    }

    public function listById(array $data): void
    {
        if (!isset($data["id"]) || !filter_var($data["id"], FILTER_VALIDATE_INT)) {
            $this->call(
                400,
                "bad_request",
                "ID do animal é obrigatório e deve ser um número inteiro",
                "error"
            )->back(null);
            return;
        }

        $animal = new Animal();
        $animalData = $animal->listById((int)$data["id"]);

        if (!$animalData) {
            $this->call(
                404,
                "not_found",
                "Animal não encontrado",
                "error"
            )->back(null);
            return;
        }

        $this->call(200, "success", "Animal encontrado", "success")
            ->back($animalData);
    }

    public function insert(array $data): void
    {
        //$body = json_decode(file_get_contents("php://input"), true);
        //$data["user_id"] = 1;

        if (empty($data["nome"]) || !isset($data["raca_id"]) || !filter_var($data["raca_id"], FILTER_VALIDATE_INT) ||
            empty($data["sexo"]) || empty($data["data_nascimento"]) || !isset($data["peso"])) {
            $this->call(
                400,
                "bad_request",
                "Os campos nome, raca_id, sexo, data_nascimento e peso são obrigatórios",
                "error"
            )->back(null);
            return;
        }

        $nome = trim($data["nome"]);
        $racaId = (int)$data["raca_id"];
        $sexo = trim($data["sexo"]);
        $dataNascimento = trim($data["data_nascimento"]);
        $peso = (float)$data["peso"];

        if ($nome === "" || $sexo === "" || $dataNascimento === "" || !is_numeric($peso)) {
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

        $animal = new Animal();
        $response = $animal->create($nome, $racaId, $sexo, $dataNascimento, $peso, $userId);

        if (!$response) {
            $this->call(
                500,
                "internal_server_error",
                "Não foi possível criar o animal",
                "error"
            )->back(null);
            return;
        }

        $this->call(201, "created", "Animal criado com sucesso", "success")
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

        //$  = json_decode(file_get_contents("php://input"), true);

        if (empty($data["nome"]) || !isset($data["raca_id"]) || !filter_var($data["raca_id"], FILTER_VALIDATE_INT) ||
            empty($data["sexo"]) || empty($data["data_nascimento"]) || !isset($data["peso"])) {
            $this->call(
                400,
                "bad_request",
                "Os campos nome, raca_id, sexo, data_nascimento e peso são obrigatórios",
                "error"
            )->back(null);
            return;
        }

        $id = (int)$data["id"];
        $nome = trim($data["nome"]);
        $racaId = (int)$data["raca_id"];
        $sexo = trim($data["sexo"]);
        $dataNascimento = trim($data["data_nascimento"]);
        $peso = (float)$data["peso"];

        if ($nome === "" || $sexo === "" || $dataNascimento === "" || !is_numeric($peso)) {
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

        $animal = new Animal();
        $existing = $animal->listById($id, $userId);

        if (!$existing) {
            $this->call(
                404,
                "not_found",
                "Animal não encontrado",
                "error"
            )->back(null);
            return;
        }

        $updated = $animal->update($id, $nome, $racaId, $sexo, $dataNascimento, $peso);

        if (!$updated) {
            $this->call(
                500,
                "internal_server_error",
                "Não foi possível atualizar o animal",
                "error"
            )->back(null);
            return;
        }

        $this->call(200, "success", "Animal atualizado com sucesso", "success")
            ->back($animal->listById($id, $userId));
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

        $animal = new Animal();
        $existing = $animal->listById($id, $userId);

        if (!$existing) {
            $this->call(
                404,
                "not_found",
                "Animal não encontrado",
                "error"
            )->back(null);
            return;
        }

        $deleted = $animal->delete($id);

        if (!$deleted) {
            $this->call(
                500,
                "internal_server_error",
                "Não foi possível excluir o animal",
                "error"
            )->back(null);
            return;
        }

        $this->call(200, "success", "Animal excluído com sucesso", "success")
            ->back(null);
    }
}
