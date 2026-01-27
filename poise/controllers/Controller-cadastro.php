<?php 
require "../models/models-produtos.php";

if(isset($_POST["btn-cadastrar"])) {
    $nome_produto = $_POST["nome_produto"];
    $preco_produto = $_POST["preco_produto"];
    $quantidade_produto = $_POST["quantidade_produto"];
    
    $foto_produto = '';
    
    if(isset($_FILES['foto_produto']) && $_FILES['foto_produto']['error'] == 0) {
        $upload_dir = '../imgs/';
        
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $extensao = strtolower(pathinfo($_FILES['foto_produto']['name'], PATHINFO_EXTENSION));
        $extensoes_permitidas = array('jpg', 'jpeg', 'png', 'gif', 'webp');
        
        if(in_array($extensao, $extensoes_permitidas)) {
            $nome_arquivo = uniqid() . '.' . $extensao;
            $caminho_completo = $upload_dir . $nome_arquivo;
            
            if(move_uploaded_file($_FILES['foto_produto']['tmp_name'], $caminho_completo)) {
                $foto_produto = '../imgs/' . $nome_arquivo;
            }
        }
    }

    $x = new Produtos();
    $x->Cadastrar_produto($foto_produto, $nome_produto, $preco_produto, $quantidade_produto);
    
    header('Location: ../views/cadastrar.php?success=1');
    exit;
}

?>