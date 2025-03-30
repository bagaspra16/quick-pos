<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Quick POS') }} - Login</title>
    
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        body {
            background-color: #0f172a;
        }
        
        /* Toggle password button */
        .eye-button {
            transition: all 0.2s ease;
            height: 48px; /* Sesuaikan dengan tinggi input */
            width: 48px;
            border-top-right-radius: 0.25rem;
            border-bottom-right-radius: 0.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-left: none;
            background-color: #374151; /* Lebih gelap dari input */
            position: relative;
        }
        
        .eye-button:hover {
            background-color: #4B5563;
        }
        
        .eye-button:hover .fa-eye, 
        .eye-button:hover .fa-eye-slash {
            color: #93C5FD; /* Light blue color on hover */
        }
        
        .eye-button:active {
            background-color: #4B5563;
            transform: scale(0.97);
        }
        
        .eye-button:focus {
            outline: none;
        }
        
        .password-field {
            position: relative;
            display: flex;
            align-items: stretch;
            margin-bottom: 0.25rem;
        }
        
        .password-field input {
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }
        
        .password-field input:focus + .eye-button {
            border-color: #3B82F6;
        }
        
        /* Custom glow when focusing on the password field or button */
        .password-field input:focus,
        .eye-button:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        }
        
        /* Tooltip */
        .tooltip {
            position: relative;
        }
        
        .tooltip::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: -35px;
            right: -5px;
            background-color: #1e293b;
            color: #e2e8f0;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            opacity: 0;
            pointer-events: none;
            white-space: nowrap;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid #334155;
            transition: all 0.2s ease;
            transform: translateY(5px);
            z-index: 10;
        }
        
        .tooltip:hover::after {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-gray-900 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="bg-gray-800 shadow-md rounded-lg px-8 py-10 mb-4">
            <div class="flex items-center justify-center mb-8">
                <i class="fas fa-cash-register text-blue-500 text-5xl"></i>
            </div>
            <h2 class="text-center text-2xl font-bold text-blue-500 mb-8">Quick POS Login</h2>
            
            @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="mb-4">
                    <label for="email" class="block text-gray-300 text-sm font-bold mb-2">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="off" autofocus
                           class="shadow appearance-none border rounded w-full py-3 px-4 bg-gray-700 border-gray-600 text-white leading-tight focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>
                
                <div class="mb-6">
                    <label for="password" class="block text-gray-300 text-sm font-bold mb-2">Password</label>
                    <div class="password-field">
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                               class="shadow appearance-none border rounded-l w-full py-3 px-4 bg-gray-700 border-gray-600 text-white leading-tight focus:outline-none focus:border-blue-500 focus:ring-0"
                               aria-describedby="passwordHint">
                        <button type="button" id="togglePassword" class="tooltip eye-button border border-gray-600 text-gray-400 transition-colors focus:outline-none" data-tooltip="Tampilkan Password" aria-label="Tampilkan Password">
                            <i class="fas fa-eye text-lg"></i>
                        </button>
                    </div>
                    <p id="passwordHint" class="text-xs text-gray-500 mt-1 mb-2">Klik ikon mata untuk melihat password</p>
                </div>
                
                <div class="mb-6">
                    <label class="flex items-center text-gray-300">
                        <input type="checkbox" name="remember" id="remember" class="mr-2 rounded border-gray-600 bg-gray-700 text-blue-500 focus:ring-blue-500">
                        <span class="text-sm">Remember me</span>
                    </label>
                </div>
                
                <div class="flex items-center justify-center">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 w-full rounded focus:outline-none focus:shadow-outline">
                        Login
                    </button>
                </div>
            </form>
        </div>
        <p class="text-center text-gray-400 text-sm">
            &copy; {{ date('Y') }} Quick POS. All rights reserved.
        </p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');
            
            // Make sure input and button heights match perfectly
            const adjustHeight = function() {
                // Get the computed height of the input
                const inputHeight = window.getComputedStyle(password).height;
                // Set the button height to match
                togglePassword.style.height = inputHeight;
            };
            
            // Adjust on page load
            setTimeout(adjustHeight, 50);
            
            togglePassword.addEventListener('click', function(e) {
                // Prevent button from submitting form if clicked
                e.preventDefault();
                
                // Toggle type attribute
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                
                // Toggle eye icon
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
                
                // Update tooltip text
                if (type === 'text') {
                    this.setAttribute('data-tooltip', 'Sembunyikan Password');
                } else {
                    this.setAttribute('data-tooltip', 'Tampilkan Password');
                }
                
                // Flash effect on icon
                this.querySelector('i').classList.add('text-blue-400');
                setTimeout(() => {
                    this.querySelector('i').classList.remove('text-blue-400');
                }, 300);
                
                // Set focus back to password field and place cursor at end
                password.focus();
                const length = password.value.length;
                password.setSelectionRange(length, length);
            });
            
            // Also allow pressing Enter key when focused on password field to submit the form
            password.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    document.querySelector('button[type="submit"]').click();
                }
            });
        });
    </script>
</body>
</html> 