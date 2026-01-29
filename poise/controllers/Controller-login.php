<?php 

require_once "../models/models-produtos.php";

if (isset($_POST['btn-login'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $cliente = new Clientes();
    $resultado = $cliente->login_admin($email, $senha);
    
    if ($resultado) {
        header("Location: ../views/editar.php");
        exit();
    } else {
        header("Location: ../views/loginAdmin.php?erro=1");
        exit();
    }
}
?>