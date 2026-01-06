<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedStock - Sistema de Gestão Hospitalar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-indigo-600">🏥 MedStock</h1>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('reports.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Sair
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Entrar
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            Cadastrar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h2 class="text-5xl font-extrabold text-gray-900 sm:text-6xl mb-6">
                    Gestão Hospitalar <span class="text-indigo-600">Inteligente</span>
                </h2>
                <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                    Sistema completo para gerenciamento de estoque, produtos, movimentações e finanças hospitalares
                </p>
                <div class="flex justify-center space-x-4">
                    @auth
                        <a href="{{ route('reports.dashboard') }}" class="inline-flex items-center px-8 py-4 border border-transparent text-lg font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg transform hover:scale-105 transition duration-150">
                            Acessar Sistema
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 border border-transparent text-lg font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg transform hover:scale-105 transition duration-150">
                            Começar Agora
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-4 border-2 border-indigo-600 text-lg font-medium rounded-lg text-indigo-600 bg-white hover:bg-indigo-50 transition duration-150">
                            Fazer Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h3 class="text-3xl font-bold text-gray-900 mb-4">Funcionalidades Principais</h3>
                <p class="text-lg text-gray-600">Tudo que você precisa para gerenciar seu hospital</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 hover:shadow-xl transition duration-150">
                    <div class="text-4xl mb-4">📦</div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Controle de Estoque</h4>
                    <p class="text-gray-600">Gerencie produtos, quantidades, validades e estoque mínimo de forma eficiente</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 hover:shadow-xl transition duration-150">
                    <div class="text-4xl mb-4">📊</div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Relatórios Detalhados</h4>
                    <p class="text-gray-600">Acompanhe movimentações, demanda de produtos e análises completas</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 hover:shadow-xl transition duration-150">
                    <div class="text-4xl mb-4">💰</div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Gestão Financeira</h4>
                    <p class="text-gray-600">Controle orçamentos, despesas por categoria e análises sazonais</p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-6 hover:shadow-xl transition duration-150">
                    <div class="text-4xl mb-4">⚠️</div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Alertas Inteligentes</h4>
                    <p class="text-gray-600">Notificações de produtos vencidos, próximos ao vencimento e estoque baixo</p>
                </div>

                <!-- Feature 5 -->
                <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-6 hover:shadow-xl transition duration-150">
                    <div class="text-4xl mb-4">🏥</div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Multi-Hospital</h4>
                    <p class="text-gray-600">Gerencie múltiplos hospitais em uma única plataforma integrada</p>
                </div>

                <!-- Feature 6 -->
                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl p-6 hover:shadow-xl transition duration-150">
                    <div class="text-4xl mb-4">📈</div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Análise de Demanda</h4>
                    <p class="text-gray-600">Identifique produtos mais consumidos e otimize seus pedidos</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 py-16">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h3 class="text-3xl font-bold text-white mb-4">
                Pronto para transformar sua gestão hospitalar?
            </h3>
            <p class="text-xl text-indigo-100 mb-8">
                Comece agora e tenha acesso completo a todas as funcionalidades
            </p>
            @guest
                <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 border-2 border-white text-lg font-medium rounded-lg text-white hover:bg-white hover:text-indigo-600 transition duration-150">
                    Criar Conta Gratuita
                </a>
            @endguest
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-gray-400">© {{ date('Y') }} MedStock. Todos os direitos reservados.</p>
                <p class="text-gray-500 text-sm mt-2">Sistema de Gestão Hospitalar</p>
            </div>
        </div>
    </footer>
</body>
</html>
