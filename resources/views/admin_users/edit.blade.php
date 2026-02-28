@extends('layouts.admin')
@section('title', 'تعديل مستخدم')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>تعديل مستخدم</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <form action="{{ route('sitemanagement.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="row">

                        <!-- Name Field -->
                        <div class="form-group col-sm-4">
                            <label for="name">Name: <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                            <small class="text-danger">{{ $errors->first('name') }}</small>
                        </div>

                        <!-- Email Field -->
                        <div class="form-group col-sm-4">
                            <label for="email">Email: <span class="text-danger">*</span></label>
                            <input type="text" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                            <small class="text-danger">{{ $errors->first('email') }}</small>
                        </div>

                        <!-- Mobile Number Field -->
                        <div class="form-group col-sm-4">
                            <label for="MOP">Mobile Number: <span class="text-danger">*</span></label>
                            <input type="number" name="MOP" class="form-control" value="{{ old('MOP', $user->MOP) }}">
                            <small class="text-danger">{{ $errors->first('MOP') }}</small>
                        </div>

                        <!-- Created At Field -->
                        <div class="form-group col-sm-4">
                            <label for="created_at">Created:</label>
                            <input type="text" name="created_at" class="form-control" value="{{ old('created_at', $user->created_at) }}" readonly>
                        </div>

                        <!-- Points Field -->
                        <div class="form-group col-sm-4">
                            <label for="current_points">Point:</label>
                            <input type="text" name="current_points" class="form-control"
                                   value="{{ old('current_points', (isset($all_point_of_user) && $all_point_of_user) ? $all_point_of_user->current_points : 1) }}">
                            <small class="text-danger">{{ $errors->first('current_points') }}</small>
                        </div>

                        <!-- SMS Status Field -->
                        <div class="form-group col-sm-4">
                            <label for="phone_verfied_sms_status">Status SMS:</label>
                            <input type="text" name="phone_verfied_sms_status" class="form-control" value="{{ old('phone_verfied_sms_status', $user->phone_verfied_sms_status) }}">
                            <small class="text-danger">{{ $errors->first('phone_verfied_sms_status') }}</small>
                        </div>

                        <!-- OTP Code Field -->
                        <div class="form-group col-sm-4">
                            <label for="phone_sms_otp">Code OTP:</label>
                            <input type="text" name="phone_sms_otp" class="form-control" value="{{ old('phone_sms_otp', $user->phone_sms_otp) }}">
                            <small class="text-danger">{{ $errors->first('phone_sms_otp') }}</small>
                        </div>

                        <!-- Type Field -->
                        <div class="form-group col-sm-4">
                            <label for="TYPE">Type Of User <span class="text-danger">*</span></label>
                            <select name="TYPE" class="form-control custom-select">
                                <option value="1" {{ old('TYPE', $user->TYPE) == 1 ? 'selected' : '' }}>بائع او مؤجر</option>
                                <option value="2" {{ old('TYPE', $user->TYPE) == 2 ? 'selected' : '' }}>مشتري أو مستأجر</option>
                                <option value="3" {{ old('TYPE', $user->TYPE) == 3 ? 'selected' : '' }}>مطور عقاري</option>
                                <option value="4" {{ old('TYPE', $user->TYPE) == 4 ? 'selected' : '' }}>شركة</option>
                            </select>
                            <small class="text-danger">{{ $errors->first('TYPE') }}</small>
                        </div>

                        <!-- Age Field -->
                        <div class="form-group col-sm-4">
                            <label for="AGE">AGE:</label>
                            <input type="text" name="AGE" class="form-control" value="{{ old('AGE', $user->AGE) }}">
                            <small class="text-danger">{{ $errors->first('AGE') }}</small>
                        </div>

                        <!-- Status Field -->
                        <div class="form-group col-sm-4">
                            <label for="status">Status: <span class="text-danger">*</span></label>
                            <select name="status" class="form-control">
                                <option value="0" {{ old('status', $user->status) == 0 ? 'selected' : '' }}>Un Active</option>
                                <option value="1" {{ old('status', $user->status) == 1 ? 'selected' : '' }}>Active</option>
                            </select>
                            <small class="text-danger">{{ $errors->first('status') }}</small>
                        </div>

                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">حفظ</button>
                    <a href="{{ route('sitemanagement.users.index') }}" class="btn btn-default">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
@endsection
