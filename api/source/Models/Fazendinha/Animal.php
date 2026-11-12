<?php

namespace Source\Models\Fazendinha;

use Source\Core\Connect;
use PDO;
use PDOException;

class Animal
{
    private ?int $id;
    private ?string $nome;
    private ?int $racaId;
    private ?string $sexo;
    private ?string $dataNascimento;
    private ?float $peso;
    private ?int $userId;

    public function __construct(?int $id = null, ?string $nome = null, ?int $racaId = null, ?string $sexo = null, ?string $dataNascimento = null, ?float $peso = null, ?int $userId = null)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->racaId = $racaId;
        $this->sexo = $sexo;
        $this->dataNascimento = $dataNascimento;
        $this->peso = $peso;
        $this->userId = $userId;
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

    public function getRacaId(): ?int
    {
        return $this->racaId;
    }

    public function setRacaId(int $racaId): void
    {
        $this->racaId = $racaId;
    }

    public function getSexo(): ?string
    {
        return $this->sexo;
    }

    public function setSexo(string $sexo): void
    {
        $this->sexo = $sexo;
    }

    public function getDataNascimento(): ?string
    {
        return $this->dataNascimento;
    }

    public function setDataNascimento(string $dataNascimento): void
    {
        $this->dataNascimento = $dataNascimento;
    }

    public function getPeso(): ?float
    {
        return $this->peso;
    }

    public function setPeso(float $peso): void
    {
        $this->peso = $peso;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function listAll(?int $userId = null): array
    {
        try {
            if ($userId === null) return [];
            $query = "SELECT a.id, a.nome, a.raca_id, a.sexo, a.data_nascimento, a.peso, a.user_id, r.nome AS raca_nome, e.nome AS especie_nome 
                      FROM animais a
                      LEFT JOIN racas r ON a.raca_id = r.id
                      LEFT JOIN especies e ON r.especie_id = e.id
                      WHERE a.user_id = :user_id";
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
            $query = "SELECT a.id, a.nome, a.raca_id, a.sexo, a.data_nascimento, a.peso, a.user_id, r.nome AS raca_nome, e.nome AS especie_nome 
                      FROM animais a
                      LEFT JOIN racas r ON a.raca_id = r.id
                      LEFT JOIN especies e ON r.especie_id = e.id
                      WHERE a.id = :id";
            if ($userId !== null) $query .= " AND a.user_id = :user_id";
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

    public function create(string $nome, int $racaId, string $sexo, string $dataNascimento, float $peso, int $userId): object|false
    {
        try {
            $query = "INSERT INTO animais (nome, raca_id, sexo, data_nascimento, peso, user_id) 
                      VALUES (:nome, :raca_id, :sexo, :data_nascimento, :peso, :user_id)";
            $stmt = Connect::getInstance()->prepare($query);
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":raca_id", $racaId, PDO::PARAM_INT);
            $stmt->bindParam(":sexo", $sexo);
            $stmt->bindParam(":data_nascimento", $dataNascimento);
            $stmt->bindParam(":peso", $peso);
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

    public function update(int $id, string $nome, int $racaId, string $sexo, string $dataNacimiento, float $peso): bool
    {
        try {
            $query = "UPDATE animais SET nome = :nome, raca_id = :raca_id, sexo = :sexo, data_nascimento = :data_nascimento, peso = :peso WHERE id = :id";
            $stmt = Connect::getInstance()->prepare($query);
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":raca_id", $racaId, PDO::PARAM_INT);
            $stmt->bindParam(":sexo", $sexo);
            $stmt->bindParam(":data_nascimento", $dataNascimento);
            $stmt->bindParam(":peso", $peso);
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
            $query = "DELETE FROM animais WHERE id = :id";
            $stmt = Connect::getInstance()->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}
