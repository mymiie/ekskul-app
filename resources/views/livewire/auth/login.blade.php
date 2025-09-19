<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; ?>

<div class="container-fluid vh-100 d-flex align-items-center justify-content-center" 
     style="background-image: url('{{ asset('images/bg1.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; position: relative;">
    <!-- Overlay -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.5); z-index: 1;"></div>
    
    <!-- CSS Animations -->
    <style>
        @keyframes slideInFromTop {
            0% { transform: translateY(-50px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        .login-card { animation: slideInFromTop 0.8s ease-out; }
        .login-form { animation: fadeIn 1.2s ease-out 0.3s both; }
        .logo-animate { animation: fadeIn 1s ease-out 0.5s both; }
    </style>
    
    <div class="row w-100 justify-content-center" style="position: relative; z-index: 2;">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow login-card" 
                 style="background-color: rgba(255, 255, 255, 0.75); backdrop-filter: blur(3px); border: 1px solid rgba(255, 255, 255, 0.3);">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <!-- Logo -->
                        <div class="mb-3 d-flex justify-content-center logo-animate">
                            <img src="{{ asset('images/logo1.png') }}" alt="Logo Sekolah" 
                                 class="img-fluid" style="max-width: 120px; height: auto;">
                        </div>
                        <h2 class="h3 fw-bold text-dark logo-animate">SMKN 1 DUKUHTURI</h2>
                        <p class="text-muted logo-animate">Silakan masukkan email dan password anda</p>
                    </div>
                    
                    <form wire:submit="login" class="login-form">
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-medium">Email</label>
                            <input id="email" type="email" wire:model.blur="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="nama@gmail.com" autocomplete="email">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-medium">Password</label>
                            <input id="password" type="password" wire:model.blur="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Masukkan password" autocomplete="current-password">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Remember Me + Forgot Password -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" wire:model="remember">
                                <label class="form-check-label" for="remember">Ingat saya</label>
                            </div>
                            <a href="{{ route('password.request') }}" class="text-decoration-none">Lupa password?</a>
                        </div>

                        <!-- Login Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                <span wire:loading.remove>Masuk</span>
                                <span wire:loading>
                                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                    Loading...
                                </span>
                            </button>
                        </div>

                        <!-- Register Link -->
                        <div class="text-center mt-3">
                            <p class="mb-0 text-muted">
                                Belum punya akun? 
                                <a href="{{ route('register') }}" wire:navigate class="text-decoration-none">Daftar sekarang</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>