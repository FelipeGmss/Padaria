<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Padaria</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-100 min-h-screen flex items-center justify-center p-4 font-sans">
  
  <div class="w-full max-w-md">
    
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
      
      <div class="bg-gradient-to-r from-amber-600 to-orange-600 p-8 text-center text-white">
        <div class="bg-white/20 backdrop-blur-sm w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
          <i class="fas fa-user-shield text-4xl"></i>
        </div>
        <h1 class="text-3xl font-bold mb-2">Área Administrativa</h1>
        <p class="text-amber-100">Acesse o painel de controle</p>
      </div>

      <div class="p-8">
        
        <?php if(isset($_GET['erro'])): ?>
          <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
            <div class="flex items-center">
              <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
              <p class="text-red-700 text-sm font-medium">Email ou senha incorretos!</p>
            </div>
          </div>
        <?php endif; ?>

        <form action="../controllers/Controller-login.php" method="POST" class="space-y-5">
            
          <div>
            <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2 ml-1">
              <i class="fas fa-envelope text-amber-500 mr-1"></i> Email
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i class="fas fa-user text-gray-400"></i>
              </div>
              <input 
                type="email" 
                name="email" 
                required 
                autocomplete="email"
                class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-200 focus:outline-none transition-all text-gray-700 placeholder-gray-400" 
                placeholder="seu@email.com">
            </div>
          </div>

          <div>
            <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2 ml-1">
              <i class="fas fa-lock text-amber-500 mr-1"></i> Senha
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i class="fas fa-key text-gray-400"></i>
              </div>
              <input 
                type="password" 
                name="senha" 
                required 
                autocomplete="current-password"
                class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-200 focus:outline-none transition-all text-gray-700 placeholder-gray-400" 
                placeholder="••••••••">
            </div>
          </div>

          <button 
            type="submit" 
            name="btn-login" 
            class="w-full bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white font-bold text-lg py-4 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2 mt-6">
            <i class="fas fa-sign-in-alt"></i>
            Entrar
          </button>
        </form>

        <div class="mt-6 text-center">
          <a href="listar.php" class="text-gray-500 text-sm hover:text-amber-600 transition-colors inline-flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Voltar para a loja
          </a>
        </div>

      </div>
    </div>

    <p class="text-center text-gray-500 text-xs mt-6">
      <i class="fas fa-shield-alt text-amber-600"></i> Área restrita aos administradores
    </p>

  </div>

</body>
</html>