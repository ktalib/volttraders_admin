<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ gs()->siteName(__($pageTitle)) }}</title>

    <!-- Tailwind CSS with custom animations -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'gradient-x': 'gradient-x 15s ease infinite',
                        'gradient-y': 'gradient-y 15s ease infinite',
                        'gradient-xy': 'gradient-xy 15s ease infinite',
                        'float': 'float 6s ease-in-out infinite',
                        'fade-in': 'fade-in 1.2s ease-out',
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
        
        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #9CA3AF;
            transition: color 0.2s;
        }
        
        .password-toggle:hover {
            color: #E5E7EB;
        }
        
        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
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
        
        <!-- Registration Form -->
        <form method="POST" action="{{ route('user.register') }}" class="bg-black bg-opacity-50 backdrop-blur-lg rounded-xl p-8 glow-box border border-gray-800 transform hover:scale-[1.005] transition duration-500">
            @csrf
            <h2 class="text-center text-3xl font-bold gradient-text mb-2">Create Account</h2>
            <p class="text-center text-gray-400 mb-8">Join our community today</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div class="relative">
                    <i class="fas fa-user input-icon"></i>
                    <input 
                        type="text" 
                        name="firstname"
                        placeholder="First Name" 
                        value="{{ old('firstname') }}" 
                        required
                        class="w-full p-3 pl-10 bg-gray-900 text-white border border-gray-700 rounded-md focus:outline-none input-glow"
                    >
                </div>
                <div class="relative">
                    <i class="fas fa-user-tag input-icon"></i>
                    <input 
                        type="text" 
                        name="lastname"
                        placeholder="Last Name" 
                        value="{{ old('lastname') }}"
                        required
                        class="w-full p-3 pl-10 bg-gray-900 text-white border border-gray-700 rounded-md focus:outline-none input-glow"
                    >
                </div>
            </div>
            
            <div class="mb-4 relative">
                <i class="fas fa-envelope input-icon"></i>
                <input 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    placeholder="Email Address" 
                    required
                    class="w-full p-3 pl-10 bg-gray-900 text-white border border-gray-700 rounded-md focus:outline-none input-glow"
                >
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div class="relative">
                    <i class="fas fa-lock input-icon"></i>
                    <input 
                        type="password" 
                        name="password"
                        placeholder="Password" 
                        required
                        class="w-full p-3 pl-10 pr-10 bg-gray-900 text-white border border-gray-700 rounded-md focus:outline-none input-glow"
                        id="password-field"
                    >
                    <span class="password-toggle" onclick="togglePassword('password-field', this)">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
                <div class="relative">
                    <i class="fas fa-lock input-icon"></i>
                    <input 
                        type="password" 
                        name="password_confirmation"
                        placeholder="Confirm Password" 
                        required
                        class="w-full p-3 pl-10 pr-10 bg-gray-900 text-white border border-gray-700 rounded-md focus:outline-none input-glow"
                        id="confirm-password-field"
                    >
                    <span class="password-toggle" onclick="togglePassword('confirm-password-field', this)">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
            </div>
            
            <div class="flex items-center mb-6">
                <input 
                    type="checkbox" 
                    id="agree"
                    @checked(old('agree')) 
                    name="agree"
                    class="mr-2 bg-gray-900 border-gray-700 rounded text-blue-500 focus:ring-blue-500"
                    required
                >
                <label for="agree" class="text-gray-300 text-sm">
                    I agree to the 
                    <a href="#" class="text-blue-400 hover:text-blue-300">Terms</a> and 
                    <a href="#" class="text-blue-400 hover:text-blue-300">Privacy Policy</a>
                </label>
            </div>
            
            <button 
                type="submit" 
                class="w-full btn-gradient text-white py-3 rounded-xl font-medium transition duration-500 mb-4"
            >
                Register Now
            </button>
            
            <div class="text-center text-gray-400 text-sm">
                Already have an account? 
                <a href="/user/login" class="text-blue-400 hover:text-blue-300 font-medium">Sign In</a>
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
        // Toggle password visibility
        function togglePassword(fieldId, toggleElement) {
            const field = document.getElementById(fieldId);
            const icon = toggleElement.querySelector('i');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
        
        // Add ripple effect to buttons
        document.querySelectorAll('button').forEach(button => {
            button.addEventListener('click', function(e) {
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const ripple = document.createElement('span');
                ripple.className = 'absolute block bg-white/20 rounded-full -translate-x-1/2 -translate-y-1/2';
                ripple.style.width = '5px';
                ripple.style.height = '5px';
                ripple.style.left = `${x}px`;
                ripple.style.top = `${y}px`;
                ripple.style.animation = 'ripple 0.6s linear';
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    </script>
</body>
</html>