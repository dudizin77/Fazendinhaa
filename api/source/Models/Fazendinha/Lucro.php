<?php

namespace Source\Models\Fazendinha;

use Source\Core\Connect;
use PDO;
use PDOException;

class Lucro
{
    private ?int $id;
    private ?int $animalId;
    private ?int $categoriaId;
    private ?string $descricao;
    private ?float $valor;
    private ?string $dataLucro;

    public function __construct(?int $id = null, ?int $animalId = null, ?int $categoriaId = null, ?string $descricao = null, ?float $valor = null, ?string $dataLucro = null)
    {
        $this->id = $id;
        $this->animalId = $animalId;
        $this->categoriaId = $categoriaId;
        $this->descricao = $descricao;
        $this->valor = $valor;
        $this->dataLucro = $dataLucro;
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

    public function getDataLucro(): ?string
    {
        return $this->dataLucro;
    }

    public function setDataLucro(string $dataLucro): void
    {
        $this->dataLucro = $dataLucro;
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
            $query = "SELECT l.id, l.animal_id, l.grupo_id, l.categoria_id, l.descricao, l.valor, l.data_lucro, 
                             a.nome AS animal_nome, cl.nome AS categoria_nome, g.nome AS grupo_nome
                      FROM lucros l
                      LEFT JOIN animais a ON l.animal_id = a.id
                      LEFT JOIN grupos_animais g ON l.grupo_id = g.id
                      LEFT JOIN categorias_lucros cl ON l.categoria_id = cl.id
                      WHERE l.user_id = :user_id";
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
            $query = "SELECT l.id, l.animal_id, l.grupo_id, l.categoria_id, l.descricao, l.valor, l.data_lucro, l.user_id,
                         a.nome AS animal_nome, g.nome AS grupo_nome, cl.nome AS categoria_nome
                     FROM lucros l
                     LEFT JOIN animais a ON l.animal_id = a.id
                     LEFT JOIN grupos_animais g ON l.grupo_id = g.id
                     LEFT JOIN categorias_lucros cl ON l.categoria_id = cl.id
                     WHERE l.id = :id";
            if ($userId !== null) $query .= " AND l.user_id = :user_id";
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

    public function create(?int $animalId, ?int $grupoId, int $categoriaId, string $descricao, float $valor, string $dataLucro, int $userId): object|false
    {
        try {
            $query = "INSERT INTO lucros (animal_id, grupo_id, categoria_id, descricao, valor, data_lucro, user_id) 
                      VALUES (:animal_id, :grupo_id, :categoria_id, :descricao, :valor, :data_lucro, :user_id)";
            $stmt = Connect::getInstance()->prepare($query);
            if ($animalId === null) $stmt->bindValue(":animal_id", null, PDO::PARAM_NULL);
            else $stmt->bindParam(":animal_id", $animalId, PDO::PARAM_INT);
            if ($grupoId === null) $stmt->bindValue(":grupo_id", null, PDO::PARAM_NULL);
            else $stmt->bindParam(":grupo_id", $grupoId, PDO::PARAM_INT);
            $stmt->bindParam(":categoria_id", $categoriaId, PDO::PARAM_INT);
            $stmt->bindParam(":descricao", $descricao);
            $stmt->bindParam(":valor", $valor);
            $stmt->bindParam(":data_lucro", $dataLucro);
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

    public function update(int $id, ?int $animalId, ?int $grupoId, int $categoriaId, string $descricao, float $valor, string $dataLucro): bool
    {
        try {
            $query = "UPDATE lucros SET animal_id = :animal_id, grupo_id = :grupo_id, categoria_id = :categoria_id, descricao = :descricao, valor = :valor, data_lucro = :data_lucro WHERE id = :id";
            $stmt = Connect::getInstance()->prepare($query);
            if ($animalId === null) $stmt->bindValue(":animal_id", null, PDO::PARAM_NULL);
            else $stmt->bindParam(":animal_id", $animalId, PDO::PARAM_INT);
            if ($grupoId === null) $stmt->bindValue(":grupo_id", null, PDO::PARAM_NULL);
            else $stmt->bindParam(":grupo_id", $grupoId, PDO::PARAM_INT);
            $stmt->bindParam(":categoria_id", $categoriaId, PDO::PARAM_INT);
            $stmt->bindParam(":descricao", $descricao);
            $stmt->bindParam(":valor", $valor);
            $stmt->bindParam(":data_lucro", $dataLucro);
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
            $query = "DELETE FROM lucros WHERE id = :id";
            $stmt = Connect::getInstance()->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}
