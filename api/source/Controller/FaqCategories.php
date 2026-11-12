<?php

namespace source\Controller;

use Source\Controller\Api;
use Source\Models\Faqs\FaqCategory;

class FaqCategories extends Api
{
    public function listAll(array $data): void
    {
        $cat = new FaqCategory();
        $response = $cat->listAll();

        $this->call(200, "success", "Lista de Categorias de FAQ", "success")->back($response);
    }

    public function listById(array $data): void
    {
        if (!filter_var($data["category_id"], FILTER_VALIDATE_INT)) {
            $this->call(400, "bad_request", "ID da categoria é obrigatório e deve ser um número inteiro", "error")->back(null);
            return;
        }

        $cat = new FaqCategory();
        $response = $cat->listById((int)$data["category_id"]);

        if (!$response) {
            $this->call(404, "not_found", "Categoria não encontrada", "error")->back(null);
            return;
        }

        $this->call(200, "success", "Categoria encontrada", "success")->back($response);
    }

    public function insert(array $data): void
    {
        $body = json_decode(file_get_contents("php://input"), true);

        if (empty($body["name"])) {
            $this->call(400, "bad_request", "O campo nome é obrigatório", "error")->back(null);
            return;
        }

        $name = trim($body["name"]);

        if ($name === "") {
            $this->call(400, "bad_request", "O campo nome é obrigatório", "error")->back(null);
            return;
        }

        $cat = new FaqCategory();
        $response = $cat->create($name);

        if (!$response) {
            $this->call(500, "internal_server_error", "Não foi possível cadastrar a categoria de FAQ", "error")->back(null);
            return;
        }

        $this->call(201, "created", "Categoria de FAQ criada com sucesso", "success")->back($response);
    }

    public function update(array $data): void
    {
        if (!filter_var($data["category_id"], FILTER_VALIDATE_INT)) {
            $this->call(400, "bad_request", "ID da categoria é obrigatório e deve ser um número inteiro", "error")->back(null);
            return;
        }

        $body = json_decode(file_get_contents("php://input"), true);

        if (empty($body["name"])) {
            $this->call(400, "bad_request", "O campo nome é obrigatório", "error")->back(null);
            return;
        }

        $name = trim($body["name"]);
        $categoryId = (int)$data["category_id"];

        $cat = new FaqCategory();
        $existing = $cat->listById($categoryId);

        if (!$existing) {
            $this->call(404, "not_found", "Categoria não encontrada", "error")->back(null);
            return;
        }

        $updated = $cat->update($categoryId, $name);

        if (!$updated) {
            $this->call(500, "internal_server_error", "Não foi possível atualizar a categoria", "error")->back(null);
            return;
        }

        $response = $cat->listById($categoryId);
        $this->call(200, "success", "Categoria atualizada com sucesso", "success")->back($response);
    }

    public function delete(array $data): void
    {
        if (!filter_var($data["category_id"], FILTER_VALIDATE_INT)) {
            $this->call(400, "bad_request", "ID da categoria é obrigatório e deve ser um número inteiro", "error")->back(null);
            return;
        }

        $categoryId = (int)$data["category_id"];
        $cat = new FaqCategory();

        if ($cat->hasActiveFaqs($categoryId)) {
            $this->call(400, "bad_request", "Não é possível remover uma categoria que possui FAQs ativos", "error")->back(null);
            return;
        }

        $deleted = $cat->deactivate($categoryId);

        if (!$deleted) {
            $this->call(404, "not_found", "Categoria não encontrada", "error")->back(null);
            return;
        }

        $this->call(200, "success", "Categoria removida com sucesso", "success")->back(null);
    }
}
