@extends('admin.layouts.template')

@section('content')

    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">Articulos</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <div class="card-body">

            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-table mr-1"></i>Articulos</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Titulo</th>
                                    <th>Autor</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($covers as $cover)
                                    <tr>
                                        <td>{{ $cover->title }}</td>
                                        <td>{{ $cover->author }}</td>
                                        <td>
                                            <form action="{{ route('admin.cover.destroy', $cover->id) }}"
                                                method="post">
                                                {{ csrf_field() }}
                                                <a class="btn btn-primary"
                                                    href="{{ route('admin.cover.edit', $cover->id) }}">Editar</a>
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </form>
                                        </td>
                                        <td>
                                            <a class="btn btn-primary"
                                                        href="{{ route('admin.post.index', $cover->id) }}">Publicaciones del articulo</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <a class="btn btn-warning" href="{{ route('admin.cover.create') }}">Agregar</a>
        </div>
    </div>

@endsection
