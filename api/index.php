<?php

error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
// timezone para São Paulo América
date_default_timezone_set('America/Sao_Paulo');

ob_start();

require  __DIR__ . "/vendor/autoload.php";

// os headers abaixo são necessários para permitir o acesso a API por clientes externos ao domínio
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header('Access-Control-Allow-Credentials: true'); // Permitir credenciais

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

use CoffeeCode\Router\Router;
// localhost/acme-3am/api
$route = new Router(url("api"),":");

$route->namespace("Source\Controller");
// localhost/acme-3am/api/hello
//$route->get("/hello", "Api:hello");

// Início - Exercícios - Desafios
$route->group("/products");
$route->get("/list/{product_id}","Products:listById"); // select by id
$route->get("/list","Products:listAll"); // select all
$route->get("/list/paginator/{page}/{per_page}","Products:listPaginator"); // select all
$route->post("/","Products:insert"); // insert
$route->put("/{product_id}","Products:update"); // update
$route->delete("/{product_id}","Products:delete"); // update
$route->group(null);
// Fim - Exercícios - Desafios

// FAQs
$route->group("/faqs");
$route->get("/","Faqs:listAll");
$route->get("/admin/list","Faqs:listAllAdmin");
$route->get("/{faqId}","Faqs:listById");
$route->get("/category/{categoryId}","Faqs:listByCategory");
$route->post("/","Faqs:insert");
$route->put("/{faqId}","Faqs:update");
$route->delete("/{faqId}","Faqs:delete");
$route->group(null);
// Categorias de FAQs
$route->group("/faqs-categories");
$route->get("/","FaqsCategories:listAll");
$route->get("/{categoryId}","FaqsCategories:listById");
$route->post("/","FaqsCategories:insert");
$route->put("/{categoryId}","FaqsCategories:update");
$route->delete("/{categoryId}","FaqsCategories:delete");
$route->group(null);

// Rotas de Autenticação

$route->group("/users");
$route->post("/register","Users:register"); // Registrar usuário comum
$route->post("/login","Users:auth"); // login de usuário comum
$route->post("/login-athlete","Users:authAthlete"); // login exclusivo de corredor
$route->get("/me","Users:me"); // Get the authenticated user's profile
$route->put("/update","Users:update"); // update de usuário comum
$route->post("/register-admin","Users:registerAdmin"); // Registrar usuário admin NÃO IMPLEMENTADO
$route->post("/login-admin","Users:authAdmin"); // login de usuário admin
$route->put("/update-admin","Users:updateAdmin"); // update de usuário admin
$route->post("/photo","Users:uploadPhoto"); // upload de foto de usuário
$route->group(null);









$route->group("/especies");

$route->get("/list/{id}", "Especies:listById");
$route->get("/list", "Especies:listAll");
$route->post("/", "Especies:insert");
$route->put("/{id}", "Especies:update");
$route->delete("/{id}", "Especies:delete");

$route->group(null);








$route->group("/racas");

$route->get("/list/{id}", "Racas:listById");
$route->get("/list", "Racas:listAll");
$route->post("/", "Racas:insert");
$route->put("/{id}", "Racas:update");
$route->delete("/{id}", "Racas:delete");

$route->group(null);







$route->group("/animais");

$route->get("/list/{id}", "Animais:listById");
$route->get("/list", "Animais:listAll");
$route->post("/", "Animais:insert");
$route->put("/{id}", "Animais:update");
$route->delete("/{id}", "Animais:delete");

$route->group(null);






$route->group("/categorias-despesas");

$route->get("/list/{id}", "CategoriasDespesas:listById");
$route->get("/list", "CategoriasDespesas:listAll");
$route->post("/", "CategoriasDespesas:insert");
$route->put("/{id}", "CategoriasDespesas:update");
$route->delete("/{id}", "CategoriasDespesas:delete");

$route->group(null);







$route->group("/despesas");

$route->get("/list/{id}", "Despesas:listById");
$route->get("/list", "Despesas:listAll");
$route->post("/", "Despesas:insert");
$route->put("/{id}", "Despesas:update");
$route->delete("/{id}", "Despesas:delete");

$route->group(null);







$route->group("/categorias-lucros");

$route->get("/list/{id}", "CategoriasLucros:listById");
$route->get("/list", "CategoriasLucros:listAll");
$route->post("/", "CategoriasLucros:insert");
$route->put("/{id}", "CategoriasLucros:update");
$route->delete("/{id}", "CategoriasLucros:delete");

$route->group(null);




$route->group("/lucros");

$route->get("/list/{id}", "Lucros:listById");
$route->get("/list", "Lucros:listAll");
$route->post("/", "Lucros:insert");
$route->put("/{id}", "Lucros:update");
$route->delete("/{id}", "Lucros:delete");

$route->group(null);

$route->group("/grupos");
$route->get("/list/{id}", "Grupos:listById");
$route->get("/list", "Grupos:listAll");
$route->post("/", "Grupos:insert");
$route->put("/{id}", "Grupos:update");
$route->delete("/{id}", "Grupos:delete");
$route->group(null);

/*
$route->group("/products");
$route->get("/products/list", "Products:productsList");
$route->get("/products/list/{productId}","Products:productsListById");
//
$route->post("/products", "Products:createProduct");
$route->put("/products/{productId}", "Products:updateProduct");
$route->delete("/products/{productId}", "Products:deleteProduct");

$route->get("/products-categories/list", "ProductsCategories:productsCategoriesList");
//
$route->get("/categories-products/list/{categoryId}","ProductsCategories:productsCategoriesListById");
$route->post("/categories-products", "ProductsCategories:createCategory");
$route->get("/users/list", "Users:usersList");
$route->group(null);

$route->get("/hello", "Hello:tchau");

$route->group("/faqs");
$route->get("/faqCategory/list", "faqCategories:faqCategoriesList");
$route->group(null);
*/
$route->dispatch();

/** ERROR REDIRECT */
if ($route->error()) {
    header('Content-Type: application/json; charset=UTF-8');
    //http_response_code(404);

    echo json_encode([
        "code" => 404,
        "status" => "not_found",
        "message" => "URL não encontrada"
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

}

ob_end_flush();