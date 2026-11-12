<?php

namespace Source\Models;

use Source\Core\Connect;

class Product
{
    private ?int $id;
    private ?int $categoryId;
    private ?string $name;
    private ?float $price;

    public function __construct(?int $id = null, ?int $categoryId = null, ?string $name = null, ?float $price = null)
    {
        $this->id = $id;
        $this->categoryId = $categoryId;
        $this->name = $name;
        $this->price = $price;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function setCategoryId(int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function listAll(): array
    {
        $query = "SELECT products.id, products.name, products.price, products_categories.name AS category_name
                  FROM products
                  JOIN products_categories ON products.category_id = products_categories.id
                  WHERE products.active = 1";
        $stmt = Connect::getInstance()->query($query);
        return $stmt->fetchAll();
    }

    public function listById(int $id): object|false
    {
        $query = "SELECT products.id, products.name, products.price, products_categories.name AS category_name
                  FROM products
                  JOIN products_categories ON products.category_id = products_categories.id
                  WHERE products.id = :id AND products.active = 1";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":id", $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function create(string $name, float $price, int $categoryId): object|false
    {
        $query = "INSERT INTO products (name, price, category_id, active) VALUES (:name, :price, :category_id, 1)";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":category_id", $categoryId, \PDO::PARAM_INT);

        if (!$stmt->execute()) {
            return false;
        }

        $id = Connect::getInstance()->lastInsertId();
        return $this->listById((int)$id);
    }

    public function update(int $id, string $name, float $price, int $categoryId): bool
    {
        $query = "UPDATE products SET name = :name, price = :price, category_id = :category_id WHERE id = :id AND active = 1";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":category_id", $categoryId, \PDO::PARAM_INT);
        $stmt->bindParam(":id", $id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function deactivate(int $id): bool
    {
        $query = "UPDATE products SET active = 0 WHERE id = :id AND active = 1";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":id", $id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}
