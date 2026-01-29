<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Produto - Padaria</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              'padaria-primary':   '#ca0101',   // marrom quente casca de pão
              'padaria-accent':    '#c48d04',   // dourado tostado
              'padaria-bg':        '#FDFBF7',   // bege super claro
              'padaria-light':     '#F5F0E9',   // bordas/ fundo campos
              'padaria-dark':      '#4A2C0B',   // texto principal
            }
          }
        }
      }
    </script>
</head>
<body class="bg-gradient-to-br from-orange-50 to-amber-100 min-h-screen flex items-center justify-center p-4 sm:p-8 font-sans">
  
  <div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row animate-fade-in-up">
    
    <!-- Lado Esquerdo - Decorativo -->
    <div class="md:w-2/5 bg-gradient-to-br from-amber-600 to-orange-700 relative hidden md:flex flex-col justify-center items-center text-white p-12 text-center">
        <div class="absolute inset-0 opacity-10" style="background-image: url('https://www.transparenttextures.com/patterns/food.png');"></div>
        <div class="relative z-10">
            <div class="bg-white/20 p-6 rounded-full inline-block mb-6 shadow-2xl backdrop-blur-sm">
                <i class="fas fa-bread-slice text-5xl text-amber-100"></i>
            </div>
            <h2 class="text-3xl font-bold mb-2">Novo Produto</h2>
            <p class="text-amber-100/90 text-lg">Adicione sabor à sua vitrine.</p>
        </div>
        <a href="listar.php" class="absolute bottom-8 text-amber-200 hover:text-white transition flex items-center gap-2 text-sm font-bold">
            <i class="fas fa-arrow-left"></i> Voltar para Loja
        </a>
    </div>

    <!-- Lado Direito - Formuário -->
    <div class="md:w-3/5 p-8 sm:p-12 relative">
        <div class="md:hidden mb-8 text-center">
            <h1 class="text-2xl font-bold text-amber-800">Novo Produto</h1>
            <p class="text-gray-500 text-sm">Preencha os dados abaixo</p>
        </div>

        <form action="../controllers/Controller-login.php" method="POST" enctype="multipart/form-data" class="space-y-6">
            
            <!-- Campo de foto e Preview -->
            <div class="group relative"></div>

            <!-- Inputs -->
            <div class="space-y-5">
                
                <!-- Nome -->
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1 ml-1">Email do Admin</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-tag text-gray-400 text-lg"></i>
                        </div>
                        <input type="text" id="email" name="email" required 
                            class="w-full pl-12 pr-4 py-3 bg-gray-50 border-2 border-gray-100 rounded-xl focus:bg-white focus:border-amber-500 focus:outline-none transition-all font-medium text-gray-700 placeholder-gray-400" 
                            placeholder="Ex: Pão de Queijo">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1 ml-1">Senha</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-gray-400 font-bold ml-0.5">R$</span>
                            </div>
                            <input type="password" step="0.01" id="senha" name="senha" required 
                                class="w-full pl-12 pr-4 py-3 bg-gray-50 border-2 border-gray-100 rounded-xl focus:bg-white focus:border-amber-500 focus:outline-none transition-all font-medium text-gray-700 placeholder-gray-400"
                                placeholder="0.00">
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" name="btn-login" class="w-full bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white font-bold text-lg py-4 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3">
                <i class="fas fa-check-circle"></i>
                Login
            </button>
            
            <div class="md:hidden text-center mt-4">
                <a href="listar.php" class="text-gray-500 text-sm font-medium hover:text-amber-600">Cancelar e Voltar</a>
            </div>

        </form>
    </div>
  </div>

  <script>
    const input = document.getElementById('foto_produto');
    const preview = document.getElementById('preview');
    const container = document.getElementById('preview-container');
    const uploadText = document.getElementById('upload-text');
    const uploadIcon = document.getElementById('upload-icon');

    input.addEventListener('change', e => {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = ev => {
          preview.src = ev.target.result;
          preview.classList.remove('hidden');
          // Esconde texto/icone quando tem imagem
          uploadText.classList.add('opacity-0');
          uploadIcon.classList.add('opacity-0');
        };
        reader.readAsDataURL(file);
      } else {
        preview.src = '';
        preview.classList.add('hidden');
        uploadText.classList.remove('opacity-0');
        uploadIcon.classList.remove('opacity-0');
      }
    });
    
    // Animação fade in
    tailwind.config.theme.extend.animation = {
        'fade-in-up': 'fade-in-up 0.5s ease-out forwards',
    }
    tailwind.config.theme.extend.keyframes = {
        'fade-in-up': {
            '0%': { opacity: '0', transform: 'translateY(20px)' },
            '100%': { opacity: '1', transform: 'translateY(0)' },
        }
    }
  </script>
</body>
</html>