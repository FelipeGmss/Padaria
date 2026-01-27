<?php 

require_once '../models/models-produtos.php';

if (isset($_POST['btn-excluir']) && isset($_POST['id'])) {
    $id = $_POST['id'];
    
    $produtoModel = new Produtos();
    $produto = $produtoModel->buscar_produto_por_id($id);
    
    if ($produto) {
        if (!empty($produto['foto_produto']) && file_exists($produto['foto_produto'])) {
            unlink($produto['foto_produto']);
        }
        
        $resultado = $produtoModel->excluir_produto($id);
        
        if ($resultado > 0) {
            header('Location: ../views/editar.php?success=produto_excluido');
        } else {
            header('Location: ../views/editar.php?error=erro_ao_excluir');
        }
    } else {
        header('Location: ../views/editar.php?error=produto_nao_encontrado');
    }
    exit;
}

header('Location: ../views/editar.php');
exit;

?>
