<?php



class Produto
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    public function criar($nome, $preco, $descricao = null)
    {
        $sql = "INSERT INTO produtos (nome, preco, descricao) VALUES (:nome, :preco, :descricao)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':preco', $preco);
        $stmt->bindParam(':descricao', $descricao);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId(); 
        } else {
            return false;
        }
    }


    public function atualizar($id, $nome, $preco, $descricao = null)
    {
        $sql = "UPDATE produtos SET nome = :nome, preco = :preco, descricao = :descricao WHERE id_produto = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':preco', $preco);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function buscarTodos()
    {
        $sql = "SELECT * FROM produtos";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT * FROM produtos WHERE id_produto = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deletar($id)
    {
        $sql = "DELETE FROM produtos WHERE id_produto = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}

?>
