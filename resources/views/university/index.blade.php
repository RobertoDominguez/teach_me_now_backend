@extends('layouts.template')

@section('content')
<div class="card card-secondary">
    <div class="card-header">
        <h3 class="card-title">Universidades</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <div class="card-body">

        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Universidades</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>SIGLA</th>
                                <th>NOMBRE</th>
                                <th>IMAGEN</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($universities as $university)
                                <tr>
                                    <td>{{ $university->acronym }}</td>
                                    <td>{{ $university->name }}</td>
                                    <td>
                                        <img class="img-thumbnail mt-4" src="{{ asset('/storage/' . $university->image) }}"
                                        alt="post_image" style="width: 300px;">
                                    </td>
                                    <td>
                                        <form action="{{ route('university.destroy', $university->id) }}"
                                            method="post">
                                            {{ csrf_field() }}
                                            <a class="btn btn-primary"
                                                href="{{ route('university.edit', $university->id) }}">Editar</a>
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
        <a class="btn btn-warning" href="{{ route('university.create') }}">Agregar</a>
    </div>
</div>
@endsection
