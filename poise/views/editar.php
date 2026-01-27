<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Produtos - Padaria</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              'padaria-primary':   '#ca0101',
              'padaria-accent':    '#c48d04',
              'padaria-bg':        '#FDFBF7',
            }
          }
        }
      }
    </script>
</head>
<body class="bg-gradient-to-br from-amber-50 to-orange-50 min-h-screen">

  <!-- Header -->
  <header class="bg-amber-800 text-white py-6 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-between">
      <h1 class="text-3xl font-bold flex items-center gap-3">
        <i class="fas fa-tools text-amber-300"></i>
        Gerenciar Produtos
      </h1>
      <div class="flex gap-3">
        <button onclick="openContabilidade()" class="bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-700 transition font-semibold shadow-md flex items-center gap-2">
            <i class="fas fa-chart-line"></i> Contabilidade
        </button>
        <a href="cadastrar.php" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition font-semibold shadow-md flex items-center gap-2">
            <i class="fas fa-plus-circle"></i> Novo Produto
        </a>
        <a href="listar.php" class="bg-white text-amber-800 px-4 py-2 rounded-lg hover:bg-amber-100 transition font-semibold shadow-sm">
            <i class="fas fa-store"></i> Ver Loja
        </a>
      </div>
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

        // Queries de Contabilidade
        try {
            // Total Estoque
            $stmtEstoque = $pdo->query("SELECT SUM(quantidade_produto) as total_estoque FROM produtos");
            $totalEstoque = $stmtEstoque->fetch(PDO::FETCH_ASSOC)['total_estoque'] ?? 0;

            // Valor Investido (Preço custo * Qtd Estoque) -> Nota: Estamos usando preco_produto como base de calculo de "patrimonio" publico
            // Se tivesse preço de custo, seria outra coluna.
            $stmtInvestido = $pdo->query("SELECT SUM(preco_produto * quantidade_produto) as total_investido FROM produtos");
            $totalInvestido = $stmtInvestido->fetch(PDO::FETCH_ASSOC)['total_investido'] ?? 0;

            // Vendas Totais (Qtd)
            $stmtVendasQtd = $pdo->query("SELECT SUM(quantidade_compra) as total_vendidos FROM clientes");
            $totalVendidos = $stmtVendasQtd->fetch(PDO::FETCH_ASSOC)['total_vendidos'] ?? 0;

            // Dinheiro Recebido (Venda Preco)
            $stmtRecebido = $pdo->query("SELECT SUM(venda_preco) as total_recebido FROM clientes");
            $totalRecebido = $stmtRecebido->fetch(PDO::FETCH_ASSOC)['total_recebido'] ?? 0;

        } catch (PDOException $e) {
            // Silencioso ou log
            $totalEstoque = 0;
            $totalInvestido = 0;
            $totalVendidos = 0;
            $totalRecebido = 0;
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
            placeholder="Pesquisar produto para editar..."
            class="w-full pl-14 pr-6 py-5 rounded-2xl bg-white border-2 border-amber-200 focus:border-amber-500 focus:outline-none shadow-lg text-lg transition"
            value="<?php echo isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : ''; ?>"
          >
          <button type="submit" class="absolute left-5 top-1/2 -translate-y-1/2 text-amber-600 hover:text-amber-800">
            <i class="fas fa-search text-2xl"></i>
          </button>
        </div>
      </form>
    </div>

    <!-- Grid de produtos - Cards Menores -->
    <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-5 gap-4">

    <?php if (!empty($produtos)): ?>

        <?php foreach ($produtos as $produto): ?>

            <div class="bg-white rounded-3xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 group flex flex-col">

                <!-- Imagem do produto -->
                <div class="relative w-full aspect-square bg-gradient-to-br from-amber-50 to-orange-50 overflow-hidden">
                    <?php if (!empty($produto['foto_produto'])): ?>
                        <img 
                            src="<?= htmlspecialchars($produto['foto_produto']) ?>" 
                            alt="<?= htmlspecialchars($produto['nome_produto']) ?>"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                            onerror="this.src='https://via.placeholder.com/600x600?text=Sem+Imagem'; this.classList.add('object-contain', 'p-10');"
                        >
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-amber-300">
                            <i class="fas fa-bread-slice text-8xl opacity-40"></i>
                        </div>
                    <?php endif; ?>

                    <!-- Badge -->
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

                <!-- Conteúdo -->
                <div class="p-6 flex flex-col flex-grow">
                    
                    <h3 class="text-2xl font-bold text-gray-800 mb-3 min-h-[3.5rem] line-clamp-2">
                        <?= htmlspecialchars($produto['nome_produto']) ?>
                    </h3>

                    <div class="mb-4">
                        <p class="text-4xl font-extrabold text-amber-600">
                            R$ <?= number_format($produto['preco_produto'], 2, ',', '.') ?>
                        </p>
                    </div>

                    <div class="mb-4 pb-4 border-b border-gray-200">
                        <div class="flex items-center gap-2 text-base">
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

                    <!-- Botões de ação -->
                    <div class="mt-auto space-y-3">
                        <!-- Botão Editar -->
                        <a href="../controllers/Controller-editar.php?id=<?= $produto['id'] ?>" class="block w-full">
                            <button 
                                type="button"
                                class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 
                                       text-white font-bold text-lg py-4 rounded-xl transition-all duration-300 
                                       flex items-center justify-center gap-2 shadow-md hover:shadow-xl transform hover:scale-105"
                            >
                                <i class="fas fa-edit text-lg"></i>
                                Editar
                            </button>
                        </a>

                        <!-- Botão Excluir -->
                        <form action="../controllers/Controller-excluir.php" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
                            <input type="hidden" name="id" value="<?= $produto['id'] ?>">
                            <button 
                                type="submit"
                                name="btn-excluir"
                                class="w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 
                                       text-white font-bold text-lg py-4 rounded-xl transition-all duration-300 
                                       flex items-center justify-center gap-2 shadow-md hover:shadow-xl transform hover:scale-105"
                            >
                                <i class="fas fa-trash text-lg"></i>
                                Excluir
                            </button>
                        </form>
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

  </div> <!-- End Grid -->

  </main>

  <!-- Modal Contabilidade -->
  <div id="modalContabilidade" class="fixed inset-0 bg-black/60 hidden z-50 flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden animate-fade-in-up">
        <div class="bg-amber-800 px-6 py-4 flex justify-between items-center text-white">
            <h3 class="text-xl font-bold flex items-center gap-2">
                <i class="fas fa-chart-pie"></i> Relatório Financeiro
            </h3>
            <button onclick="closeContabilidade()" class="text-amber-200 hover:text-white transition">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <div class="p-8">
            <div class="grid grid-cols-2 gap-6">
                <!-- Card Stats -->
                <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                    <p class="text-blue-600 font-bold uppercase text-xs tracking-wider">Total em Estoque</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1"><?= $totalEstoque ?> <span class="text-sm font-normal text-gray-500">un.</span></p>
                </div>

                <div class="bg-green-50 p-4 rounded-xl border border-green-100">
                    <p class="text-green-600 font-bold uppercase text-xs tracking-wider">Vendas Realizadas</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1"><?= $totalVendidos ?> <span class="text-sm font-normal text-gray-500">un.</span></p>
                </div>

                <div class="bg-amber-50 p-4 rounded-xl border border-amber-100">
                    <p class="text-amber-600 font-bold uppercase text-xs tracking-wider">Patrimônio Investido</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">R$ <?= number_format($totalInvestido, 2, ',', '.') ?></p>
                </div>

                <div class="bg-purple-50 p-4 rounded-xl border border-purple-100">
                    <p class="text-purple-600 font-bold uppercase text-xs tracking-wider">Receita Total</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">R$ <?= number_format($totalRecebido, 2, ',', '.') ?></p>
                </div>
            </div>

            <div class="mt-8 bg-gray-50 p-4 rounded-lg text-sm text-gray-600 border border-gray-200">
                <i class="fas fa-info-circle mr-2"></i> Os dados são calculados em tempo real com base no banco de dados.
            </div>
        </div>
    </div>
  </div>

  <script>
    function openContabilidade() {
        document.getElementById('modalContabilidade').classList.remove('hidden');
    }
    function closeContabilidade() {
        document.getElementById('modalContabilidade').classList.add('hidden');
    }
    // Fechar ao clicar fora
    document.getElementById('modalContabilidade').addEventListener('click', function(e) {
        if (e.target === this) {
            closeContabilidade();
        }
    });

    // Custom Animation
    tailwind.config.theme.extend.keyframes = {
        ...tailwind.config.theme.extend.keyframes,
        'fade-in-up': {
            '0%': { opacity: '0', transform: 'translateY(10px)' },
            '100%': { opacity: '1', transform: 'translateY(0)' },
        }
    }
    tailwind.config.theme.extend.animation = {
        ...tailwind.config.theme.extend.animation,
        'fade-in-up': 'fade-in-up 0.3s ease-out',
    }
  </script>
    <div class="max-w-7xl mx-auto px-4 text-center">
      <p>© 2026 Compre Seu Pão - Painel Administrativo</p>
    </div>
  </footer>

</body>
</html>