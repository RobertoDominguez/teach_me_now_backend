@extends('layouts.template')

@section('content')

    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">Detalle Usuario</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> Verifica los datos.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>ID:</strong>
                        <input type="text" name="id" value="{{ $teacher->id }}" class="form-control" readonly>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Imagen:</strong>
                        <img class="img-thumbnail mt-4" src="{{ asset('/storage/' . $teacher->image) }}" alt="post_image"
                            style="height: 400px;">
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Nombre:</strong>
                        <input type="text" name="quantity" value="{{ $teacher->name }}" class="form-control" readonly>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Email:</strong>
                        <input type="text" name="total" value="{{ $teacher->email }}" class="form-control" readonly>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Telefono:</strong>
                        <input type="text" name="created_at" value="{{ $teacher->phone }}" maxlength="6"
                            class="form-control" readonly>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Fecha creacion:</strong>
                        <input type="text" name="created_at" value="{{ $teacher->created_at }}" class="form-control"
                            readonly>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Precio:</strong>
                        <input type="text" name="days" value="{{ $teacher->price }}" class="form-control" readonly>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Imagen QR:</strong>
                        <img class="img-thumbnail mt-4" src="{{ asset('/storage/' . $teacher->qr_code) }}"
                            alt="post_image" style="height: 200px;">
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Universidad:</strong>
                        @if (!is_null($university))
                            <input type="text" name="days" value="{{ $university->name }}" class="form-control"
                                readonly>
                        @else
                            <input type="text" name="days" value="NINGUNA" class="form-control" readonly>
                        @endif

                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Materias:</strong>

                        @foreach ($subjects as $subject)
                            <div class="row">
                                <div class="col-xs-2 col-sm-2 col-md-2">
                                    <div class="form-group btn btn-success">
                                        <strong>{{ $subject->name.' - Nivel: '.$subject->level }}</strong>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Facultades:</strong>

                        @foreach ($schools as $school)
                            <div class="row">
                                <div class="col-xs-2 col-sm-2 col-md-2">
                                    <div class="form-group btn btn-primary">
                                        <strong>{{ $school->name }}</strong>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>

            </div>

        </div>
        <!-- /.card-body -->
    </div>

@endsection
