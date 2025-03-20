<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Place - Navbar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .nav-link {
            position: relative;
            padding: 0.5rem 1rem;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: #DC2626;
            transition: all 0.3s ease-in-out;
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 100%;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .mobile-menu {
            animation: slideDown 0.3s ease-in-out;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        .logo:hover {
            animation: bounce 0.5s infinite;
        }

        .order-button {
            transition: all 0.3s ease;
            background: linear-gradient(45deg, #DC2626, #EF4444);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.2);
        }

        .order-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.3);
        }
    </style>
</head>
<body>
    <nav class="bg-white shadow-lg fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo con ruta condicional -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ auth()->check() ? route('pizzas.index') : route('mainp') }}" class="logo flex items-center space-x-2">
                        <span class="text-3xl">🍕</span>
                        <span class="text-2xl font-bold bg-gradient-to-r from-red-600 to-red-400 bg-clip-text text-transparent">
                            PizzaPlace
                        </span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ auth()->check() ? route('pizzas.index') : route('mainp') }}" 
                       class="nav-link text-gray-700 hover:text-red-600 transition-colors duration-300">
                        Inicio
                    </a>
                    <a href="{{ route('nosotros') }}" class="nav-link text-gray-700 hover:text-red-600 transition-colors duration-300">
                        Nosotros
                    </a>
                    <a href="{{ route('contacto') }}" class="nav-link text-gray-700 hover:text-red-600 transition-colors duration-300">
                        Contacto
                    </a>

                    @auth
                        <div class="flex items-center space-x-4">
                            <form action="{{ route('logout') }}" method="GET" class="inline">
                                @csrf
                                <button type="submit" class="nav-link text-gray-700 hover:text-red-600 transition-colors duration-300">
                                    Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="nav-link text-gray-700 hover:text-red-600 transition-colors duration-300">
                            Iniciar Sesión
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    <script>
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Cerrar menú móvil al hacer click fuera
        document.addEventListener('click', (e) => {
            if (!mobileMenu.contains(e.target) && !mobileMenuButton.contains(e.target)) {
                mobileMenu.classList.add('hidden');
            }
        });

        // Efecto de scroll
        let lastScroll = 0;
        const navbar = document.querySelector('nav');

        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;
            
            if (currentScroll <= 0) {
                navbar.style.transform = 'translateY(0)';
                return;
            }
            
            if (currentScroll > lastScroll && !mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.add('hidden');
            }
            
            if (currentScroll > lastScroll && currentScroll > 100) {
                navbar.style.transform = 'translateY(-100%)';
            } else {
                navbar.style.transform = 'translateY(0)';
            }
            
            lastScroll = currentScroll;
        });
    </script>
</body>
</html>