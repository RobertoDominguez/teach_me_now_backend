@extends('layouts.template')

@section('content')
    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">Todas las Suscripciones</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <div class="card-body">

            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-table mr-1"></i>Suscripciones</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>USUARIO</th>
                                    <th>FECHA</th>
                                    <th>ESTADO</th>
                                    <th>TOTAL</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($subscriptions as $subscription)
                                    <tr>
                                        <td>{{ $subscription->id }}</td>
                                        <td>{{ $subscription->name }}</td>
                                        <td>{{ $subscription->created_at }}</td>

                                        <td>
                                            @if (!$subscription->accepted && !$subscription->rejected)
                                                <div class="col">
                                                    <div class="form-group btn btn-primary">
                                                        <strong>En espera</strong>
                                                    </div>
                                                </div>
                                            @else

                                                @if ($subscription->accepted)
                                                    <div class="col">
                                                        <div class="form-group btn btn-success">
                                                            <strong>Aceptado</strong>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if ($subscription->rejected)
                                                    <div class="col">
                                                        <div class="form-group btn btn-danger">
                                                            <strong>Rechazado</strong>
                                                        </div>
                                                    </div>
                                                @endif

                                            @endif


                                        </td>

                                        <td>{{ $subscription->total }}</td>
                                        <td>
                                            <a class="btn btn-primary"
                                                href="{{ route('subscription.show', $subscription->id) }}">
                                                Detalles
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
