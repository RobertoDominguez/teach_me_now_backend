@extends('layouts.template')

@section('content')
    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">Suscripciones entrantes</h3>
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
                                    <th>Comprobante</th>
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
                                            <img class="img-thumbnail mt-4"
                                                src="{{ asset('/storage/' . $subscription->image) }}" alt="post_image"
                                                style="height: 400px;">
                                        </td>
                                        <td>{{ $subscription->total }}</td>
                                        <td>
                                            <div class="row">
                                                <div class="col">

                                                    <a class="btn btn-primary"
                                                        href="{{ route('subscription.show', $subscription->id) }}">
                                                        Detalles
                                                    </a>
                                                </div>
                                                <div class="col">
                                                    <form action="{{ route('subscription.accept', $subscription->id) }}"
                                                        method="post">
                                                        {{ csrf_field() }}
                                                        <button type="submit" class="btn btn-success">Aceptar</button>
                                                    </form>
                                                </div>
                                                <div class="col">
                                                    <form action="{{ route('subscription.reject', $subscription->id) }}"
                                                        method="post">
                                                        {{ csrf_field() }}
                                                        <button type="submit" class="btn btn-danger">Rechazar</button>
                                                    </form>
                                                </div>
                                            </div>
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
