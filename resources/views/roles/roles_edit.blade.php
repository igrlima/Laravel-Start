@extends('adminlte::page')
@section('title', 'Perfil - Editar')

@section('plugins.BootstrapDualListBox', true)
{{-- @extends('adminlte::auth.auth-page', ['auth_type' => 'register']) --}}

@section('content')
<br>
@include('flash::message')
<div class="container">
    <div class="card card-dark"  style="margin:auto;">
        <div class="card-header box_form">Perfil - Editar</div>
        <div class="card-body" >
            <form id="frm" action="{{ route('roles.edit') }}" method="post">
                @csrf
        
                {{-- Name field --}}
                <div class="input-group mb-3">
                    <input type="text" name="role" class="form-control" value="{{ old('role') ?? $role_permission[0]->name ?? ''}}" placeholder="Descrição Perfil" autofocus required>
                </div>
        
                {{-- Email field --}}
                <div class="input-group mb-3">
                    <select multiple="multiple" name="permissions[]">
                        @foreach($permissions as $p)
                            <option value="{{$p->id}}" {{in_array($p->id,$role_permission->pluck('permission_id')->toArray()) ? 'selected="selected"' :''}}>{{$p->description}}</option>
                        @endforeach
                      </select>
                </div>
                <input type="hidden" name="id" value="{{app('request')->input('id')}}">
        

                <div class="from-group text-center">
                    <button type="submit" class="btn {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
                        <span class="fas fa-save"></span> Salvar
                    </button>
                    <a href="{{route('roles')}}" class="btn btn-warning">
                        <span class="fas fa-undo"></span> Voltar</a>
                </div>
        
                {{-- Register button --}}
             
        
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