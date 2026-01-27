<?php 
require_once('../models/models-produtos.php');

if (isset($_POST['btn-finalizar'])) {
    $id_produto = $_POST['id_produto']; // Corrigido para o name correto do form
    $quantidade_compra = $_POST['quantidade'];

    $nome_cliente = $_POST['nome_cliente'];
    $endereco_cliente = $_POST['endereco_cliente'];

    // Usando a classe Produtos corretamente
    $produto = new Produtos();
    
    // Passando os dois argumentos necessários (id e quantidade)
    $produto->comprar($id_produto, $quantidade_compra);

    // Pegando o preço unitário (enviado pelo hidden input no modal)
    $preco_unitario = $_POST['preco_unitario'];
    
    // Calculando o valor total da venda
    $venda_preco = $preco_unitario * $quantidade_compra;

    // Chamando o método cliente_comprar do objeto produtos (já que foi lá que foi criado)
    $produto->cliente_comprar($nome_cliente, $endereco_cliente, $quantidade_compra, $venda_preco);

    // Redireciona com sucesso
    header('Location: ../views/listar.php?success=compra_realizada');
    exit;
} else {
    header('Location: ../views/listar.php');
    exit;
}
?>