<?php 

namespace source\Controller;

use Source\Controller\Api;
use Source\Models\ProductCategory;

class ProductsCategories extends Api
{
    public function productsCategoriesList(array $data): void
    {
        $category = new ProductCategory();
        $response = $category->listAll();

        $this->call(200, "success", "Lista de categorias", "success")
            ->back($response);
    }

    public function productsCategoriesListById(array $data): void
    {
        if (!filter_var($data["categoryId"], FILTER_VALIDATE_INT)) {
            $this->call(
                400,
                "bad_request",
                "ID da categoria do produto é obrigatório e deve ser um número inteiro",
                "error"
            )->back(null);
            return;
        }

        $category = new ProductCategory();
        $response = $category->listById((int)$data["categoryId"]);

        if (!$response) {
            $this->call(
                404,
                "not_found",
                "Categoria não encontrada",
                "error"
            )->back(null);
            return;
        }

        $this->call(200, "success", "Categoria encontrada", "success")
            ->back($response);
    }

    public function createCategory(array $data): void
    {
        $body = json_decode(file_get_contents("php://input"), true);

        if (empty($body["name"])) {
            $this->call(
                400,
                "bad_request",
                "O campo nome é obrigatório",
                "error"
            )->back(null);
            return;
        }

        $name = trim($body["name"]);

        if ($name === "") {
            $this->call(
                400,
                "bad_request",
                "O campo nome é obrigatório",
                "error"
            )->back(null);
            return;
        }

        $category = new ProductCategory();
        $response = $category->create($name);

        if (!$response) {
            $this->call(
                500,
                "internal_server_error",
                "Não foi possível cadastrar o produto",
                "error"
            )->back(null);
            return;
        }

        $this->call(201, "created", "Categoria de Produto criada com sucesso", "success")
            ->back($response);
    }
}