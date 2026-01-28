@extends('layouts.app')
@section('title', 'Create Notification')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>إنشاء إعلام</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        <!-- @include('adminlte-templates::common.errors') -->

        <div class="card">

            {!! Form::open(['route' => 'notifications.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('notifications.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('notifications.index') }}" class="btn btn-default">الغاء</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@section('footerScript')
<script>
        $(window).on("load", function () {
            var cheackus = $("select[name='type']").val();
            // alert(cancel);
            $("select[name='type']").change(function() {
                if($(this).val() == 0) {
                    $("#user_phonediv").show(2000);
                } else {
                    $("#user_phonediv").hide(2000);
                }
            });
            // $("#user_phonediv").hide(2000);

        });
</script>
@endsection
@endsection
