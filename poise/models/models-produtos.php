<?php 


Class Produtos {
    public function Cadastrar_produto($foto_produto, $nome_produto, $preco_produto, $quantidade_produto) {
        $pdo = new PDO("mysql:host=localhost;dbname=padaria", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $consulta = "INSERT INTO produtos (foto_produto, nome_produto, preco_produto, quantidade_produto) VALUES (:foto_produto, :nome_produto, :preco_produto, :quantidade_produto)";
        $query = $pdo->prepare($consulta);
        $query->bindValue(":foto_produto", $foto_produto);
        $query->bindValue(":nome_produto", $nome_produto);
        $query->bindValue(":preco_produto", $preco_produto);
        $query->bindValue(":quantidade_produto", $quantidade_produto);
        $query->execute();
    }

     public function Listar_produtos($nome_produto) {
        $pdo = new PDO("mysql:host=localhost;dbname=padaria","root","");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $consulta = 'SELECT * FROM produtos WHERE nome_produto = :nome_produto';
        $query = $pdo->prepare($consulta);
        $query->bindValue(":nome_produto", $nome_produto);
        $query->execute();

    }

     public function buscar_produto_por_id($id){
        $pdo = new PDO("mysql:host=localhost;dbname=padaria","root","");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $consulta = "SELECT * FROM produtos WHERE id = :id";
        $query = $pdo->prepare($consulta);
        $query->bindValue(":id", $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

     public function editar_produto($id, $foto_produto, $nome_produto, $preco_produto, $quantidade_produto){
        $pdo = new PDO("mysql:host=localhost;dbname=padaria","root","");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $consulta = "UPDATE produtos SET foto_produto = :foto_produto, nome_produto = :nome_produto, preco_produto = :preco_produto, quantidade_produto = :quantidade_produto WHERE id = :id;";
        $query = $pdo->prepare($consulta);
        $query->bindValue(":id", $id);
        $query->bindValue(":foto_produto", $foto_produto);
        $query->bindValue(":nome_produto", $nome_produto);
        $query->bindValue(":preco_produto", $preco_produto);
        $query->bindValue(":quantidade_produto", $quantidade_produto);
        $query->execute();
        return $query->rowCount();
    }

     public function excluir_produto($id){
        $pdo = new PDO("mysql:host=localhost;dbname=padaria","root","");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $consulta = "DELETE FROM produtos WHERE id = :id";
        $query = $pdo->prepare($consulta);
        $query->bindValue(":id", $id);
        $query->execute();
        return $query->rowCount();
    }


    // Compra

    public function comprar($id, $quantidade_compra){
        $pdo = new PDO("mysql:host=localhost;dbname=padaria","root","");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $consulta = "UPDATE produtos SET quantidade_produto = quantidade_produto - :quantidade_compra WHERE id = :id;";
        $query = $pdo->prepare($consulta);
        $query->bindValue(":id", $id);
        $query->bindValue(":quantidade_compra", $quantidade_compra);
        $query->execute();
        return $query->rowCount();
    }

    public function cliente_comprar($nome_cliente, $endereco_cliente, $quantidade_compra, $venda_preco){
        $pdo = new PDO("mysql:host=localhost;dbname=padaria","root","");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $consulta = "INSERT INTO clientes (nome_cliente, endereco_cliente, quantidade_compra, venda_preco) VALUES (:nome_cliente, :endereco_cliente, :quantidade_compra, :venda_preco);";
        $query = $pdo->prepare($consulta);
        $query->bindValue(":nome_cliente", $nome_cliente);
        $query->bindValue(":endereco_cliente", $endereco_cliente);
        $query->bindValue(":quantidade_compra", $quantidade_compra);
        $query->bindValue(":venda_preco", $venda_preco);
        $query->execute();
        return $query->rowCount();
    }

}
?>