    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mb-5">
                        <a href="{{ url('/') }}" class="logo"><img src="{{ asset('logo') }}/Primary Logo -- Welcome page, Login Page.png" width="150px;"></a>
                        <h5 class="font-size-16 text-black-50 mb-4">De Orange Cafe</h5>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row justify-content-center">
                <div class="col-xl-5 col-sm-8">
                    <div class="card shadow-lg">
                        <div class="card-body p-4">
                            <div class="p-2">
                                <h5 class="mb-5 text-center">Sign in to continue</h5>
                                <form class="form-horizontal" wire:submit.prevent="store">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if (session()->has('error'))
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Failed !!</strong> {{ session('error') }}
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            @endif
                                            <div class="form-group form-group-custom mb-4">
                                                <input type="text" placeholder="Email..." class="form-control" wire:model="email">
                                                <label for="email">Email</label>
                                                @error('email') <span class="error">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="form-group form-group-custom mb-4">
                                                <input type="password" class="form-control" wire:model="password" placeholder="Password...">
                                                <label for="userpassword">Password</label>
                                                @error('password') <span class="error">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" wire:model="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                
                                                    <label class="form-check-label" for="remember">
                                                        {{ __('Remember Me') }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <button type="submit" wire:click="store" class="btn btn-success btn-block waves-effect waves-light">Log In</button>
                                            </div>
                                            {{-- <div class="mt-4 text-center">
                                                <a href="auth-register.html" class="text-muted"><i class="mdi mdi-account-circle mr-1"></i> Create an account</a>
                                            </div> --}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
    </div>