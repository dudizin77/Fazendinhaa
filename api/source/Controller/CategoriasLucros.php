<?php

namespace Source\Controller;

use Source\Controller\Api;
use Source\Models\Fazendinha\CategoriaLucro;

class CategoriasLucros extends Api
{
    public function listAll(array $data): void
    {
        $categoriaLucro = new CategoriaLucro();
        $response = $categoriaLucro->listAll();

        $this->call(200, "success", "Lista de categorias de lucros", "success")
            ->back($response);
    }

    public function listById(array $data): void
    {
        if (!isset($data["id"]) || !filter_var($data["id"], FILTER_VALIDATE_INT)) {
            $this->call(
                400,
                "bad_request",
                "ID da categoria de lucro é obrigatório e deve ser um número inteiro",
                "error"
            )->back(null);
            return;
        }

        $categoriaLucro = new CategoriaLucro();
        $categoriaData = $categoriaLucro->listById((int)$data["id"]);

        if (!$categoriaData) {
            $this->call(
                404,
                "not_found",
                "Categoria de lucro não encontrada",
                "error"
            )->back(null);
            return;
        }

        $this->call(200, "success", "Categoria de lucro encontrada", "success")
            ->back($categoriaData);
    }

    public function insert(array $data): void
    {
        $body = json_decode(file_get_contents("php://input"), true);

        if (empty($body["nome"])) {
            $this->call(
                400,
                "bad_request",
                "O campo nome é obrigatório",
                "error"
            )->back(null);
            return;
        }

        $nome = trim($body["nome"]);

        if ($nome === "") {
            $this->call(
                400,
                "bad_request",
                "O campo nome não pode estar vazio",
                "error"
            )->back(null);
            return;
        }

        $categoriaLucro = new CategoriaLucro();
        $response = $categoriaLucro->create($nome);

        if (!$response) {
            $this->call(
                500,
                "internal_server_error",
                "Não foi possível criar a categoria de lucro",
                "error"
            )->back(null);
            return;
        }

        $this->call(201, "created", "Categoria de lucro criada com sucesso", "success")
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

        $categoriaLucro = new CategoriaLucro();
        $existing = $categoriaLucro->listById($id);

        if (!$existing) {
            $this->call(
                404,
                "not_found",
                "Categoria de lucro não encontrada",
                "error"
            )->back(null);
            return;
        }

        $updated = $categoriaLucro->update($id, $nome);

        if (!$updated) {
            $this->call(
                500,
                "internal_server_error",
                "Não foi possível atualizar a categoria de lucro",
                "error"
            )->back(null);
            return;
        }

        $this->call(200, "success", "Categoria de lucro atualizada com sucesso", "success")
            ->back($categoriaLucro->listById($id));
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
        $categoriaLucro = new CategoriaLucro();
        $existing = $categoriaLucro->listById($id);

        if (!$existing) {
            $this->call(
                404,
                "not_found",
                "Categoria de lucro não encontrada",
                "error"
            )->back(null);
            return;
        }

        $deleted = $categoriaLucro->delete($id);

        if (!$deleted) {
            $this->call(
                500,
                "internal_server_error",
                "Não foi possível excluir a categoria de lucro",
                "error"
            )->back(null);
            return;
        }

        $this->call(200, "success", "Categoria de lucro excluída com sucesso", "success")
            ->back(null);
    }
}
