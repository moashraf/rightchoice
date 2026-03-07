@extends('layouts.admin')
@section('title', 'Complaints')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>الشكاوى</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('flash::message')

        {{-- Filter Form --}}
        <div class="card mb-3">
            <div class="card-body">
                <form id="filter-form" class="form-inline flex-wrap" style="gap:10px;">
                    <div class="form-group mr-2 mb-2">
                        <label class="mr-1 ml-1">المستخدم:</label>
                        <select name="user_id" id="filter_user_id" class="form-control">
                            <option value="">-- الكل --</option>
                            @foreach($users as $id => $name)
                                <option value="{{ $id }}" {{ request('user_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mr-2 mb-2">
                        <label class="mr-1 ml-1">الحالة:</label>
                        <select name="status" id="filter_status" class="form-control">
                            <option value="">-- الكل --</option>
                            @foreach($statuses as $val => $label)
                                <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <button type="submit" class="btn btn-primary mr-1">
                            <i class="fa fa-filter"></i> فلترة
                        </button>
                        <button type="button" id="reset-filter" class="btn btn-secondary">
                            <i class="fa fa-times"></i> إعادة تعيين
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-0">
                @include('admin_complaints.table')
            </div>
        </div>
    </div>
@endsection

@push('page_scripts')
<script>
    $(document).ready(function () {
        $('#filter-form').on('submit', function (e) {
            e.preventDefault();
            window.LaravelDataTables['complaints-table'].ajax.reload();
        });

        $('#reset-filter').on('click', function () {
            $('#filter_user_id').val('');
            $('#filter_status').val('');
            window.LaravelDataTables['complaints-table'].ajax.reload();
        });
    });
</script>
@endpush

