<?php

namespace Source\Models\Fazendinha;

use Source\Core\Connect;
use PDO;
use PDOException;

class Grupo
{
    private ?int $id;
    private ?string $nome;
    private ?int $quantidade;

    public function __construct(?int $id = null, ?string $nome = null, ?int $quantidade = null)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->quantidade = $quantidade;
    }

    public function listAll(): array
    {
        try {
            return [];
        } catch (PDOException $e) {
            return [];
        }
    }

    public function listAllByUser(?int $userId = null): array
    {
        try {
            if ($userId === null) {
                // return global groups (no owner)
                $query = "SELECT id, nome, quantidade, user_id FROM grupos_animais WHERE user_id IS NULL";
                $stmt = Connect::getInstance()->query($query);
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            }

            // return groups owned by user OR global groups
            $query = "SELECT id, nome, quantidade, user_id FROM grupos_animais WHERE user_id = :user_id OR user_id IS NULL";
            $stmt = Connect::getInstance()->prepare($query);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function listById(int $id, ?int $userId = null): object|false
    {
        try {
            $query = "SELECT id, nome, quantidade, user_id FROM grupos_animais WHERE id = :id";
            if ($userId !== null) $query .= " AND (user_id = :user_id OR user_id IS NULL)";
            $query .= " LIMIT 1";
            $stmt = Connect::getInstance()->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            if ($userId !== null) $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function create(string $nome, int $quantidade, int $userId): object|false
    {
        try {
            $query = "INSERT INTO grupos_animais (nome, quantidade, user_id) VALUES (:nome, :quantidade, :user_id)";
            $stmt = Connect::getInstance()->prepare($query);
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":quantidade", $quantidade, PDO::PARAM_INT);
            $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
            if (!$stmt->execute()) return false;
            $id = Connect::getInstance()->lastInsertId();
            return $this->listById((int)$id, $userId);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update(int $id, string $nome, int $quantidade): bool
    {
        try {
            $query = "UPDATE grupos_animais SET nome = :nome, quantidade = :quantidade WHERE id = :id";
            $stmt = Connect::getInstance()->prepare($query);
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":quantidade", $quantidade, PDO::PARAM_INT);
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
            $query = "DELETE FROM grupos_animais WHERE id = :id";
            $stmt = Connect::getInstance()->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}
