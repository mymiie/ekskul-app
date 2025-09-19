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
        .forgot-card { animation: slideInFromTop 0.8s ease-out; }
        .forgot-form { animation: fadeIn 1.2s ease-out 0.3s both; }
        .logo-animate { animation: fadeIn 1s ease-out 0.5s both; }
    </style>
    
    <div class="row w-100 justify-content-center" style="position: relative; z-index: 2;">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow forgot-card" 
                 style="background-color: rgba(255, 255, 255, 0.75); backdrop-filter: blur(3px); border: 1px solid rgba(255, 255, 255, 0.3);">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <!-- Logo -->
                        <div class="mb-3 d-flex justify-content-center logo-animate">
                            <img src="{{ asset('images/logo1.png') }}" alt="Logo Sekolah" 
                                 class="img-fluid" style="max-width: 120px; height: auto;">
                        </div>
                        <h2 class="h3 fw-bold text-dark logo-animate">SMKN 1 DUKUHTURI</h2>
                        <p class="text-muted logo-animate">Masukkan email anda untuk reset password</p>
                    </div>

                    <!-- Alert sukses -->
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show forgot-form" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <form wire:submit.prevent="sendResetLink" class="forgot-form">
                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-medium">Email</label>
                            <input id="email" 
                                   type="email" 
                                   wire:model="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="nama@gmail.com" 
                                   autocomplete="email"
                                   required>
                            @error('email') 
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                        </div>

                        <!-- Loading indicator -->
                        <div wire:loading wire:target="sendResetLink" class="text-center mb-3">
                            <div class="text-primary">
                                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                Mengirim email...
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid mb-3">
                            <button type="submit" 
                                    class="btn btn-primary" 
                                    wire:loading.attr="disabled"
                                    wire:loading.class="opacity-50">
                                <span wire:loading.remove wire:target="sendResetLink">
                                    <i class="bi bi-envelope me-2"></i>Kirim Link Reset Password
                                </span>
                                <span wire:loading wire:target="sendResetLink">
                                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                    Mengirim...
                                </span>
                            </button>
                        </div>

                        <!-- Back to Login Link -->
                        <div class="text-center">
                            <p class="mb-0 text-muted">
                                Sudah ingat password? 
                                <a href="{{ route('login') }}" class="text-decoration-none">Kembali ke login</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>