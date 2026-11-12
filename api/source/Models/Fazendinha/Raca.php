<?php

namespace Source\Models\Fazendinha;

use Source\Core\Connect;
use PDO;
use PDOException;

class Raca
{
    private ?int $id;
    private ?int $especieId;
    private ?string $nome;

    public function __construct(?int $id = null, ?int $especieId = null, ?string $nome = null)
    {
        $this->id = $id;
        $this->especieId = $especieId;
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

    public function getEspecieId(): ?int
    {
        return $this->especieId;
    }

    public function setEspecieId(int $especieId): void
    {
        $this->especieId = $especieId;
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
            $query = "SELECT r.id, r.especie_id, r.nome, e.nome AS especie_nome 
                      FROM racas r
                      LEFT JOIN especies e ON r.especie_id = e.id";
            $stmt = Connect::getInstance()->query($query);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function listById(int $id): object|false
    {
        try {
            $query = "SELECT r.id, r.especie_id, r.nome, e.nome AS especie_nome 
                      FROM racas r
                      LEFT JOIN especies e ON r.especie_id = e.id
                      WHERE r.id = :id LIMIT 1";
            $stmt = Connect::getInstance()->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function create(int $especieId, string $nome): object|false
    {
        try {
            $query = "INSERT INTO racas (especie_id, nome) VALUES (:especie_id, :nome)";
            $stmt = Connect::getInstance()->prepare($query);
            $stmt->bindParam(":especie_id", $especieId, PDO::PARAM_INT);
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

    public function update(int $id, int $especieId, string $nome): bool
    {
        try {
            $query = "UPDATE racas SET especie_id = :especie_id, nome = :nome WHERE id = :id";
            $stmt = Connect::getInstance()->prepare($query);
            $stmt->bindParam(":especie_id", $especieId, PDO::PARAM_INT);
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
            $query = "DELETE FROM racas WHERE id = :id";
            $stmt = Connect::getInstance()->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}
