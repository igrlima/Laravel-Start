@extends('adminlte::page')
@section('title', 'Perfis')

@section('content_header')
    <div class="row">
        <div class="col">
            <h1 style="font-size:30px;">Perfis Cadastrados: {{count($roles)}}</h1>
        </div>
        <div class="col text-right">
            @can('roles.create')
                <a href="{{route('roles.create')}}" class="btn btn-success">Cadastrar Perfil</a>
            @endcan
        </div>
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
            <th>Perfil</th>
            <th>Quantidade de Usuários</th>
            <th>Data Criação</th>
            <th>Ação</th>
        </thead>
        <tbody>
        @forelse($roles as $r)
        <tr>
            <td>{{$r->id}}</td>
            <td>{{$r->name}}</td>
            <td>{{$r->qtd_users}}</td>
            <td>{{date('d/m/Y H:i',strtotime($r->created_at))}}</td>
            <td>
                @if($r->name <> 'admin')
                    @can('roles.edit')
                        <a href="roles/edit?id={{$r->id}}" type="button" href=""><i class="fa fa-edit"></i></a>
                    @endcan
                    &nbsp;&nbsp;&nbsp;
                    @can('roles.destroy')
                        <a type="button" onclick="trash({{$r->id}});"><i class="fa fa-trash"></i></button>
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
        reverseButtons: false
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            window.location.href = document.URL+"/destroy?id="+id;
        } else if (result.isDenied) {
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
            "url": "js/pt-BR.json"
        }
      });
    });
  </script>
@stop