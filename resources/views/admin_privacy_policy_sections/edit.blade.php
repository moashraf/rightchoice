@extends('layouts.admin')

@section('title', 'تعديل سياسة الخصوصية')

@push('page_css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css">
    <style>
        .note-editor.note-frame {
            border-color: #ced4da;
            border-radius: .25rem;
        }

        .note-editor .note-toolbar {
            background: #f8f9fa;
        }

        #arabic-content .note-editable {
            direction: rtl;
            text-align: right;
        }

        #english-content .note-editable {
            direction: ltr;
            text-align: left;
        }
    </style>
@endpush

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-8">
                    <h1>تعديل عنصر سياسة الخصوصية</h1>
                    <p class="text-muted mb-0">#{{ $privacyPolicySection->slug }}</p>
                </div>
                <div class="col-sm-4 text-sm-right mt-2 mt-sm-0">
                    <a href="{{ route('sitemanagement.privacy-policy-sections.index') }}" class="btn btn-default">
                        رجوع
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @if($errors->any())
            <div class="alert alert-danger" dir="rtl">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('sitemanagement.privacy-policy-sections.update', $privacyPolicySection) }}">
            @csrf
            @method('PUT')

            <div class="card shadow-sm">
                <div class="card-header p-0 pt-1 border-bottom-0">
                    <ul class="nav nav-tabs" id="privacyLanguageTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="arabic-tab" data-toggle="pill" href="#arabic-content" role="tab">
                                <i class="fas fa-language ml-1"></i>
                                العربي
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="english-tab" data-toggle="pill" href="#english-content" role="tab">
                                <i class="fas fa-language mr-1"></i>
                                English
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="arabic-content" role="tabpanel">
                            <div dir="rtl" class="text-right">
                                <h5 class="mb-3 font-weight-bold">المحتوى العربي</h5>

                                <div class="form-group">
                                    <label for="title_ar">العنوان <span class="text-danger">*</span></label>
                                    <input id="title_ar" type="text" name="title_ar" class="form-control text-right"
                                           value="{{ old('title_ar', $privacyPolicySection->title_ar) }}" required maxlength="255">
                                </div>

                                <div class="form-group">
                                    <label for="subtitle_ar">العنوان الفرعي</label>
                                    <input id="subtitle_ar" type="text" name="subtitle_ar" class="form-control text-right"
                                           value="{{ old('subtitle_ar', $privacyPolicySection->subtitle_ar) }}" maxlength="500">
                                </div>

                                <div class="form-group mb-0">
                                    <label for="details_ar">التفاصيل <span class="text-danger">*</span></label>
                                    <textarea id="details_ar" name="details_ar" class="form-control rich-text-editor">{{ old('details_ar', $privacyPolicySection->details_ar) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="english-content" role="tabpanel">
                            <div dir="ltr" class="text-left">
                                <h5 class="mb-3 font-weight-bold">English Content</h5>

                                <div class="form-group">
                                    <label for="title_en">Title <span class="text-danger">*</span></label>
                                    <input id="title_en" type="text" name="title_en" class="form-control"
                                           value="{{ old('title_en', $privacyPolicySection->title_en) }}" required maxlength="255">
                                </div>

                                <div class="form-group">
                                    <label for="subtitle_en">Subtitle</label>
                                    <input id="subtitle_en" type="text" name="subtitle_en" class="form-control"
                                           value="{{ old('subtitle_en', $privacyPolicySection->subtitle_en) }}" maxlength="500">
                                </div>

                                <div class="form-group mb-0">
                                    <label for="details_en">Details <span class="text-danger">*</span></label>
                                    <textarea id="details_en" name="details_en" class="form-control rich-text-editor">{{ old('details_en', $privacyPolicySection->details_en) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <small class="form-text text-muted mt-3" dir="rtl">
                        محرر التفاصيل يدعم التنسيق مباشرة مثل الخط العريض، المائل، العناوين، القوائم، الروابط، والمحاذاة والنزول لسطر جديد.
                    </small>

                    <hr>

                    <div class="row" dir="rtl">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sort_order">الترتيب</label>
                                <input id="sort_order" type="number" min="1" max="999" name="sort_order"
                                       class="form-control" value="{{ old('sort_order', $privacyPolicySection->sort_order) }}" required>
                            </div>
                        </div>
                        <div class="col-md-8 d-flex align-items-center">
                            <div class="custom-control custom-switch mt-3">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1"
                                       {{ old('is_active', $privacyPolicySection->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">إظهار هذا العنصر في صفحة سياسة الخصوصية</label>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-light border mb-0" dir="rtl">
                        <strong>الرابط الداخلي ثابت:</strong>
                        <code>#{{ $privacyPolicySection->slug }}</code>
                        <br>
                        <small class="text-muted">نفس الرابط يستخدم في النسخة العربية والإنجليزية حتى لا تتعطل الروابط المنشورة.</small>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('sitemanagement.privacy-policy-sections.index') }}" class="btn btn-default">إلغاء</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save ml-1"></i>
                        حفظ التعديلات
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('page_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.js"></script>
    <script>
        $(function () {
            var editorOptions = {
                height: 360,
                minHeight: 250,
                dialogsInBody: true,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            };

            $('#details_ar').summernote(editorOptions);
            $('#details_en').summernote(editorOptions);

            $('#arabic-content .note-editable').attr('dir', 'rtl').css('text-align', 'right');
            $('#english-content .note-editable').attr('dir', 'ltr').css('text-align', 'left');

            $('a[data-toggle="pill"]').on('shown.bs.tab', function () {
                $('.rich-text-editor').each(function () {
                    $(this).summernote('code', $(this).summernote('code'));
                });
            });
        });
    </script>
@endpush
