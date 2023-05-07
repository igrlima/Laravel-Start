@extends('adminlte::page')
@section('title', 'Usuários')

@section('content_header')
    <div class="row">
        <div class="col">
            <h1 style="font-size:30px;">Usuários Cadastrados: {{count($users)}}</h1>
        </div>
        @can('users.create')
        <div class="col text-right">
            <a href="{{route('users.create')}}" class="btn btn-success">Cadastrar Usuário</a>
        </div>
        @endcan
    </div>
@stop
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('content')
@include('flash::message')
<div class="table-responsive-lg">
    <table id="example2" class="table table-sm table-bordered table-striped" aria-describedby="example2_info">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Usuário</th>
            <th>Nome</th>
            <th>Perfis</th>
            <th>Data Criação</th>
            <th>Ação</th>
        </thead>
        <tbody>
        @forelse($users as $u)
        <tr>
            <td>{{$u->id}}</td>
            <td>{{$u->username}}</td>
            <td>{{$u->name}}</td>
            <td>
                @php 
                    $u->roles = explode(',',$u->roles);
                @endphp
            @foreach($u->roles as $ur)
                <span class="badge btn-primary"">{{$ur}}</span>
            @endforeach
            </td>
            <td>{{date('d/m/Y H:i',strtotime($u->created_at))}}</td>
            <td>
                @if($u->username <> 'admin')
                    @can('users.edit')
                        <a href="users/edit?id={{$u->id}}" type="button" href=""><i class="fa fa-edit"></i></a>
                        &nbsp;&nbsp;&nbsp;
                    @endcan
                    
                    @can('users.destroy')
                        <a type="button" onclick="trash({{$u->id}});"><i class="fa fa-trash"></i></button>
                    @endcan
                @endif
            </td>
        </tr>
        @empty

        @endforelse
    </tbody>
        <tfoot>
        {{-- <tr><th rowspan="1" colspan="1">Rendering engine</th><th rowspan="1" colspan="1">Browser</th><th rowspan="1" colspan="1">Platform(s)</th><th rowspan="1" colspan="1">Engine version</th><th rowspan="1" colspan="1">CSS grade</th></tr> --}}
        </tfoot>
    </table>
</div>
@stop

{{-- @section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop --}}

@section('js')
<script>

    function trash (id)
    {
        Swal.fire({
        icon: 'error',
        title: 'Deseja realmente excluir?',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sim',
        reverseButtons: true
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.value) {
            window.location.href = document.URL+"/destroy?id="+id;
        } else {
        }
        })

     
    }

    $(function () {
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json"
        }
      });
    });
  </script>
@stop