@extends('layouts.app')
@section('title', 'Edit Complaints')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Edit Complaints</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        <!-- @include('adminlte-templates::common.errors') -->

        <div class="card">

            {!! Form::model($complaints, ['route' => ['complaints.update', $complaints->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                   
                    @include('complaints.fields')
                    
                    
                     
                </div>
                <div class="col-lg-4">
                        <label>Time:</label>
                        <br/>
                        <input disabled value="{{ $complaints->created_at }}" />
                    </div>
                
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('complaints.index') }}" class="btn btn-default">Cancel</a>
            </div>

           {!! Form::close() !!}

        </div>
    </div>
@endsection
