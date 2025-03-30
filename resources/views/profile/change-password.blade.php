@extends('layouts.app')

@section('title', 'Ubah Password')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-white">Ubah Password</h1>
        <a href="{{ route('profile.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>
    
    <div class="bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="p-8">
            <form action="{{ route('profile.update-password') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-6">
                    <label for="current_password" class="block text-gray-300 text-sm font-bold mb-2">Password Saat Ini</label>
                    <div class="password-field">
                        <input type="password" name="current_password" id="current_password" 
                               class="shadow appearance-none border rounded-l w-full py-3 px-4 bg-gray-700 border-gray-600 text-white leading-tight focus:outline-none focus:border-blue-500 focus:ring-0"
                               required>
                        <button type="button" class="toggle-password eye-button border border-gray-600 text-gray-400 transition-colors focus:outline-none" data-target="current_password">
                            <i class="fas fa-eye text-lg"></i>
                        </button>
                    </div>
                    @error('current_password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <label for="password" class="block text-gray-300 text-sm font-bold mb-2">Password Baru</label>
                    <div class="password-field">
                        <input type="password" name="password" id="password" 
                               class="shadow appearance-none border rounded-l w-full py-3 px-4 bg-gray-700 border-gray-600 text-white leading-tight focus:outline-none focus:border-blue-500 focus:ring-0"
                               required>
                        <button type="button" class="toggle-password eye-button border border-gray-600 text-gray-400 transition-colors focus:outline-none" data-target="password">
                            <i class="fas fa-eye text-lg"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-gray-300 text-sm font-bold mb-2">Konfirmasi Password Baru</label>
                    <div class="password-field">
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               class="shadow appearance-none border rounded-l w-full py-3 px-4 bg-gray-700 border-gray-600 text-white leading-tight focus:outline-none focus:border-blue-500 focus:ring-0"
                               required>
                        <button type="button" class="toggle-password eye-button border border-gray-600 text-gray-400 transition-colors focus:outline-none" data-target="password_confirmation">
                            <i class="fas fa-eye text-lg"></i>
                        </button>
                    </div>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="bg-purple-600 text-white px-6 py-3 rounded-md hover:bg-purple-700 transition-colors font-medium">
                        <i class="fas fa-key mr-2"></i>Perbarui Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
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
    
    .eye-button {
        transition: all 0.2s ease;
        height: 48px;
        width: 48px;
        border-top-right-radius: 0.25rem;
        border-bottom-right-radius: 0.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-left: none;
        background-color: #374151;
        position: relative;
    }
    
    .eye-button:hover {
        background-color: #4B5563;
    }
    
    .eye-button:hover .fa-eye, 
    .eye-button:hover .fa-eye-slash {
        color: #93C5FD;
    }
</style>

@section('scripts')
<script>
    $(document).ready(function() {
        $('.toggle-password').on('click', function(e) {
            e.preventDefault();
            
            const target = $(this).data('target');
            const input = $('#' + target);
            
            // Toggle type attribute
            const type = input.attr('type') === 'password' ? 'text' : 'password';
            input.attr('type', type);
            
            // Toggle eye icon
            $(this).find('i').toggleClass('fa-eye fa-eye-slash');
            
            // Flash effect on icon
            $(this).find('i').addClass('text-blue-400');
            setTimeout(() => {
                $(this).find('i').removeClass('text-blue-400');
            }, 300);
            
            // Set focus back to input field
            input.focus();
        });
    });
</script>
@endsection
@endsection 