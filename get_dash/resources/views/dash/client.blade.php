@extends('layouts.dash')
@section('content')
    @include('dash.client.modal')
    <div id="content-wrapper">
        <div class="container-fluid">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    Painel de controle
                </li>
                <li class="breadcrumb-item active">Clientes</li>
            </ol>

            <div class="card mb-3">
                <div class="card-header" style="display:flex; justify-content: space-around;">
                    <div>
                        <i class="fas fa-table"></i>
                        Tabela de clientes
                    </div>
                    <div>
                        <a href="/client/add" class="btn btn-outline-success">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                    <form action="/search/client" method="POST" style="max-widht:150px;">
                        <div class="input-group mb-3">
                            @csrf
                            <input placeholder="Buscar por..." name="name" type="text" class="form-control" aria-label="Buscar por...">
                            <div class="input-group-append">
                                <button type="submit" class="input-group-text">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    @if(array_key_exists('success', $_GET) && $_GET['success'] == 'true')
                        <div class="my-2">
                            <div class="alert alert-success">
                                Cliente criado com sucesso!
                            </div>
                        </div>
                        @elseif(array_key_exists('success', $_GET) && $_GET['success'] == '2')
                        <div class="my-2">
                            <div class="alert alert-success">
                                Cliente excluído  com secesso!
                            </div>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Telefone</th>
                                    <th>Endereço</th>
                                    <th>CPF/CNPJ</th>
                                    <th>Tipo</th>
                                    <th>Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($clients as $item)
                                    <tr>
                                        <td title="{{$item->id}}"">{{$item->id}}</td>
                                        <td title="{{$item->name}}">
                                            <a href="/client/{{$item->id}}">{{$item->name}}</a>
                                        </td>
                                        <td title="{{$item->phone_a}}">{{$item->phone_a}}</td>
                                        <td title="{{$item->address}}">{{$item->address}}</td>
                                        <td title="{{$item->cpf_cnpj}}">{{$item->cpf_cnpj}}</td>
                                        <td title="{{$item->type()}}">{{$item->type()}}</td>
                                        <td class="dropdown">
                                            <button
                                                id="drop-menu-{{$item->id}}"
                                                data-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false"
                                                class="btn btn-outline-info dropdown-toggle"
                                            >
                                                <i class="fa fa-user-cog"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="drop-menu-{{$item->id}}">
                                                <a class="dropdown-item" href="/client/{{$item->id}}">
                                                    <i class="fa fa-eye"></i>
                                                    Ver Mais
                                                </a>
                                                <button onclick="callDelete({{$item->id}})" class="dropdown-item text-danger">
                                                    <i class="far fa-trash-alt"></i>
                                                    Deletar
                                                </button>
                                                <a class="dropdown-item text-success" href="/veiculo/add/{{$item->id}}">
                                                    <i class="fa fa-plus"></i>
                                                    Adicionar Veículo
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7">
                                                <span>Nenhum cliente encontrado</span>
                                            </td>
                                        </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @if ($clients instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            {{ $clients->links() }}
                        @endif
                        
                    </div>
                </div>
                <div class="card-footer small text-muted">Ultimo update {{date('d/m/Y')}}</div>
            </div>
        </div>
        <footer class="sticky-footer">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright © {{config('app.name')}} {{date('Y', time())}}</span>
                </div>
            </div>
        </footer>
    </div>
@endsection
@section('script')
<script>
    var curId;
    function callDelete(id){
        curId = id;
        $('#modal').modal('show');
        console.log(curId)
    }
    $('#modal').on('hidden.bs.modal', function (e) {
        curId = null;
        console.log(curId)
    });
    function deleteClient(){
        console.log('called delete for:' + curId);
        window.location.replace('/client/delete/'+curId);
    }
</script>
@endsection
