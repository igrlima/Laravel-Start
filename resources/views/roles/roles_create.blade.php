@extends('adminlte::page')
@section('plugins.BootstrapDualListBox', true)
@section('title', 'Perfil - Cadastrar')

@section('content')
<br>
@include('flash::message')
<div class="container">
    <div class="card card-dark"  style="margin:auto;">
        <div class="card-header box_form">Perfil - Cadastrar</div>
        <div class="card-body" >
            <form id="frm" action="{{ route('roles.create') }}" method="post">
                @csrf
        
                {{-- Name field --}}
                <div class="input-group mb-3">
                    <input type="text" name="role" class="form-control" value="{{ old('role') }}" placeholder="Descrição Perfil" autofocus required>
    
                </div>
        
                {{-- Email field --}}
                <div class="input-group mb-3">
                    <select multiple="multiple" name="permissions[]">
                        @foreach($permissions as $p)
                            <option value="{{$p->id}}">{{$p->description}}</option>
                        @endforeach
                      </select>
                </div>
        

                <div class="from-group text-center">
                    <button type="submit" class="btn {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
                        <span class="fas fa-user-plus"></span> Cadastrar
                    </button>
                    <a href="{{route('roles')}}" class="btn btn-warning">
                        <span class="fas fa-undo"></span> Voltar</a>
                </div>
            </form>

        </div>
    </div>
</div>

@stop

@section('js')
<script>
    var demo1 = $('select[name="permissions[]"]').bootstrapDualListbox(
        {
            infoText: '{0} Permissões disponíveis',
            infoTextFiltered: '{0} Filtrado',
            infoTextEmpty: 'Sem Permissões disponíveis'
        }
    );
    $("#frm").submit(function() {
    });
</script>
@stop