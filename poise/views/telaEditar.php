<?php
if (!isset($dados_produto) || empty($dados_produto)) {
    header('Location: editar.php?error=dados_nao_encontrados');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto - Padaria</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              'padaria-primary':   '#ca0101',
              'padaria-accent':    '#c48d04',
              'padaria-bg':        '#FDFBF7',
              'padaria-light':     '#F5F0E9',
              'padaria-dark':      '#4A2C0B',
            }
          }
        }
      }
    </script>
    <style>
        .error-message {
            display: none;
            color: #dc2626;
            font-size: 0.75rem;
            margin-top: 0.5rem;
        }
        .input-group.error .error-message {
            display: block;
        }
        .input-group.error input {
            border-color: #dc2626;
        }
    </style>
</head>
<body class="bg-padaria-bg min-h-screen flex items-center justify-center p-8 sm:p-8 font-sans">
  <div class="w-full max-w-md bg-white rounded-xl shadow-lg border border-padaria-light overflow-hidden">
    <a href="javascript:history.back()" class="inline-flex items-center gap-2 text-padaria-dark hover:text-padaria-primary px-8 pt-4">
      <i class="fas fa-arrow-left"></i>
      <span>Voltar</span>
    </a>

    <div class="bg-padaria-primary text-white py-4 px-8 text-center">
      <h1 class="text-2xl font-bold">Editar Produto</h1>
      <p class="text-sm mt-1 opacity-90">Atualize os dados do produto</p>
    </div>

    <form action="../controllers/Controller-editar.php" method="POST" enctype="multipart/form-data" class="p-6">
      <input type="hidden" name="id" value="<?php echo htmlspecialchars($dados_produto['id']) ?>">>
      
      <div class="input-group mb-4">
          <label for="foto_produto" class="block text-gray-700 font-medium mb-2">Foto do Produto</label>
          <input type="file" id="foto_produto" name="foto_produto" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-padaria-primary transition-all">
          <span class="error-message" id="fotoError">Por favor, selecione uma imagem válida</span>
          <div id="preview-container" class="mt-4 hidden">
            <img id="preview" class="w-full h-48 object-cover rounded-lg border border-padaria-light" alt="Preview">
          </div>
          <?php if (!empty($dados_produto['foto_produto'])): ?>
            <div class="mt-2">
              <p class="text-sm text-gray-600">Foto atual:</p>
              <img src="<?php echo htmlspecialchars($dados_produto['foto_produto']) ?>" class="w-full h-48 object-cover rounded-lg border border-padaria-light mt-1" alt="Foto atual">
            </div>
          <?php endif; ?>
      </div>

      <div class="input-group mb-4">
        <label for="nome_produto" class="block text-gray-700 font-medium mb-2">Nome do Produto</label>
        <input type="text" id="nome_produto" name="nome_produto" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-padaria-primary transition-all"
        placeholder="Digite o nome do produto"
        value="<?php echo htmlspecialchars($dados_produto['nome_produto']) ?>">
        <span class="error-message" id="nomeError">Por favor, insira um nome válido</span>
      </div>

      <div class="input-group mb-4">
        <label for="preco_produto" class="block text-gray-700 font-medium mb-2">Preço</label>
        <input type="number" step="0.01" id="preco_produto" name="preco_produto" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-padaria-primary transition-all"
        placeholder="0.00"
        value="<?php echo htmlspecialchars($dados_produto['preco_produto']) ?>">
        <span class="error-message" id="precoError">Por favor, insira um preço válido</span>
      </div>

      <div class="input-group mb-6">
        <label for="quantidade_produto" class="block text-gray-700 font-medium mb-2">Quantidade</label>
        <input type="number" id="quantidade_produto" name="quantidade_produto" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-padaria-primary transition-all"
        placeholder="Digite a quantidade"
        min="0"
        value="<?php echo htmlspecialchars($dados_produto['quantidade_produto']) ?>">
        <span class="error-message" id="quantidadeError">Por favor, insira uma quantidade válida</span>
      </div>

      <button type="submit" name="btn-editar" class="w-full bg-padaria-primary text-white px-6 py-3 rounded-lg hover:bg-padaria-accent transition-all font-semibold">
        Atualizar Produto
      </button>
    </form>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.querySelector('form');
      const input = document.getElementById('foto_produto');
      const preview = document.getElementById('preview');
      const container = document.getElementById('preview-container');

      input.addEventListener('change', e => {
        const file = e.target.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = ev => {
            preview.src = ev.target.result;
            container.classList.remove('hidden');
          };
          reader.readAsDataURL(file);
        } else {
          preview.src = '';
          container.classList.add('hidden');
        }
      });

      form.addEventListener('submit', function(e) {
        let isValid = true;
        const inputs = form.querySelectorAll('input[required]');

        inputs.forEach(input => {
          const inputGroup = input.closest('.input-group');
          if (!input.value || (input.type === 'number' && parseFloat(input.value) < 0)) {
            inputGroup.classList.add('error');
            isValid = false;
          } else {
            inputGroup.classList.remove('error');
          }
        });

        if (!isValid) {
          e.preventDefault();
        }
      });

      document.querySelectorAll('input').forEach(input => {
        input.addEventListener('input', function() {
          const inputGroup = this.closest('.input-group');
          if (inputGroup) {
            inputGroup.classList.remove('error');
          }
        });
      });
    });
  </script>
</body>
</html>