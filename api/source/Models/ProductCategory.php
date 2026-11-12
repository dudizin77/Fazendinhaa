<?php 

namespace Source\Models;

use Source\Core\Connect;

class ProductCategory
{
    public function listAll(): array
    {
        $query = "SELECT id, name FROM products_categories";
        $stmt = Connect::getInstance()->query($query);
        return $stmt->fetchAll();
    }

    public function listById(int $id): object|false
    {
        $query = "SELECT id, name FROM products_categories WHERE id = :id";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindValue(":id", $id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function create(string $name): object|false
    {
        $query = "INSERT INTO products_categories (name) VALUES (:name)";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":name", $name);

        if (!$stmt->execute()) {
            return false;
        }

        $id = Connect::getInstance()->lastInsertId();
        return $this->listById((int)$id);
    }
}
