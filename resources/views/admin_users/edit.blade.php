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

                        <!-- Profile Image Field -->
                        <div class="form-group col-sm-12">
                            <label>صورة الملف الشخصي:</label>
                            <div class="row align-items-center">
                                <div class="col-sm-2 text-center">
                                    @if($user->profile_image)
                                        <img id="profilePreview"
                                             src="{{ URL::to('/').'/'.$user->profile_image }}"
                                             alt="profile"
                                             class="img-thumbnail"
                                             style="width:100px; height:100px; object-fit:cover; border-radius:50%;">
                                    @else
                                        <div id="profilePreviewEmpty"
                                             style="width:100px; height:100px; border-radius:50%; background:#e9ecef; display:flex; align-items:center; justify-content:center; margin:auto;">
                                            <i class="fas fa-user fa-2x text-muted"></i>
                                        </div>
                                        <img id="profilePreview" src="" alt="profile"
                                             class="img-thumbnail d-none"
                                             style="width:100px; height:100px; object-fit:cover; border-radius:50%;">
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="imgInput"
                                               name="img" accept="image/*"
                                               onchange="previewProfileImage(event)">
                                        <label class="custom-file-label" for="imgInput">اختر صورة...</label>
                                    </div>
                                    <small class="text-muted">JPG, PNG, GIF - بحد أقصى 2MB</small>
                                    @if($user->profile_image)
                                        <div class="mt-1">
                                            <input type="checkbox" name="remove_profile_image" value="1" id="removeImg">
                                            <label for="removeImg" class="text-danger" style="font-size:13px;">
                                                <i class="fas fa-trash ml-1"></i> حذف الصورة الحالية
                                            </label>
                                        </div>
                                    @endif
                                </div>
                            </div>
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

@push('page_scripts')
<script>
    function previewProfileImage(event) {
        var file  = event.target.files[0];
        var preview = document.getElementById('profilePreview');
        var empty   = document.getElementById('profilePreviewEmpty');
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                if (empty) empty.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush

@endsection
