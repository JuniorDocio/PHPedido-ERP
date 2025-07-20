<?php


class Cupom
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    public function criar($codigo, $desconto_percentual, $valor_minimo, $validade = null, $ativo = 1)
    {
        $sql = "INSERT INTO cupons (codigo, desconto_percentual, valor_minimo, validade, ativo)
                VALUES (:codigo, :desconto_percentual, :valor_minimo, :validade, :ativo)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':codigo'=> $codigo,
            ':desconto_percentual'=> $desconto_percentual,
            ':valor_minimo'=> $valor_minimo,
            ':validade'=> $validade,
            ':ativo'=> $ativo
        ]);
    }

    public function atualizar($id, $codigo, $desconto_percentual, $valor_minimo, $validade = null, $ativo = 1)
    {
        $sql = "UPDATE cupons 
                SET codigo = :codigo, 
                    desconto_percentual = :desconto_percentual, 
                    valor_minimo = :valor_minimo, 
                    validade = :validade, 
                    ativo = :ativo 
                WHERE id_cupom = :id";
        
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':codigo', $codigo);
        $stmt->bindParam(':desconto_percentual', $desconto_percentual);
        $stmt->bindParam(':valor_minimo', $valor_minimo);
        $stmt->bindParam(':validade', $validade);
        $stmt->bindParam(':ativo', $ativo);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function buscarTodos()
    {
        $sql = "SELECT * FROM cupons";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT * FROM cupons WHERE id_cupom = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function buscarPorCodigo($codigo)
    {
        $sql = "SELECT * FROM cupons WHERE codigo = :codigo AND ativo = 1 AND (validade IS NULL OR validade >= CURDATE())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deletar($id)
    {
        $sql = "DELETE FROM cupons WHERE id_cupom = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
