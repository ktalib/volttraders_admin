<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">   
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ gs()->siteName(__($pageTitle)) }}</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'gradient-x': 'gradient-x 8s ease infinite',
                        'gradient-y': 'gradient-y 8s ease infinite',
                        'gradient-xy': 'gradient-xy 8s ease infinite',
                        'float': 'float 6s ease-in-out infinite',
                        'fade-in': 'fade-in 1.2s ease-out',
                        'pulse-slow': 'pulse 6s infinite',
                    },
                    keyframes: {
                        'gradient-y': {
                            '0%, 100%': {
                                'background-size': '400% 400%',
                                'background-position': 'center top'
                            },
                            '50%': {
                                'background-size': '200% 200%',
                                'background-position': 'center center'
                            }
                        },
                        'gradient-x': {
                            '0%, 100%': {
                                'background-size': '200% 200%',
                                'background-position': 'left center'
                            },
                            '50%': {
                                'background-size': '200% 200%',
                                'background-position': 'right center'
                            }
                        },
                        'gradient-xy': {
                            '0%, 100%': {
                                'background-position': '0% 50%'
                            },
                            '50%': {
                                'background-position': '100% 50%'
                            }
                        },
                        'float': {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' }
                        },
                        'fade-in': {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        }
                    }
                }
            }
        }
    </script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(-45deg, #0f0f1a, #1a1a2e, #16213e, #0f3460);
            background-size: 400% 400%;
            animation: gradient-xy 15s ease infinite;
            min-height: 100vh;
        }
        
        .glow-box {
            box-shadow: 0 0 20px rgba(56, 182, 255, 0.3);
        }
        
        .input-glow:focus {
            box-shadow: 0 0 0 3px rgba(56, 182, 255, 0.3);
        }
        
        .btn-gradient {
            background: linear-gradient(45deg, #3b82f6, #8b5cf6, #ec4899);
            background-size: 200% 200%;
            transition: all 0.5s ease;
        }
        
        .btn-gradient:hover {
            background-position: right center;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(59, 130, 246, 0.4);
        }
        
        .logo-container {
            filter: drop-shadow(0 0 10px rgba(56, 182, 255, 0.5));
        }
        
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        
        .fade-in {
            animation: fade-in 1.2s ease-out;
        }
        
        .gradient-text {
            background: linear-gradient(45deg, #3b82f6, #8b5cf6, #ec4899);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            background-size: 200% 200%;
            animation: gradient-x 8s ease infinite;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <!-- Animated background elements -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden z-0">
        <div class="absolute top-10% left-10% w-20 h-20 rounded-full bg-blue-500 opacity-10 blur-xl floating"></div>
        <div class="absolute top-70% left-80% w-32 h-32 rounded-full bg-purple-500 opacity-10 blur-xl floating" style="animation-delay: 2s;"></div>
        <div class="absolute top-30% left-60% w-16 h-16 rounded-full bg-pink-500 opacity-10 blur-xl floating" style="animation-delay: 4s;"></div>
    </div>
    
    <div class="w-full max-w-md z-10 fade-in">
        <!-- Logo with animation -->
        <div class="flex justify-between items-center mb-8">
            <div class="logo-container flex items-center space-x-2">
    <a href="#" class="flex items-center transform hover:scale-105 transition duration-300">
        <!--<img src="{{ siteLogo() }}" alt="Logo" class="h-12 w-auto rounded-full glow-box">-->
        <span class="text-xl font-semibold text-white">TradePro</span>
    </a>
</div>

            <a href="{{ route('home') }}" class="text-white hover:text-gray-300 transition duration-300 group">
                <div class="flex items-center space-x-2">
                    <span class="text-sm font-medium opacity-0 group-hover:opacity-100 transition duration-300">Home</span>
                    <div class="w-10 h-10 rounded-full bg-gray-900 bg-opacity-50 flex items-center justify-center border border-gray-800 group-hover:border-blue-500 transition duration-300">
                        <i class="fas fa-home text-xl"></i>
                    </div>
                </div>
            </a>
        </div>
        
        <!-- Login Form -->
        <form method="POST" action="{{ route('user.login') }}" class="bg-gray-900 bg-opacity-50 backdrop-blur-lg rounded-xl p-8 glow-box border border-gray-800 transform hover:scale-[1.005] transition duration-500">
            @csrf
            <h2 class="text-center text-3xl font-bold gradient-text mb-2">Welcome Back</h2>
            <p class="text-center text-gray-400 mb-8">Log in to your account</p>
            
            <div class="mb-6 space-y-6">
                <div class="relative">
                    <input 
                        type="text" 
                        name="username"
                        placeholder="@lang('Email / Username')"
                        class="w-full p-4 bg-gray-800 bg-opacity-50 text-white border border-gray-700 rounded-xl focus:outline-none focus:border-blue-500 input-glow transition duration-300 pl-12"
                        required
                    >
                    <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
                
                <div class="relative">
                    <input 
                        type="password" 
                        name="password"
                        placeholder="Password"
                        class="w-full p-4 bg-gray-800 bg-opacity-50 text-white border border-gray-700 rounded-xl focus:outline-none focus:border-blue-500 input-glow transition duration-300 pl-12 pr-12"
                        required
                    >
                    <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-lock"></i>
                    </div>
                    <button 
                        type="button" 
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white transition duration-300"
                        onclick="togglePasswordVisibility()"
                    >
                        <i id="passwordToggle" class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            
            <div class="flex justify-between text-sm text-gray-400 mb-6">
                <a href="{{ route('user.register') }}" class="hover:text-white transition duration-300 flex items-center">
                    <span class="mr-1">New here?</span> 
                    <span class="font-medium gradient-text">Sign up</span>
                    <i class="fas fa-arrow-right ml-1 text-xs"></i>
                </a>
                <a href="{{ route('user.password.request') }}" class="hover:text-white transition duration-300">
                    Forgot password?
                </a>
            </div>
            
            <button 
                type="submit" 
                class="w-full btn-gradient text-white py-4 rounded-xl font-medium text-lg transition duration-500 hover:shadow-lg"
            >
                Log In
                <i class="fas fa-arrow-right ml-2"></i>
            </button>
            
            <div class="mt-6 text-center text-gray-500 text-sm">
                <p>Or continue with</p>
                <div class="flex justify-center space-x-4 mt-3">
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-gray-700 transition duration-300">
                        <i class="fab fa-google text-red-400"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-gray-700 transition duration-300">
                        <i class="fab fa-apple text-gray-300"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-gray-700 transition duration-300">
                        <i class="fab fa-facebook-f text-blue-400"></i>
                    </a>
                </div>
            </div>
        </form>
        
        <div class="mt-6 text-center text-gray-500 text-sm">
            <p>© 2023 {{ gs()->siteName(__($pageTitle)) }}. All rights reserved.</p>
        </div>
    </div>

    @stack('script-lib')
    @php echo loadExtension('tawk-chat') @endphp
    @include('partials.notify')

    @if (gs('pn'))
        @include('partials.push_script')
    @endif
    
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.querySelector('input[name="password"]');
            const toggleIcon = document.getElementById('passwordToggle');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
        
        // Add ripple effect to buttons
        document.querySelectorAll('button, a').forEach(button => {
            button.addEventListener('click', function(e) {
                const x = e.clientX - e.target.getBoundingClientRect().left;
                const y = e.clientY - e.target.getBoundingClientRect().top;
                
                const ripple = document.createElement('span');
                ripple.className = 'ripple';
                ripple.style.left = `${x}px`;
                ripple.style.top = `${y}px`;
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 1000);
            });
        });
    </script>
</body>
</html>