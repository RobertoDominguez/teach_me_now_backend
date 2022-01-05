@extends('admin.layouts.template')

@section('content')

    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">Publicacion </h3>
            <h4 class="card-title">Articulo: {{$cover->title}}</h4>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <div class="card-body">

            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-table mr-1"></i>Publicacion</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Titulo</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($posts as $post)
                                    <tr>
                                        <td>{{ $post->title }}</td>
                                        <td>
                                            <form action="{{ route('admin.post.destroy', $post->id) }}"
                                                method="post">
                                                {{ csrf_field() }}
                                                <a class="btn btn-primary"
                                                    href="{{ route('admin.post.edit', $post->id) }}">Editar</a>
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </form>
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
            <a class="btn btn-warning" href="{{ route('admin.post.create',$cover->id) }}">Agregar</a>
            <a class="btn btn-primary" href="{{ route('admin.cover.index') }}">Atras</a>
        </div>
    </div>

@endsection
