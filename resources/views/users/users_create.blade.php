@extends('adminlte::page')
@section('title', 'Usuário - Cadastrar')
{{-- @extends('adminlte::auth.auth-page', ['auth_type' => 'register']) --}}

@section('auth_header', __('adminlte::adminlte.register_message'))

@section('content')
@include('flash::message')
<br>
<div class="container">
    <div class="card card-dark"  style="margin:auto;">
        <div class="card-header box_form">Usuários - Cadastrar</div>
        <div class="card-body" >
            <form action="{{ route('users.create') }}" method="post">
                @csrf
        
                {{-- Name field --}}
                <div class="input-group mb-3">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" placeholder="{{ __('adminlte::adminlte.full_name') }}" autofocus>
        
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>
        
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
        
                {{-- Email field --}}
                <div class="input-group mb-3">
                    {{-- <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}"> --}}
                           <input type="username" name="username" class="form-control @error('username') is-invalid @enderror"
                           value="{{ old('username') }}" placeholder="{{ __('adminlte::adminlte.username') }}">
        
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>
        
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
        
                {{-- Password field --}}
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                           placeholder="{{ __('adminlte::adminlte.password') }}">
        
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>
        
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
        
        
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-sm {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
                        <span class="fas fa-user-plus"></span>
                        {{ __('adminlte::adminlte.register') }}
                    </button>

                    <a class="btn btn-flat btn-sm btn-warning" href="{{route('users')}}">
                        <i class="fa fa-undo"></i>
                        Voltar</a>
                </div>
                {{-- Register button --}}
             
        
            </form>
        </div>
    </div>
</div>

@stop
