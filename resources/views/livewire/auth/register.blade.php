<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Mendefinisikan aturan validasi dalam sebuah method.
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ];
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate();

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        // Arahkan berdasarkan role user
        if ($user->role === 'admin') {
            $this->redirect(route('admin.dashboard'), navigate: true);
        } elseif ($user->role === 'guru') {
            $this->redirect(route('guru.dashboard'), navigate: true);
        } else {
            $this->redirect(route('user.dashboard'), navigate: true);
        }
    }
}; ?>

<div class="container-fluid vh-100 d-flex align-items-center justify-content-center" style="background-image: url('{{ asset('images/bg1.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; position: relative;">
    <!-- Overlay untuk mempergelap background -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.5); z-index: 1;"></div>
    
    <!-- CSS Animations -->
    <style>
        @keyframes slideInFromTop {
            0% {
                transform: translateY(-50px);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
        
        .register-card {
            animation: slideInFromTop 0.8s ease-out;
        }
        
        .register-form {
            animation: fadeIn 1.2s ease-out 0.3s both;
        }
        
        .logo-animate {
            animation: fadeIn 1s ease-out 0.5s both;
        }
    </style>
    
    <div class="row w-100 justify-content-center" style="position: relative; z-index: 2;">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow register-card" style="background-color: rgba(255, 255, 255, 0.75); backdrop-filter: blur(3px); border: 1px solid rgba(255, 255, 255, 0.3);">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <!-- Logo Sekolah -->
                        <div class="mb-3 d-flex justify-content-center logo-animate">
                            <img 
                                src="{{ asset('images/logo1.png') }}" 
                                alt="Logo Sekolah" 
                                class="img-fluid"
                                style="max-width: 120px; height: auto;"
                            >
                        </div>
                        
                        <h2 class="h3 fw-bold text-dark logo-animate">Buat Akun Baru</h2>
                        <p class="text-muted logo-animate">Silakan isi data diri untuk mendaftar</p>
                    </div>
                    
                    <form wire:submit="register" class="register-form">
                        
                        <!-- Name Field -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-medium">Nama Lengkap</label>
                            <input 
                                id="name"
                                type="text" 
                                wire:model.blur="name"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Masukkan nama lengkap"
                                autocomplete="name"
                                required
                            >
                            @error('name') 
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-medium">Email</label>
                            <input 
                                id="email"
                                type="email" 
                                wire:model.blur="email"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="nama@email.com"
                                autocomplete="email"
                                required
                            >
                            @error('email') 
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-medium">Password</label>
                            <input 
                                id="password"
                                type="password" 
                                wire:model.blur="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Masukkan password"
                                autocomplete="new-password"
                                required
                            >
                            @error('password') 
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-medium">Konfirmasi Password</label>
                            <input 
                                id="password_confirmation"
                                type="password" 
                                wire:model.blur="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                placeholder="Ulangi password"
                                autocomplete="new-password"
                                required
                            >
                            @error('password_confirmation') 
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button 
                                type="submit"
                                class="btn btn-primary"
                                wire:loading.attr="disabled"
                            >
                                <span wire:loading.remove>Daftar</span>
                                <span wire:loading>
                                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                    Loading...
                                </span>
                            </button>
                        </div>

                        <!-- Login Link -->
                        <div class="text-center mt-3">
                            <p class="mb-0 text-muted">
                                Sudah punya akun? 
                                <a href="{{ route('login') }}" wire:navigate class="text-decoration-none">Masuk sekarang</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>