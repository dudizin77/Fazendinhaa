<?php

namespace Source\Controller;

use Source\Controller\Api;
use Source\Models\Fazendinha\Raca;

class Racas extends Api
{
    public function listAll(array $data): void
    {
        $raca = new Raca();
        $response = $raca->listAll();

        $this->call(200, "success", "Lista de raças", "success")
            ->back($response);
    }

    public function listById(array $data): void
    {
        if (!isset($data["id"]) || !filter_var($data["id"], FILTER_VALIDATE_INT)) {
            $this->call(
                400,
                "bad_request",
                "ID da raça é obrigatório e deve ser um número inteiro",
                "error"
            )->back(null);
            return;
        }

        $raca = new Raca();
        $racaData = $raca->listById((int)$data["id"]);

        if (!$racaData) {
            $this->call(
                404,
                "not_found",
                "Raça não encontrada",
                "error"
            )->back(null);
            return;
        }

        $this->call(200, "success", "Raça encontrada", "success")
            ->back($racaData);
    }

    public function insert(array $data): void
    {
        //$body = json_decode(file_get_contents("php://input"), true);

        if (empty($data["nome"]) || !isset($data["especie_id"]) || !filter_var($data["especie_id"], FILTER_VALIDATE_INT)) {
            $this->call(
                400,
                "bad_request",
                "Os campos nome e especie_id são obrigatórios",
                "error"
            )->back(null);
            return;
        }

        $nome = trim($data["nome"]);
        $especieId = (int)$data["especie_id"];

        if ($nome === "") {
            $this->call(
                400,
                "bad_request",
                "O campo nome não pode estar vazio",
                "error"
            )->back(null);
            return;
        }

        $raca = new Raca();
        $response = $raca->create($especieId, $nome);

        if (!$response) {
            $this->call(
                500,
                "internal_server_error",
                "Não foi possível criar a raça",
                "error"
            )->back(null);
            return;
        }

        $this->call(201, "created", "Raça criada com sucesso", "success")
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

        if (empty($data["nome"]) || !isset($data["especie_id"]) || !filter_var($data["especie_id"], FILTER_VALIDATE_INT)) {
            $this->call(
                400,
                "bad_request",
                "Os campos nome e especie_id são obrigatórios",
                "error"
            )->back(null);
            return;
        }

        $nome = trim($data["nome"]);
        $id = (int)$data["id"];
        $especieId = (int)$data["especie_id"];

        if ($nome === "") {
            $this->call(
                400,
                "bad_request",
                "O campo nome não pode estar vazio",
                "error"
            )->back(null);
            return;
        }

        $raca = new Raca();
        $existing = $raca->listById($id);

        if (!$existing) {
            $this->call(
                404,
                "not_found",
                "Raça não encontrada",
                "error"
            )->back(null);
            return;
        }

        $updated = $raca->update($id, $especieId, $nome);

        if (!$updated) {
            $this->call(
                500,
                "internal_server_error",
                "Não foi possível atualizar a raça",
                "error"
            )->back(null);
            return;
        }

        $this->call(200, "success", "Raça atualizada com sucesso", "success")
            ->back($raca->listById($id));
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
        $raca = new Raca();
        $existing = $raca->listById($id);

        if (!$existing) {
            $this->call(
                404,
                "not_found",
                "Raça não encontrada",
                "error"
            )->back(null);
            return;
        }

        $deleted = $raca->delete($id);

        if (!$deleted) {
            $this->call(
                500,
                "internal_server_error",
                "Não foi possível excluir a raça",
                "error"
            )->back(null);
            return;
        }

        $this->call(200, "success", "Raça excluída com sucesso", "success")
            ->back(null);
    }
}
