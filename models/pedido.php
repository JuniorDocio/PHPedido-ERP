<?php


class Pedido
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    public function criar($status, $total_pedido, $frete = 0.00, $desconto = 0.00, $itens = [])
{
    try {
        $this->conn->beginTransaction();

        $sql = "INSERT INTO pedidos (status, total_pedido, frete, desconto) 
        VALUES (:status, :total_pedido, :frete, :desconto)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':total_pedido', $total_pedido);
        $stmt->bindParam(':frete', $frete);
        $stmt->bindParam(':desconto', $desconto);
        $stmt->execute();

        $id_pedido = $this->conn->lastInsertId();

        $sqlItem = "INSERT INTO pedido_itens (id_pedido, id_produto, quantidade, preco_unitario, id_variacao)
                    VALUES (:id_pedido, :id_produto, :quantidade, :preco_unitario, :id_variacao)";
        $stmtItem = $this->conn->prepare($sqlItem);

        foreach ($itens as $item) {
            $stmtItem->execute([
                ':id_pedido' => $id_pedido,
                ':id_produto' => $item['id_produto'],
                ':quantidade' => $item['quantidade'],
                ':preco_unitario' => $item['preco_unitario'],
                ':id_variacao' => $item['id_variacao'] ?? null,
            ]);
        }

        $this->conn->commit();
        return $id_pedido;
    } catch (Exception $e) {
        $this->conn->rollBack();
        throw $e;
    }
}

    public function buscarTodos()
    {
        $sql = "SELECT * FROM pedidos ORDER BY data_pedido DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id_pedido)
    {
        $sqlPedido = "SELECT * FROM pedidos WHERE id_pedido = :id_pedido";
        $stmtPedido = $this->conn->prepare($sqlPedido);
        $stmtPedido->bindParam(':id_pedido', $id_pedido);
        $stmtPedido->execute();
        $pedido = $stmtPedido->fetch(PDO::FETCH_ASSOC);

        if (!$pedido) {
            return null;
        }

        $sqlItens = "
            SELECT ip.*, p.nome as nome_produto, v.nome as nome_variacao
            FROM pedido_itens ip
            INNER JOIN produtos p ON ip.id_produto = p.id_produto
            LEFT JOIN variacoes v ON ip.id_variacao = v.id_variacao
            WHERE ip.id_pedido = :id_pedido
        ";
        $stmtItens = $this->conn->prepare($sqlItens);
        $stmtItens->bindParam(':id_pedido', $id_pedido);
        $stmtItens->execute();
        $itens = $stmtItens->fetchAll(PDO::FETCH_ASSOC);

        $pedido['itens'] = $itens;

        return $pedido;
    }

    public function deletar($id_pedido)
    {
        try {
            $this->conn->beginTransaction();

            $sqlItens = "DELETE FROM pedido_itens WHERE id_pedido = :id_pedido";
            $stmtItens = $this->conn->prepare($sqlItens);
            $stmtItens->bindParam(':id_pedido', $id_pedido);
            $stmtItens->execute();

            $sqlPedido = "DELETE FROM pedidos WHERE id_pedido = :id_pedido";
            $stmtPedido = $this->conn->prepare($sqlPedido);
            $stmtPedido->bindParam(':id_pedido', $id_pedido);
            $stmtPedido->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }
}
?>
