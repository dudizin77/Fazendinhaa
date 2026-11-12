# 📁 api/

## Documentação do Web Service

Este arquivo documenta as rotas disponíveis na API, os parâmetros aceitos, exemplos de requisições e as respostas retornadas.

---

## Base URL

A API é exposta a partir da pasta `api/` do projeto.

- Exemplo local: `http://localhost/fazendinha/api`
- Exemplo de produção: `https://meu-dominio.com/api`

> O caminho completo de cada rota deve ser usado a partir da base `api/`.

---

## Formato de resposta padrão

Todas as respostas da API seguem o formato JSON abaixo:

```json
{
  "code": 200,
  "type": "success",
  "status": "success",
  "message": "Mensagem do servidor",
  "data": {}
}
```

- `code`: código HTTP retornado
- `type`: tipo de retorno (`success`, `error`)
- `status`: nome curto do resultado (`success`, `bad_request`, `not_found`, etc.)
- `message`: descrição legível do resultado
- `data`: conteúdo da resposta ou `null`

---

## Códigos de resposta usados pela API

- `200 OK`: requisição processada com sucesso
- `201 Created`: recurso criado com sucesso
- `400 Bad Request`: dados inválidos ou parâmetro obrigatório ausente
- `401 Unauthorized`: credenciais inválidas (login)
- `404 Not Found`: recurso não encontrado
- `409 Conflict`: recurso já existe (por exemplo, email duplicado)
- `500 Internal Server Error`: falha no servidor ou no salvamento de dados

---

## Autenticação e usuários

### Cadastro

- Método: `POST`
- Rota: `/users/register`
- Conteúdo: `application/json`

Body de exemplo:

```json
{
  "name": "João Silva",
  "email": "joao@example.com",
  "password": "senha123",
  "type_id": 2
}
```

Resposta de sucesso:

```json
{
  "code": 201,
  "type": "created",
  "status": "success",
  "message": "Usuário cadastrado com sucesso",
  "data": {
    "id": 1,
    "name": "João Silva",
    "email": "joao@example.com",
    "type_id": 2
  }
}
```

Erros possíveis:

- `400`: campos obrigatórios ausentes ou inválidos
- `409`: email já cadastrado
- `500`: falha ao criar usuário

### Login

- Método: `POST`
- Rota: `/users/login`
- Conteúdo: `application/json`

Body de exemplo:

```json
{
  "email": "joao@example.com",
  "password": "senha123"
}
```

Resposta de sucesso:

```json
{
  "code": 200,
  "type": "success",
  "status": "success",
  "message": "Login realizado com sucesso",
  "data": {
    "id": 1,
    "name": "João Silva",
    "email": "joao@example.com",
    "type_id": 2
  }
}
```

Erros possíveis:

- `400`: email ou senha ausentes / email inválido
- `401`: email ou senha incorretos

### Listar usuários

- Método: `GET`
- Rota: `/users/list`

Resposta de exemplo:

```json
{
  "code": 200,
  "type": "success",
  "status": "success",
  "message": "Lista de usuários",
  "data": [ ... ]
}
```

### Buscar usuário por ID

- Método: `GET`
- Rota: `/users/list/{id}`

Exemplo: `/users/list/1`

Erros possíveis:

- `400`: ID ausente ou inválido
- `404`: usuário não encontrado

### Atualizar usuário

- Método: `PUT`
- Rota: `/users/{id}`
- Conteúdo: `application/json`

Body de exemplo:

```json
{
  "name": "João Silva",
  "email": "joao.novo@example.com",
  "type_id": 2
}
```

Erros possíveis:

- `400`: ID inválido ou dados obrigatórios ausentes
- `404`: usuário não encontrado
- `500`: falha ao atualizar

### Excluir usuário

- Método: `DELETE`
- Rota: `/users/{id}`

Erros possíveis:

- `400`: ID inválido
- `404`: usuário não encontrado
- `500`: falha ao excluir

---

## Estrutura geral de rotas CRUD

As seguintes categorias de recursos têm os mesmos cinco tipos de endpoints:
- `GET /list` — lista todos
- `GET /list/{id}` — busca por ID
- `POST /` — cria
- `PUT /{id}` — atualiza
- `DELETE /{id}` — exclui

Abaixo estão as rotas disponíveis no Web Service.

---

## Recursos do sistema

### Products

- `GET /products/list/{product_id}`
- `GET /products/list`
- `GET /products/list/paginator/{page}/{per_page}`
- `POST /products/`
- `PUT /products/{product_id}`
- `DELETE /products/{product_id}`

> Uso: rotas de exercícios / desafios de produtos.

### FAQ categories

- `GET /faqs-categories/list/{category_id}`
- `GET /faqs-categories/list`
- `POST /faqs-categories/`
- `PUT /faqs-categories/{category_id}`
- `DELETE /faqs-categories/{category_id}`

### Espécies

- `GET /especies/list/{id}`
- `GET /especies/list`
- `POST /especies/`
- `PUT /especies/{id}`
- `DELETE /especies/{id}`

