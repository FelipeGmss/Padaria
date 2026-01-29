<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compre Seu Pão - A Melhor Padaria</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .bread-pattern {
            background-color: #ffffff;
            opacity: 0.1;
            background-image:  repeating-radial-gradient( circle at 0 0, transparent 0, #ffffff 10px ), repeating-linear-gradient( #f59e0b55, #f59e0b 2px );
        }
    </style>
</head>
<body class="bg-orange-50 font-sans text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white/90 backdrop-blur-md shadow-sm fixed w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <i class="fas fa-bread-slice text-amber-600 text-3xl"></i>
                    <span class="font-bold text-2xl text-amber-900 tracking-tight">Padaria<span class="text-amber-600">Poise</span></span>
                </div>
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="#" class="text-gray-600 hover:text-amber-600 font-medium transition">Home</a>
                    <a href="#sobre" class="text-gray-600 hover:text-amber-600 font-medium transition">Sobre Nós</a>
                    <a href="views/listar.php" class="bg-amber-600 text-white px-6 py-2.5 rounded-full hover:bg-amber-700 transition shadow-lg shadow-amber-600/20 font-bold">
                        <i class="fas fa-shopping-bag mr-2"></i>Fazer Pedido
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="absolute inset-0 bread-pattern"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row items-center gap-12 text-center lg:text-left">
            
            <div class="lg:w-1/2 space-y-8 animate-fade-in-up">
                <h1 class="text-5xl lg:text-7xl font-extrabold text-amber-950 leading-tight">
                    O pão quentinho que <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-600 to-orange-600">abraça seu dia</span>.
                </h1>
                <p class="text-xl text-gray-600 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    Artesanal, fresco e feito com amor. Experimente o sabor da tradição em cada mordida. Peça online e receba no conforto da sua casa.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="views/listar.php" class="group relative px-8 py-4 bg-amber-600 rounded-2xl text-white font-bold text-lg shadow-xl shadow-amber-600/30 overflow-hidden transition-all hover:scale-105 active:scale-95">
                        <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-shimmer"></div>
                        <span class="flex items-center gap-2">
                            Sou Cliente
                            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </span>
                    </a>
                    
                    <a href="views/loginAdmin.php" class="px-8 py-4 bg-white border-2 border-amber-200 rounded-2xl text-amber-800 font-bold text-lg hover:bg-amber-50 hover:border-amber-400 transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-user-shield"></i>
                        Sou Administrador
                    </a>
                </div>

                <div class="pt-6 flex items-center justify-center lg:justify-start gap-6 text-sm text-gray-500 font-medium">
                    <span class="flex items-center gap-2"><i class="fas fa-check-circle text-green-500"></i> Entrega Rápida</span>
                    <span class="flex items-center gap-2"><i class="fas fa-star text-amber-400"></i> Qualidade Premium</span>
                </div>
            </div>

            <div class="lg:w-1/2 relative">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[120%] bg-amber-200/20 rounded-full blur-3xl -z-10"></div>
                <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?q=80&w=1000&auto=format&fit=crop" 
                     class="rounded-[2.5rem] shadow-2xl rotate-3 hover:rotate-0 transition-all duration-700 border-4 border-white object-cover aspect-[4/3] w-full max-w-lg mx-auto"
                     alt="Pães artesanais deliciosos">
                
                <!-- Floating Card -->
                <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-xl shadow-xl flex items-center gap-4 animate-bounce-slow hidden md:flex">
                    <div class="bg-green-100 p-3 rounded-full text-green-600">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-bold uppercase">Saindo do forno</p>
                        <p class="font-bold text-gray-800">Agora mesmo!</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Features Section -->
    <section class="py-20 bg-white" id="sobre">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl lg:text-4xl font-bold text-amber-900 mb-16">Por que escolher a Poise?</h2>
            
            <div class="grid md:grid-cols-3 gap-10">
                <div class="p-8 rounded-3xl bg-orange-50 hover:bg-orange-100 transition duration-300 group">
                    <div class="w-16 h-16 mx-auto bg-amber-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-wheat text-3xl text-amber-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Ingredientes Selecionados</h3>
                    <p class="text-gray-600">Trabalhamos apenas com farinhas importadas e fermentação natural de 48 horas.</p>
                </div>

                <div class="p-8 rounded-3xl bg-orange-50 hover:bg-orange-100 transition duration-300 group">
                    <div class="w-16 h-16 mx-auto bg-amber-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-heart text-3xl text-amber-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Feito com Amor</h3>
                    <p class="text-gray-600">Cada pão é moldado manualmente por nossos padeiros apaixonados pelo que fazem.</p>
                </div>

                <div class="p-8 rounded-3xl bg-orange-50 hover:bg-orange-100 transition duration-300 group">
                    <div class="w-16 h-16 mx-auto bg-amber-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-truck text-3xl text-amber-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Entrega Express</h3>
                    <p class="text-gray-600">Seu pedido chega quentinho na sua porta em tempo recorde.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-amber-900 text-amber-200 py-10">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <div class="flex justify-center items-center gap-2 mb-6 opacity-50">
                <i class="fas fa-bread-slice text-2xl"></i>
                <span class="font-bold text-xl">PadariaPoise</span>
            </div>
            <p>© 2026 Padaria Poise. Todos os direitos reservados.</p>
            <p class="text-sm mt-2 opacity-60">Feito com carinho e farinha de trigo.</p>
        </div>
    </footer>

    <script>
        // Configuração Tailwind personalizada
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'bounce-slow': 'bounce 3s infinite',
                        'shimmer': 'shimmer 2s infinite',
                    },
                    keyframes: {
                        shimmer: {
                            '100%': { transform: 'translateX(100%)' }
                        }
                    }
                }
            }
        }
    </script>
</body>
</html>