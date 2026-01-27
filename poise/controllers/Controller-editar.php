<?php 

require_once '../models/models-produtos.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $produtoModel = new Produtos();
    $dados_produto = $produtoModel->buscar_produto_por_id($id);
    
    if ($dados_produto) {
        include '../views/telaEditar.php';
    } else {
        header('Location: ../views/editar.php?error=produto_nao_encontrado');
        exit;
    }
}

if (isset($_POST['btn-editar'])) {
    $id = $_POST["id"];
    $nome_produto = $_POST["nome_produto"];
    $preco_produto = $_POST["preco_produto"];
    $quantidade_produto = $_POST["quantidade_produto"];
    
    $produtoModel = new Produtos();
    $produto_atual = $produtoModel->buscar_produto_por_id($id);
    $foto_produto = $produto_atual['foto_produto'];
    
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
                if(!empty($foto_produto) && file_exists($foto_produto)) {
                    unlink($foto_produto);
                }
                $foto_produto = '../imgs/' . $nome_arquivo;
            }
        }
    }

    $resultado = $produtoModel->editar_produto($id, $foto_produto, $nome_produto, $preco_produto, $quantidade_produto);
    
    if ($resultado > 0) {
        header('Location: ../views/editar.php?success=produto_atualizado');
    } else {
        header('Location: ../views/editar.php?error=erro_ao_atualizar');
    }
    exit;
}

?>