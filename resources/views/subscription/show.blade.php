@extends('layouts.template')

@section('content')

    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">Detalle suscripcion</h3>
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
                        <input type="text" name="id" value="{{ $subscription->id }}" class="form-control"
                            readonly>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Recibo:</strong>
                        <img class="img-thumbnail mt-4" src="{{ asset('/storage/' . $subscription->image) }}"
                            alt="post_image" style="height: 400px;">
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Cantidad:</strong>
                        <input type="text" name="quantity" value="{{ $subscription->quantity }}" 
                            class="form-control" readonly>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Total:</strong>
                        <input type="text" name="total" value="{{ $subscription->total }}" 
                            class="form-control" readonly>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Fecha creacion:</strong>
                        <input type="text" name="created_at" value="{{ $subscription->created_at }}" 
                            class="form-control" readonly>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Dias:</strong>
                        <input type="text" name="days" value="{{ $subscription->days }}" 
                            class="form-control" readonly>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Dias extra:</strong>
                        <input type="text" name="extra days" value="{{ $subscription->extra_days }}" 
                            class="form-control" readonly>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Fecha finalizacion:</strong>
                        <input type="text" name="end_date" value="{{ $subscription->end_date }}" 
                            class="form-control" readonly>
                    </div>
                </div>

                <div class="col-xs-2 col-sm-2 col-md-2">
                    <div class="form-group">
                        <a class="btn btn-primary"
                            href="{{ route('subscription.teacher.show', $subscription->teacher_id) }}">Ver Usuario</a>
                    </div>
                </div>

                @if (!$subscription->accepted && !$subscription->rejected)

                    <div class="col-xs-2 col-sm-2 col-md-2">
                        <div class="form-group">
                            <form action="{{ route('subscription.accept', $subscription->id) }}" method="POST"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-success">Aceptar</button>
                            </form>
                        </div>
                    </div>

                    <div class="col-xs-2 col-sm-2 col-md-2">
                        <div class="form-group">
                            <form action="{{ route('subscription.accept', $subscription->id) }}" method="POST"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger">Rechazar</button>
                            </form>
                        </div>
                    </div>
                @else

                    @if ($subscription->accepted)
                        <div class="col-xs-2 col-sm-2 col-md-2">
                            <div class="form-group btn btn-success">
                                <strong>Aceptado</strong>
                            </div>
                        </div>
                    @endif

                    @if ($subscription->rejected)
                        <div class="col-xs-2 col-sm-2 col-md-2">
                            <div class="form-group btn btn-danger">
                                <strong>Rechazado</strong>
                            </div>
                        </div>
                    @endif

                @endif



            </div>

        </div>
        <!-- /.card-body -->
    </div>

@endsection
