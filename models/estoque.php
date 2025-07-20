<?php


class Estoque
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    public function criar($id_variacao, $quantidade)
    {
        $sql = "INSERT INTO estoque (id_variacao, quantidade) VALUES (:id_variacao, :quantidade)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_variacao', $id_variacao);
        $stmt->bindParam(':quantidade', $quantidade);
        return $stmt->execute();
    }

    public function atualizar($id_variacao, $quantidade)
    {
        $sql = "UPDATE estoque SET quantidade = :quantidade WHERE id_variacao = :id_variacao";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':quantidade', $quantidade);
        $stmt->bindParam(':id_variacao', $id_variacao);
        return $stmt->execute();
    }

    public function obterQuantidade($id_variacao)
    {
        $sql = "SELECT quantidade FROM estoque WHERE id_variacao = :id_variacao";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_variacao', $id_variacao);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (int)$result['quantidade'] : null;
    }

    public function reduzir($id_variacao, $quantidade)
    {
        $sql = "UPDATE estoque SET quantidade = quantidade - :quantidade WHERE id_variacao = :id_variacao AND quantidade >= :quantidade";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':quantidade', $quantidade);
        $stmt->bindParam(':id_variacao', $id_variacao);
        return $stmt->execute();
    }

    public function removerPorProduto($id_produto)
    {
        $sql = "DELETE FROM estoque WHERE id_variacao IN (
                    SELECT id_variacao FROM variacoes WHERE id_produto = :id_produto
                )";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_produto', $id_produto);
        return $stmt->execute();
    }

        public function buscarPorProduto($id_produto)
    {
        $sql = "SELECT e.*, v.nome as nome_variacao 
                FROM estoque e 
                INNER JOIN variacoes v ON e.id_variacao = v.id_variacao 
                WHERE v.id_produto = :id_produto";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id_produto', $id_produto, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}