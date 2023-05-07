@extends('adminlte::page')
@section('title', 'Usuários - Editar')
@section('plugins.Select2', true)

@section('content')
@include('flash::message')
<br> 
<div class="container">
    <div class="card card-dark"  style="margin:auto;">
        <div class="card-header box_form">Usuários - Editar</div>
        <div class="card-body" >
        <form action="{{route('users.edit')}}" id="FormInventarioIPREM"  method="POST">
            @csrf
            <div class="form-group row">
                <div class="col">
                    <label>Usuário:</label>
                    <input autocomplete="off" type="text" class="form-control form-control-sm" name="username" id="username" value="{{old('username') ?? $user->username}}" tabindex="1" required>
                </div>
                <div class="col">
                    <label>Nome:</label>
                    <input autocomplete="off" type="text" class="form-control form-control-sm" name="name" id="name" value="{{old('name') ?? $user->name}}" tabindex="1" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col">
                    <label>Perfis:</label>
                    <select autocomplete="off" type="password" class="form-control form-control-sm" name="roles[]" multiple="multiple" id="roles" tabindex="1">
                        <option value="">&nbsp;</option>
                    @forelse($roles as $r)
                        
                        <option value="{{$r->name}}" {{in_array($r->name,$roles_user->toArray()) ? 'selected' : ''}}>{{$r->name}}</option>
                    @empty

                    @endforelse
                    </select>
                </div>

                <div class="col">
                    <label>Senha (Preencha para alterar):</label>
                    <input autocomplete="off" type="password" class="form-control form-control-sm" name="password" id="password" tabindex="1">
                </div>
            </div>

            <input type="hidden" name="id" value="{{$user->id}}">


                <div class="form-group text-center">
                <input type="submit" class="btn btn-sm btn-success text-center" value="Alterar" tabindex="3">
                <a href="{{route('users')}}" class="btn btn-sm btn-info">Voltar</a>
                </div>
        </form>
        </div>
    </div>
</div>

@stop

{{-- @section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop --}}

@section('js')
<script>

    $(document).ready(function() {
        $('#roles').select2();
    });
</script>
@stop