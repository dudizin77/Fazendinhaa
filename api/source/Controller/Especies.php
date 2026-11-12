<?php

namespace Source\Controller;

use Source\Controller\Api;
use Source\Models\Fazendinha\Especie;

class Especies extends Api
{
    public function listAll(array $data): void
    {
        $especie = new Especie();
        $response = $especie->listAll();

        $this->call(200, "success", "Lista de espécies", "success")
            ->back($response);
    }

    public function listById(array $data): void
    {
        if (!isset($data["id"]) || !filter_var($data["id"], FILTER_VALIDATE_INT)) {
            $this->call(
                400,
                "bad_request",
                "ID da espécie é obrigatório e deve ser um número inteiro",
                "error"
            )->back(null);
            return;
        }

        $especie = new Especie();
        $especieData = $especie->listById((int)$data["id"]);

        if (!$especieData) {
            $this->call(
                404,
                "not_found",
                "Espécie não encontrada",
                "error"
            )->back(null);
            return;
        }

        $this->call(200, "success", "Espécie encontrada", "success")
            ->back($especieData);
    }

    public function insert(array $data): void
    {
        //$body = json_decode(file_get_contents("php://input"), true);

        if (empty($data["nome"])) {
            $this->call(
                400,
                "bad_request",
                "O campo nome é obrigatório",
                "error"
            )->back(null);
            return;
        }

        $nome = trim($data["nome"]);

        if ($nome === "") {
            $this->call(
                400,
                "bad_request",
                "O campo nome não pode estar vazio",
                "error"
            )->back(null);
            return;
        }

        $especie = new Especie();
        $response = $especie->create($nome);

        if (!$response) {
            $this->call(
                500,
                "internal_server_error",
                "Não foi possível criar a espécie",
                "error"
            )->back(null);
            return;
        }

        $this->call(201, "created", "Espécie criada com sucesso", "success")
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

        if (empty($data["nome"])) {
            $this->call(
                400,
                "bad_request",
                "O campo nome é obrigatório",
                "error"
            )->back(null);
            return;
        }

        $nome = trim($data["nome"]);
        $id = (int)$data["id"];

        if ($nome === "") {
            $this->call(
                400,
                "bad_request",
                "O campo nome não pode estar vazio",
                "error"
            )->back(null);
            return;
        }

        $especie = new Especie();
        $existing = $especie->listById($id);

        if (!$existing) {
            $this->call(
                404,
                "not_found",
                "Espécie não encontrada",
                "error"
            )->back(null);
            return;
        }

        $updated = $especie->update($id, $nome);

        if (!$updated) {
            $this->call(
                500,
                "internal_server_error",
                "Não foi possível atualizar a espécie",
                "error"
            )->back(null);
            return;
        }

        $this->call(200, "success", "Espécie atualizada com sucesso", "success")
            ->back($especie->listById($id));
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
        $especie = new Especie();
        $existing = $especie->listById($id);

        if (!$existing) {
            $this->call(
                404,
                "not_found",
                "Espécie não encontrada",
                "error"
            )->back(null);
            return;
        }

        $deleted = $especie->delete($id);

        if (!$deleted) {
            $this->call(
                500,
                "internal_server_error",
                "Não foi possível excluir a espécie",
                "error"
            )->back(null);
            return;
        }

        $this->call(200, "success", "Espécie excluída com sucesso", "success")
            ->back(null);
    }
}
