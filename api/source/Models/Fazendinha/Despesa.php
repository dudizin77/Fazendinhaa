<?php

namespace Source\Models\Fazendinha;

use Source\Core\Connect;
use PDO;
use PDOException;

class Despesa
{
    private ?int $id;
    private ?int $animalId;
    private ?int $categoriaId;
    private ?string $descricao;
    private ?float $valor;
    private ?string $dataDespesa;

    public function __construct(?int $id = null, ?int $animalId = null, ?int $categoriaId = null, ?string $descricao = null, ?float $valor = null, ?string $dataDespesa = null)
    {
        $this->id = $id;
        $this->animalId = $animalId;
        $this->categoriaId = $categoriaId;
        $this->descricao = $descricao;
        $this->valor = $valor;
        $this->dataDespesa = $dataDespesa;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getAnimalId(): ?int
    {
        return $this->animalId;
    }

    public function setAnimalId(int $animalId): void
    {
        $this->animalId = $animalId;
    }

    public function getCategoriaId(): ?int
    {
        return $this->categoriaId;
    }

    public function setCategoriaId(int $categoriaId): void
    {
        $this->categoriaId = $categoriaId;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): void
    {
        $this->descricao = $descricao;
    }

    public function getValor(): ?float
    {
        return $this->valor;
    }

    public function setValor(float $valor): void
    {
        $this->valor = $valor;
    }

    public function getDataDespesa(): ?string
    {
        return $this->dataDespesa;
    }

    public function setDataDespesa(string $dataDespesa): void
    {
        $this->dataDespesa = $dataDespesa;
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
            if ($userId === null) return [];
            $query = "SELECT d.id, d.animal_id, d.grupo_id, d.categoria_id, d.descricao, d.valor, d.data_despesa, 
                             a.nome AS animal_nome, g.nome AS grupo_nome, cd.nome AS categoria_nome
                      FROM despesas d
                      LEFT JOIN animais a ON d.animal_id = a.id
                      LEFT JOIN grupos_animais g ON d.grupo_id = g.id
                      LEFT JOIN categorias_despesas cd ON d.categoria_id = cd.id
                      WHERE d.user_id = :user_id";
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
            $query = "SELECT d.id, d.animal_id, d.grupo_id, d.categoria_id, d.descricao, d.valor, d.data_despesa, d.user_id,
                         a.nome AS animal_nome, g.nome AS grupo_nome, cd.nome AS categoria_nome
                     FROM despesas d
                     LEFT JOIN animais a ON d.animal_id = a.id
                     LEFT JOIN grupos_animais g ON d.grupo_id = g.id
                     LEFT JOIN categorias_despesas cd ON d.categoria_id = cd.id
                     WHERE d.id = :id";
            if ($userId !== null) $query .= " AND d.user_id = :user_id";
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

    public function create(?int $animalId, ?int $grupoId, int $categoriaId, string $descricao, float $valor, string $dataDespesa, int $userId): object|false
    {
        try {
            $query = "INSERT INTO despesas (animal_id, grupo_id, categoria_id, descricao, valor, data_despesa, user_id) 
                      VALUES (:animal_id, :grupo_id, :categoria_id, :descricao, :valor, :data_despesa, :user_id)";
            $stmt = Connect::getInstance()->prepare($query);
            if ($animalId === null) $stmt->bindValue(":animal_id", null, PDO::PARAM_NULL);
            else $stmt->bindParam(":animal_id", $animalId, PDO::PARAM_INT);
            if ($grupoId === null) $stmt->bindValue(":grupo_id", null, PDO::PARAM_NULL);
            else $stmt->bindParam(":grupo_id", $grupoId, PDO::PARAM_INT);
            $stmt->bindParam(":categoria_id", $categoriaId, PDO::PARAM_INT);
            $stmt->bindParam(":categoria_id", $categoriaId, PDO::PARAM_INT);
            $stmt->bindParam(":descricao", $descricao);
            $stmt->bindParam(":valor", $valor);
            $stmt->bindParam(":data_despesa", $dataDespesa);
            $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);

            if (!$stmt->execute()) {
                return false;
            }

            $id = Connect::getInstance()->lastInsertId();
            return $this->listById((int)$id, $userId);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update(int $id, ?int $animalId, ?int $grupoId, int $categoriaId, string $descricao, float $valor, string $dataDespesa): bool
    {
        try {
            $query = "UPDATE despesas SET animal_id = :animal_id, grupo_id = :grupo_id, categoria_id = :categoria_id, descricao = :descricao, valor = :valor, data_despesa = :data_despesa WHERE id = :id";
            $stmt = Connect::getInstance()->prepare($query);
            if ($animalId === null) $stmt->bindValue(":animal_id", null, PDO::PARAM_NULL);
            else $stmt->bindParam(":animal_id", $animalId, PDO::PARAM_INT);
            if ($grupoId === null) $stmt->bindValue(":grupo_id", null, PDO::PARAM_NULL);
            else $stmt->bindParam(":grupo_id", $grupoId, PDO::PARAM_INT);
            $stmt->bindParam(":categoria_id", $categoriaId, PDO::PARAM_INT);
            $stmt->bindParam(":descricao", $descricao);
            $stmt->bindParam(":valor", $valor);
            $stmt->bindParam(":data_despesa", $dataDespesa);
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
            $query = "DELETE FROM despesas WHERE id = :id";
            $stmt = Connect::getInstance()->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}
