@extends('adminlte::page')
@section('title', 'Alterar Senha')

@section('content')
@include('flash::message')
<div class="container">
    <div class="card card-dark"  style="margin:auto;">
        <div class="card-header box_form">Alterar Senha</div>
        <div class="card-body" >
        <form action="{{route('password')}}" method="POST">
            @csrf
            <div class="form-group row">
                <div class="col">
                    <label>Senha Atual:</label>
                    <input autofocus autocomplete="off" type="password" class="form-control form-control-sm" name="old" id="old" value="{{old('old')}}" tabindex="1" required>
                </div>
            </div>

            <div class="form-group row">
                <div class="col">
                    <label>Senha Nova:</label>
                    <input autocomplete="off" minlength="6" type="password" class="form-control form-control-sm" name="new" id="new" value="{{old('new')}}" tabindex="1" required>
                </div>
                <div class="col">
                    <label>Repita a Senha:</label>
                    <input autocomplete="off" minlength="6" type="password" class="form-control form-control-sm" name="new2" id="new2" value="{{old('new2')}}" tabindex="1" required>
                </div>
            </div>
            </div>

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