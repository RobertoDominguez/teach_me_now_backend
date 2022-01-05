@extends('admin.layouts.template')

@section('content')

    <body>
        <div class="row">
            <div class="col-12">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Agregar Publicacion</h3>
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

                        <form action="{{ route('admin.post.update',$post->id) }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Titulo (opcional):</strong>
                                        <input type="text" name="title" value="{{$post->title}}" maxlength="200" class="form-control">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Contenido (opcional):</strong>
                                        <textarea class="form-control" name="content" rows="20">{{$post->content}}</textarea>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Imagen (opcional):</strong>
                                        <input type="file" name="image" onchange="validarFile(this);" value=""
                                            maxlength="200" class="form-control">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success">Guardar</button>
                                        <a class="btn btn-primary" href="{{ route('admin.post.index',$post->cover_id) }}">Atras</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </body>

    <script>
        //Funcion de JS que valida el archivo ingresado al input. Formato y Tamaño.
        function validarFile(all) {
            //EXTENSIONES Y TAMANO PERMITIDO.
            var extensiones_permitidas = [".png", ".bmp", ".jpg", ".jpeg", ".gif"];
            var tamano = 8; // EXPRESADO EN MB.
            var rutayarchivo = all.value;
            var ultimo_punto = all.value.lastIndexOf(".");
            var extension = rutayarchivo.slice(ultimo_punto, rutayarchivo.length);
            if (extensiones_permitidas.indexOf(extension) == -1) {
                alert("Extensión de archivo no valida");
                document.getElementById(all.id).value = "";
                return; // Si la extension es no válida ya no chequeo lo de abajo.
            }
            if ((all.files[0].size / 1048576) > tamano) {
                alert("El archivo no puede superar los " + tamano + "MB");
                document.getElementById(all.id).value = "";
                return;
            }
        }
    </script>

@endsection
