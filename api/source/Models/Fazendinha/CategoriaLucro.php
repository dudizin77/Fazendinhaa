<?php

namespace Source\Models\Fazendinha;

use Source\Core\Connect;
use PDO;
use PDOException;

class CategoriaLucro
{
    private ?int $id;
    private ?string $nome;

    public function __construct(?int $id = null, ?string $nome = null)
    {
        $this->id = $id;
        $this->nome = $nome;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function listAll(): array
    {
        try {
            $query = "SELECT * FROM categorias_lucros WHERE id IS NOT NULL";
            $stmt = Connect::getInstance()->query($query);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function listById(int $id): object|false
    {
        try {
            $query = "SELECT * FROM categorias_lucros WHERE id = :id LIMIT 1";
            $stmt = Connect::getInstance()->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function create(string $nome): object|false
    {
        try {
            $query = "INSERT INTO categorias_lucros (nome) VALUES (:nome)";
            $stmt = Connect::getInstance()->prepare($query);
            $stmt->bindParam(":nome", $nome);

            if (!$stmt->execute()) {
                return false;
            }

            $id = Connect::getInstance()->lastInsertId();
            return $this->listById((int)$id);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update(int $id, string $nome): bool
    {
        try {
            $query = "UPDATE categorias_lucros SET nome = :nome WHERE id = :id";
            $stmt = Connect::getInstance()->prepare($query);
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $query = "DELETE FROM categorias_lucros WHERE id = :id";
            $stmt = Connect::getInstance()->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}
