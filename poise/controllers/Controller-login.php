<?php 

require_once "../models/models-produtos.php";

    if (isset($_POST['btn-login'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $cliente = new Clientes();
    $resultado = $cliente->login_admin($email, $senha);
    
    header("Location: ../views/editar.php?login=success");  
    } else {
        header("Location: ../views/LoginAdmin.php");
        exit();
    }
?>