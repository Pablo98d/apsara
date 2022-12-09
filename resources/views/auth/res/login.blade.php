@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-4 col-sm-12">
            <form class="card auth_form" style="background-color: blush;" method="POST" action="{{ route('login') }}">
                @csrf
                <div>
                    @if ( session('Error') )
                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('Error') }}
                        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true"></span>
                        </button>
                      </div>
                    @endif
                </div>
                <div class="header">
                    <img src="{{asset('assets/images/lf/logoNombre.png')}}"  alt="LaFeriecita">
                    <h5>Iniciar Sesión</h5>
                </div>
                <div class="body">
                    <div class="input-group mb-3">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Correo Electrónico">
                        <div class="input-group-append">
                            {{-- @error('email') --}}
                            <span class="input-group-text" role="alert"><i class="zmdi zmdi-account-circle">
                                {{-- <strong>{{$message}}</strong> --}}
                            </i></span>
                            {{-- @enderror --}}
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{old('password')}}" placeholder="Contraseña">
                        <div class="input-group-append">
                        {{-- @error('password')            --}}
                            <span class="input-group-text" role="alert"><i class="zmdi zmdi-lock">
                                {{-- <strong>{{ $message }}</strong> --}}
                            </i></span>
                        {{-- @enderror --}}
                        </div>                            
                    </div>
                    <div class="checkbox">
                        <input id="remember_me" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember_me">{{ __('Recordarme') }}</label>
                    </div>
    
                    <div class="form-group" style="center">
                        <div  align="center">
                            <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">
                            {{ __('Login') }}
                            </button>
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('¿Olvidaste tu contraseña?') }}
                                </a>
                            @endif
                        </div>
                    </div>                        
                    {{-- <div class="signin_with mt-3">
                        <p class="mb-0">o Regístrate usando</p>
                        <button class="btn btn-primary btn-icon btn-icon-mini btn-round facebook"><i class="zmdi zmdi-facebook"></i></button>
                        <button class="btn btn-primary btn-icon btn-icon-mini btn-round twitter"><i class="zmdi zmdi-twitter"></i></button>
                        <button class="btn btn-primary btn-icon btn-icon-mini btn-round google"><i class="zmdi zmdi-google-plus"></i></button>
                    </div> --}}
                </div>
            </form>
            <div class="copyright text-center">
                &copy;
                <script>document.write(new Date().getFullYear())</script>,
                <span>Diseñado por <a href="http://pice-software.com/" target="_blank">Pice Software</a></span>
            </div>
        </div>
        <div class="col-lg-8 col-sm-12">
            <div class="card">
                <img src="{{asset('assets/images/signin.svg')}}" alt="Sign In"/>
            </div>
        </div>
    </div>
</div>
@endsection
