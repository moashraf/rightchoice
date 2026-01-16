@extends('layouts.app')
@section('title', 'Edit Complaints')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>تحرير الشكاوى</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        <!-- @include('adminlte-templates::common.errors') -->

        <div class="card">

            {!! Form::model($complaints, ['route' => ['complaints.update', $complaints->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row align-items-end">

                    @include('complaints.fields')



                </div>


            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('complaints.index') }}" class="btn btn-default">الغاء</a>
            </div>

           {!! Form::close() !!}

        </div>
    </div>
@endsection

@section('footerScript')
    <script>
        $(document).ready(function () {
            $('#status_select').each(function () {
                if($(this).val() == 3)
                    $('#send_email').show()
                else
                    $('#send_email').hide()
            });
            $('#status_select').on('change',function () {
                if($(this).val() == 3)
                    $('#send_email').show()
                else
                    $('#send_email').hide()
            });
        });
    </script>
@endsection
