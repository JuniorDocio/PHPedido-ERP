<?php

require_once 'models/cupom.php';

class CupomController
{
    private $model;

    public function __construct()
    {
        $this->model = new Cupom();
    }

    public function index()
    {
        $cupons = $this->model->buscarTodos();
        require 'views/cupom/lista.php';
    }

    public function criar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codigo = $_POST['codigo'] ?? '';
            $desconto = $_POST['desconto_percentual'];
            $valor_minimo = $_POST['valor_minimo'] ?? 0;
            $validade = !empty($_POST['validade']) ? $_POST['validade'] : null;
            $ativo = isset($_POST['ativo']) ? 1 : 0;

            if (!empty($_POST['id'])) {
                $this->model->atualizar($_POST['id'], $codigo, $desconto, $valor_minimo, $validade, $ativo);
            } else {
                $this->model->criar($codigo, $desconto, $valor_minimo, $validade, $ativo);
            }

            header('Location: index.php?controller=cupom&action=index');
            exit;
        }

        $cupom = null;
        require 'views/cupom/formulario.php';
    }

    public function editar()
    {
        if (isset($_GET['id'])) {
            $cupom = $this->model->buscarPorId($_GET['id']);
            require 'views/cupom/formulario.php';
        } else {
            header('Location: index.php?controller=cupom&action=index');
            exit;
        }
    }

    public function deletar()
    {
        if (isset($_GET['id'])) {
            $this->model->deletar($_GET['id']);
        }
        header('Location: index.php?controller=cupom&action=index');
        exit;
    }
}
