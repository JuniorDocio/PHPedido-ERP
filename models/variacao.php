<?php

class Variacao
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    public function criar($idProduto, $nome)
    {
        $sql = "INSERT INTO variacoes (id_produto, nome) VALUES (:id_produto, :nome)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_produto', $idProduto);
        $stmt->bindParam(':nome', $nome);
        
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }

        return false;
    }

    public function buscarPorProduto($id_produto)
    {
        $sql = "SELECT * FROM variacoes WHERE id_produto = :id_produto";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_produto', $id_produto, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id_variacao)
    {
        $sql = "SELECT v.*, p.preco 
            FROM variacoes v
            JOIN produtos p ON v.id_produto = p.id_produto
            WHERE v.id_variacao = :id_variacao";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_variacao', $id_variacao, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar($id_variacao, $nome)
    {
        $sql = "UPDATE variacoes SET nome = :nome WHERE id_variacao = :id_variacao";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':id_variacao', $id_variacao);
        return $stmt->execute();
    }
}
