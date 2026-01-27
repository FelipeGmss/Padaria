<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compre Seu Pão - Padaria</title>
    <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  
  <style>
    /* Pequeno ajuste visual extra */
    .card-hover:hover {
      transform: translateY(-6px);
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
  </style>
</head>
<body class="bg-gradient-to-br from-amber-50 to-orange-50 min-h-screen">

  <!-- Header -->
  <header class="bg-amber-800 text-white py-6 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-between">
      <h1 class="text-3xl font-bold flex items-center gap-3">
        <i class="fas fa-bread-slice text-amber-300"></i>
        Compre Seu Pão
      </h1>
      <p class="text-amber-200">A melhor padaria da cidade</p>
    </div>
  </header>

  <main class="max-w-7xl mx-auto px-6 py-12">

    <?php
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=padaria;charset=utf8mb4', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }

        $search = isset($_GET['busca']) ? trim($_GET['busca']) : '';

        if (!empty($search)) {
            $sql = "SELECT id, nome_produto, preco_produto, quantidade_produto, foto_produto
                    FROM produtos
                    WHERE nome_produto LIKE :search 
                    ORDER BY nome_produto ASC";
            $query = $pdo->prepare($sql);
            $query->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        } else {
            $sql = "SELECT id, nome_produto, preco_produto, quantidade_produto, foto_produto
                    FROM produtos
                    ORDER BY nome_produto ASC";
            $query = $pdo->prepare($sql);
        }

        try {
            $query->execute();
            $produtos = $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro na consulta: " . $e->getMessage();
            $produtos = [];
        }
    ?>

    <!-- Barra de pesquisa -->
    <div class="mb-12">
      <form action="" method="GET" class="max-w-3xl mx-auto">
        <div class="relative">
          <input 
            type="search"
            name="busca"
            placeholder="Pesquisar pão, bolo, salgados..."
            class="w-full pl-14 pr-6 py-5 rounded-2xl bg-white border-2 border-amber-200 focus:border-amber-500 focus:outline-none shadow-lg text-lg transition"
            value="<?php echo isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : ''; ?>"
          >
          <button type="submit" class="absolute left-5 top-1/2 -translate-y-1/2 text-amber-600 hover:text-amber-800">
            <i class="fas fa-search text-2xl"></i>
          </button>
        </div>
      </form>
    </div>

    <!-- Grid de produtos - 3 colunas em desktop, responsivo -->
    <!-- Grid de produtos - Cards mais quadrados e menores -->
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">

    <?php if (!empty($produtos)): ?>

        <?php foreach ($produtos as $produto): ?>

            <div class="bg-white rounded-3xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 group flex flex-col">

                <!-- Imagem do produto - quadrada e grande -->
                <!-- Imagem do produto - quadrada e ajustada -->
                <div class="relative w-full aspect-square bg-gradient-to-br from-amber-50 to-orange-50 overflow-hidden">
                    <?php if (!empty($produto['foto_produto'])): ?>
                        <img 
                            src="<?= htmlspecialchars($produto['foto_produto']) ?>" 
                            alt="<?= htmlspecialchars($produto['nome_produto']) ?>"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                            onerror="this.src='https://via.placeholder.com/600x600?text=Sem+Imagem'; this.classList.add('object-contain', 'p-10');"
                        >
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-amber-300">
                            <i class="fas fa-bread-slice text-8xl opacity-40"></i>
                        </div>
                    <?php endif; ?>

                    <!-- Badge no canto -->
                    <div class="absolute top-3 right-3">
                        <?php if ($produto['quantidade_produto'] > 0): ?>
                            <span class="bg-green-500 text-white text-sm font-bold px-4 py-2 rounded-full shadow-xl backdrop-blur-sm">
                                ✓ Disponível
                            </span>
                        <?php else: ?>
                            <span class="bg-red-500 text-white text-sm font-bold px-4 py-2 rounded-full shadow-xl backdrop-blur-sm">
                                Esgotado
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Conteúdo do card -->
                <div class="p-4 flex flex-col flex-grow">
                    
                    <!-- Nome do produto -->
                    <h3 class="text-xl font-bold text-gray-800 mb-2 min-h-[3rem] line-clamp-2 leading-tight">
                        <?= htmlspecialchars($produto['nome_produto']) ?>
                    </h3>

                    <!-- Preço -->
                    <div class="mb-2">
                        <p class="text-3xl font-extrabold text-amber-600">
                            R$ <?= number_format($produto['preco_produto'], 2, ',', '.') ?>
                        </p>
                    </div>

                    <!-- Estoque -->
                    <div class="mb-3 pb-3 border-b border-gray-200">
                        <div class="flex items-center gap-1.5 text-sm">
                            <i class="fas fa-cubes text-amber-600"></i>
                            <span class="text-gray-600">Estoque:</span>
                            <strong class="<?= $produto['quantidade_produto'] <= 5 ? 'text-red-600' : 'text-green-600' ?>">
                                <?= htmlspecialchars($produto['quantidade_produto']) ?> un.
                            </strong>
                        </div>
                        
                        <?php if ($produto['quantidade_produto'] > 0 && $produto['quantidade_produto'] <= 5): ?>
                            <div class="mt-2 text-sm text-yellow-700 bg-yellow-50 px-3 py-2 rounded-lg">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                Últimas unidades!
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Botão -->
                    <div class="mt-auto flex gap-3 pt-4">
                        <!-- Botão Adicionar (Menor / Secundário) -->
                        <form action="Controller-listar.php" method="POST" class="flex-1">
                            <input type="hidden" name="id_produto" value="<?= $produto['id'] ?>">
                            <input type="hidden" name="nome_produto" value="<?= htmlspecialchars($produto['nome_produto']) ?>">
                            <input type="hidden" name="preco_produto" value="<?= $produto['preco_produto'] ?>">
                            <input type="hidden" name="foto_produto" value="<?= htmlspecialchars($produto['foto_produto']) ?>">

                            <button 
                                type="submit" 
                                name="comprar"
                                class="w-full bg-amber-100 hover:bg-amber-200 text-amber-900/80 font-bold text-sm py-3 rounded-xl transition-colors
                                    flex items-center justify-center gap-2 shadow-sm border border-amber-200
                                    disabled:opacity-50 disabled:cursor-not-allowed h-full"
                                <?= $produto['quantidade_produto'] <= 0 ? 'disabled' : '' ?>
                            >
                                <i class="fas <?= $produto['quantidade_produto'] <= 0 ? 'fa-ban' : 'fa-cart-plus' ?>"></i>
                                Add
                            </button>
                        </form>

                        <!-- Botão Comprar (Principal) -->
                        <button 
                            onclick='openBuyModal(<?= json_encode($produto) ?>)'
                            class="flex-[1.5] bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 
                                text-white font-bold text-base py-3 rounded-xl transition-all shadow-md hover:shadow-xl transform hover:-translate-y-1
                                flex items-center justify-center gap-2
                                disabled:from-gray-300 disabled:to-gray-400 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-none"
                            <?= $produto['quantidade_produto'] <= 0 ? 'disabled' : '' ?>
                        >
                            <i class="fas fa-shopping-bag"></i> 
                            Comprar
                        </button>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>

    <?php else: ?>
        <div class="col-span-full text-center py-20">
            <i class="fas fa-search text-9xl text-amber-300 mb-6 opacity-50"></i>
            <p class="text-3xl text-gray-700 font-bold mb-3">
                Nenhum produto encontrado
            </p>
            <p class="text-lg text-gray-500">Tente pesquisar com outro termo</p>
        </div>
    <?php endif; ?>

</div>

  </main>

  <footer class="bg-amber-900 text-amber-200 py-6 mt-12">
    <div class="max-w-7xl mx-auto px-4 text-center">
      <p>© 2026 Compre Seu Pão - Feito com carinho e farinha de trigo</p>
    </div>
  </footer>

  <!-- Modal de Compra -->
  <div id="buyModal" class="fixed inset-0 bg-black/60 hidden z-50 flex items-center justify-center p-4 backdrop-blur-sm transition-opacity duration-300">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden transform transition-all scale-100 animate-fade-in-up">
        
        <!-- Header Modal -->
        <div class="bg-amber-600 px-6 py-4 flex justify-between items-center text-white">
            <h3 class="text-xl font-bold flex items-center gap-2">
                <i class="fas fa-receipt"></i> Finalizar Pedido
            </h3>
            <button onclick="closeBuyModal()" class="text-amber-200 hover:text-white transition-colors bg-white/10 hover:bg-white/20 rounded-full w-8 h-8 flex items-center justify-center">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Formulario -->
        <!-- Action aponta para um controller futuro -->
        <form action="../controllers/Controller-comprar.php" method="POST" class="p-6">
            <input type="hidden" name="id_produto" id="modal_id_produto">
            <input type="hidden" name="preco_unitario" id="modal_preco_produto">
            
            <!-- Resumo do Item -->
            <div class="flex gap-4 mb-6 bg-amber-50 p-4 rounded-xl border border-amber-100 items-center">
                <img id="modal_img" src="" class="w-16 h-16 object-cover rounded-lg bg-white shadow-sm border border-amber-200">
                <div>
                    <h4 id="modal_nome_produto" class="font-bold text-gray-800 text-lg leading-tight">Nome do Produto</h4>
                    <p class="text-amber-700 font-bold text-lg mt-1">R$ <span id="modal_display_preco">0,00</span></p>
                </div>
            </div>

            <!-- Campos do Usuário -->
            <div class="space-y-4">
                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Qtd</label>
                        <input type="number" id="modal_quantidade" name="quantidade" value="1" min="1" max="50" required 
                            class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-amber-500 focus:outline-none transition font-bold text-center text-gray-700">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Seu Nome</label>
                        <input type="text" name="nome_cliente" required placeholder="João Silva"
                            class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-amber-500 focus:outline-none transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Endereço de Entrega</label>
                    <input name="endereco_cliente" required placeholder="Rua das Flores, 123 - Centro"
                            class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-amber-500 focus:outline-none transition resize-none">
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="mt-8 flex gap-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeBuyModal()" class="flex-1 px-4 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition">
                    Cancelar
                </button>
                <button type="submit" name="btn-finalizar" class="flex-[2] px-4 py-3 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 shadow-lg hover:shadow-green-500/30 transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                    <i class="fas fa-check"></i> Confirmar Compra
                </button>
            </div>
        </form>
    </div>
  </div>

  <script>
    function openBuyModal(produto) {
        // Preencher dados hidden e visuais
        document.getElementById('modal_id_produto').value = produto.id;
        document.getElementById('modal_preco_produto').value = produto.preco_produto;
        document.getElementById('modal_nome_produto').innerText = produto.nome_produto;
        
        // Formatar preço
        const preco = parseFloat(produto.preco_produto);
        document.getElementById('modal_display_preco').innerText = preco.toLocaleString('pt-BR', {minimumFractionDigits: 2});
        
        // Imagem
        const img = document.getElementById('modal_img');
        if(produto.foto_produto) {
            img.src = produto.foto_produto;
        } else {
            img.src = 'https://via.placeholder.com/150?text=Sem+Foto';
        }

        // Mostrar Modal
        const modal = document.getElementById('buyModal');
        modal.classList.remove('hidden');

        // Atualizar preço inicial
        atualizarPrecoTotal();
    }

    // Função para atualizar preço dinâmico
    function atualizarPrecoTotal() {
        const qtd = document.getElementById('modal_quantidade').value;
        const precoUnitario = parseFloat(document.getElementById('modal_preco_produto').value);
        
        if(qtd && precoUnitario) {
            const total = qtd * precoUnitario;
            document.getElementById('modal_display_preco').innerText = total.toLocaleString('pt-BR', {minimumFractionDigits: 2});
        }
    }

    // Listener de mudança na quantidade
    document.getElementById('modal_quantidade').addEventListener('input', atualizarPrecoTotal);

    function closeBuyModal() {
        document.getElementById('buyModal').classList.add('hidden');
    }

    // Fechar ao clicar fora
    document.getElementById('buyModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeBuyModal();
        }
    });
  </script>

</body>
</html>