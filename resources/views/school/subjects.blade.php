@extends('layouts.template')

@section('content')
    <form action="{{ route('school.subjects.update', $school->id) }}" method="POST">
        {{ csrf_field() }}
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Materias</h3>
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

                <div class="card mb-4">
                    <div class="card-header"><i class="fas fa-table mr-1"></i>Materias de {{ $school->name }}</div>
                    <div class="card-body">
                        <table class="table-responsive" id="detalles_table">
                            <tr id='row0'>
                            </tr>
                            @php
                                $id = 1;
                            @endphp
                            @foreach ($academics as $academic)
                                {{-- <tr id="row1"> --}}
                                <tr id={{ 'row' . $id }}>
                                    <td>
                                        <select class='form-select' disabled>
                                            <option value={{ $academic->id }}>{{ $academic->name }}</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input class='btn btn-danger' type='button' value='X'
                                            onclick="delete_row2({{ $id }},{{ $academic->subject_id }});">
                                    </td>
                                </tr>
                                @php
                                    $id = $id + 1;
                                @endphp
                            @endforeach
                        </table>
                        <input class="btn btn-primary" type="button" onclick="add_row();" value="+">

                        <table id="remove_detalles_table">
                            <tr id='rm_row0'>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button class="btn btn-warning">Guardar</button>
            </div>

        </div>
    </form>
@endsection


<script type="text/javascript">
    function add_row() {
        $rowno = $("#detalles_table tr").length;
        $rowno = $rowno + 1;

        var $row = "<tr id='row" + $rowno + "'> <td>" + "<select class='form-select' name='subjects_add[]'>";
        @foreach ($subjects as $subject)
            $row=$row+"<option value='"+' {{ $subject->id }}'+"'>"+'{{ $subject->name }}'+"</option>"
        @endforeach
        $row = $row + "</select></td>" +
            "<td><input class='btn btn-danger' type='button' value='X' onclick=delete_row('" + $rowno +
            "')></td></tr>";

        $("#detalles_table tr:last").after($row);
    }

    function delete_row(rowno) {
        $('#row' + rowno).remove();
    }

    function delete_row2(rowno, subject_id) {
        $rm_rowno = $("#remove_detalles_table tr").length;
        $rm_rowno = $rm_rowno + 1;

        $("#remove_detalles_table tr:last").after("<tr id='row" + $rm_rowno +
            "'><td><input type='text' name='subjects_remove[]' value=" + subject_id + " hidden>");
        $('#row' + rowno).remove();
    }
</script>
