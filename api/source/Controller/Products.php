<?php

namespace source\Controller;

use Source\Controller\Api;
use Source\Models\Product;

class Products extends Api
{
    public function productsList(array $data): void
    {
        $product = new Product();
        $response = $product->listAll();

        $this->call(200, "success", "Lista de produtos", "success")
            ->back($response);
    }

    public function productsListById(array $data): void
    {
        if (!filter_var($data["productId"], FILTER_VALIDATE_INT)) {
            $this->call(
                400,
                "bad_request",
                "ID do produto é obrigatório e deve ser um número inteiro",
                "error"
            )
                ->back(null);
            return;
        }

        $product = new Product();
        $productData = $product->listById((int)$data["productId"]);

        if (!$productData) {
            $this->call(
                404,
                "not_found",
                "Produto não encontrado",
                "error"
            )->back(null);
            return;
        }

        $this->call(200, "success", "Produto encontrado", "success")
            ->back($productData);
    }

    public function createProduct(array $data): void
    {
        $body = json_decode(file_get_contents("php://input"), true);

        if (empty($body["name"]) || !isset($body["price"]) || !isset($body["category_id"])) {
            $this->call(
                400,
                "bad_request",
                "Os campos name, price e category_id são obrigatórios",
                "error"
            )->back(null);
            return;
        }

        $name = trim($body["name"]);
        $price = $body["price"];
        $categoryId = $body["category_id"];

        if ($name === "" || !is_numeric($price) || !filter_var($categoryId, FILTER_VALIDATE_INT)) {
            $this->call(
                400,
                "bad_request",
                "Os campos name, price e category_id são obrigatórios",
                "error"
            )->back(null);
            return;
        }

        $product = new Product();
        $response = $product->create($name, (float)$price, (int)$categoryId);

        if (!$response) {
            $this->call(
                500,
                "internal_server_error",
                "Não foi possível cadastrar o produto",
                "error"
            )->back(null);
            return;
        }

        $this->call(201, "created", "Produto criado com sucesso", "success")
            ->back($response);
    }

    public function updateProduct(array $data): void
    {
        if (!filter_var($data["productId"], FILTER_VALIDATE_INT)) {
            $this->call(
                400,
                "bad_request",
                "ID inválido ou campos obrigatórios ausentes",
                "error"
            )->back(null);
            return;
        }

        $body = json_decode(file_get_contents("php://input"), true);

        if (empty($body["name"]) || !isset($body["price"]) || !isset($body["category_id"])) {
            $this->call(
                400,
                "bad_request",
                "ID inválido ou campos obrigatórios ausentes",
                "error"
            )->back(null);
            return;
        }

        $name = trim($body["name"]);
        $price = $body["price"];
        $categoryId = $body["category_id"];
        $productId = (int)$data["productId"];

        if ($name === "" || !is_numeric($price) || !filter_var($categoryId, FILTER_VALIDATE_INT)) {
            $this->call(
                400,
                "bad_request",
                "ID inválido ou campos obrigatórios ausentes",
                "error"
            )->back(null);
            return;
        }

        $product = new Product();
        $existing = $product->listById($productId);

        if (!$existing) {
            $this->call(
                404,
                "not_found",
                "Produto não encontrado",
                "error"
            )->back(null);
            return;
        }

        $updated = $product->update($productId, $name, (float)$price, (int)$categoryId);

        if (!$updated) {
            $this->call(
                500,
                "internal_server_error",
                "Não foi possível atualizar o produto",
                "error"
            )->back(null);
            return;
        }

        $productData = $product->listById($productId);

        $this->call(200, "success", "Produto atualizado com sucesso", "success")
            ->back($productData);
    }

    public function deleteProduct(array $data): void
    {
        if (!filter_var($data["productId"], FILTER_VALIDATE_INT)) {
            $this->call(
                400,
                "bad_request",
                "ID do produto é obrigatório e deve ser um número inteiro",
                "error"
            )->back(null);
            return;
        }

        $product = new Product();
        $deleted = $product->deactivate((int)$data["productId"]);

        if (!$deleted) {
            $this->call(
                404,
                "not_found",
                "Produto não encontrado",
                "error"
            )->back(null);
            return;
        }

        $this->call(200, "success", "Produto removido com sucesso", "success")
            ->back(null);
    }
}