Body de criação / atualização:

```json
{
  "nome": "Bovino"
}
```

### Raças

- `GET /racas/list/{id}`
- `GET /racas/list`
- `POST /racas/`
- `PUT /racas/{id}`
- `DELETE /racas/{id}`

Body de criação / atualização:

```json
{
  "nome": "Nelore"
}
```

### Animais

- `GET /animais/list/{id}`
- `GET /animais/list`
- `POST /animais/`
- `PUT /animais/{id}`
- `DELETE /animais/{id}`

Body de criação:

```json
{
  "nome": "Juba",
  "raca_id": 3,
  "sexo": "M",
  "data_nascimento": "2024-01-10",
  "peso": 250.5,
  "user_id": 1
}
```

Para `PUT` de animal, os mesmos campos são obrigatórios.

Opção de filtro para listar animais por usuário:

- `GET /animais/list?user_id=1`

### Categorias de despesas

- `GET /categorias-despesas/list/{id}`
- `GET /categorias-despesas/list`
- `POST /categorias-despesas/`
- `PUT /categorias-despesas/{id}`
- `DELETE /categorias-despesas/{id}`

Body de criação / atualização:

```json
{
  "nome": "Ração"
}
```

### Despesas

- `GET /despesas/list/{id}`
- `GET /despesas/list`
- `POST /despesas/`
- `PUT /despesas/{id}`
- `DELETE /despesas/{id}`

Body de criação:

```json
{
  "categoria_id": 1,
  "descricao": "Compra de ração",
  "valor": 150.50,
  "data_despesa": "2026-06-30",
  "user_id": 1,
  "animal_id": 2,
  "grupo_id": 3
}
```

- `animal_id` e `grupo_id` são opcionais.
- `categoria_id`, `descricao`, `valor`, `data_despesa` e `user_id` são obrigatórios.

Para `GET` e `DELETE`, também é possível filtrar por usuário:

- `GET /despesas/list?user_id=1`
- `GET /despesas/list/5?user_id=1`

### Categorias de lucros

- `GET /categorias-lucros/list/{id}`
- `GET /categorias-lucros/list`
- `POST /categorias-lucros/`
- `PUT /categorias-lucros/{id}`
- `DELETE /categorias-lucros/{id}`

Body de criação / atualização:

```json
{
  "nome": "Venda de leite"
}
```

### Lucros

- `GET /lucros/list/{id}`
- `GET /lucros/list`
- `POST /lucros/`
- `PUT /lucros/{id}`
- `DELETE /lucros/{id}`

Body de criação:

```json
{
  "categoria_id": 1,
  "descricao": "Venda de gado",
  "valor": 1200.00,
  "data_lucro": "2026-06-30",
  "user_id": 1,
  "animal_id": 2,
  "grupo_id": 4
}
```

- `animal_id` e `grupo_id` são opcionais.
- `categoria_id`, `descricao`, `valor`, `data_lucro` e `user_id` são obrigatórios.

Para `GET` e `DELETE`, também é possível filtrar por usuário:

- `GET /lucros/list?user_id=1`
- `GET /lucros/list/5?user_id=1`

### Grupos

- `GET /grupos/list/{id}`
- `GET /grupos/list`
- `POST /grupos/`
- `PUT /grupos/{id}`
- `DELETE /grupos/{id}`

Body de criação:

```json
{
  "nome": "Rebanho A",
  "quantidade": 10,
  "user_id": 1
}
```

Body de atualização:

```json
{
  "nome": "Rebanho A",
  "quantidade": 12,
  "user_id": 1
}
```

- `user_id` é obrigatório para criação, atualização e exclusão.
- `GET /grupos/list?user_id=1` filtra os grupos do usuário.

---

## Exemplo de requisição cURL

```bash
curl -X POST "http://localhost/fazendinha/api/users/register" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "João Silva",
    "email": "joao@example.com",
    "password": "senha123",
    "type_id": 2
  }'
```

```bash
curl -X GET "http://localhost/fazendinha/api/animais/list?user_id=1"
```

```bash
curl -X POST "http://localhost/fazendinha/api/despesas/" \
  -H "Content-Type: application/json" \
  -d '{
    "categoria_id": 1,
    "descricao": "Compra de ração",
    "valor": 120.50,
    "data_despesa": "2026-06-30",
    "user_id": 1
  }'
```

---

## Observações importantes

- Alguns endpoints aceitam o parâmetro `user_id` como filtro na query string.
- Todos os dados enviados no corpo das requisições `POST` e `PUT` devem estar em JSON.
- Se algum campo obrigatório estiver ausente ou inválido, a API retorna `400 Bad Request`.
- Quando o recurso não existir, a API retorna `404 Not Found`.

---

## Onde está o código

- `api/index.php`: define as rotas e regras de roteamento
- `api/source/Controller/`: contém os controllers que recebem as requisições
- `api/source/Models/`: contém os models que acessam o banco de dados

> A documentação está neste arquivo `api/README.MD`.

