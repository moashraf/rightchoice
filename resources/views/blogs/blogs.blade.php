<x-layout>


     @section('title')
المقالات
    @endsection
   <div class="image-cover hero-banner" style="background:url('{{ asset('assets/img/NoPath.png')}}') no-repeat;">

      <div class="container">

         <div class="row">







            <div class="col-lg-12 col-md-12">



               <div class="hero__p">

                  <h1>





                                    المقالات






                  </h1>



                  <p>
                      كل ما يهمك في مجال العقارات، الأخبار والأسعار وأهم التطورات في مجال العقارات والتسويق العقاري، ستجده هنا
                  </p>

               </div>

            </div>

         </div>



      </div>

   </div>






<section class="articels" dir="rtl">

    {{-- ===== قسم رفع الملفات ===== --}}
    <div class="container mt-4 mb-2">
        @if(session('upload_success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('upload_success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->has('upload_file'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ $errors->first('upload_file') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <h5 class="card-title fw-bold mb-3">
                    <i class="fas fa-upload me-2 text-primary"></i> رفع ملف (الحد الأقصى: 1 جيجابايت)
                </h5>
                <form action="{{ route('blogs.upload.file') }}" method="POST" enctype="multipart/form-data" id="uploadBlogForm">
                    @csrf
                    <div class="mb-3">
                        <input type="file" name="upload_file" id="upload_file" class="form-control" required>
                        <div class="form-text text-muted">يمكنك رفع أي نوع من الملفات بحجم أقصى 1 جيجابايت.</div>
                    </div>
                    <div id="uploadProgressWrapper" class="mb-3" style="display:none;">
                        <label class="form-label">جاري الرفع...</label>
                        <div class="progress">
                            <div id="uploadProgressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                 role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary px-4" id="uploadBtn">
                        <i class="fas fa-cloud-upload-alt me-2"></i> رفع الملف
                    </button>
                </form>
            </div>
        </div>
    </div>
    {{-- ===== نهاية قسم رفع الملفات ===== --}}






   <div class="container">



	<h2>جميع المقالات</h2>






                     <br>
                     <br>

    <div class="row">
@foreach($allBlogs as $blog)
<div class="col-lg-4 mt-3">



<a href="{{ URL::to(Config::get('app.locale') .'/blogs').'/'.$blog->slug }}">



<div class="box">



      <img src="{{ asset('/images').'/'.$blog->single_photo }}" class="img-fluid" alt="">



      <h3>{{ $blog->title }}</h3>



      <p></p>



    </div>



</a>



 </div>
@endforeach

</div>






          {{ $allBlogs->links() }}

</div>



</section>


<script>
document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('uploadBlogForm');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        var fileInput = document.getElementById('upload_file');
        if (!fileInput.files.length) return;

        var file = fileInput.files[0];
        var maxSize = 1024 * 1024 * 1024; // 1 GB
        if (file.size > maxSize) {
            alert('حجم الملف يتجاوز الحد المسموح به (1 جيجابايت). يرجى اختيار ملف أصغر.');
            return;
        }

        var formData = new FormData(form);
        var xhr = new XMLHttpRequest();

        document.getElementById('uploadProgressWrapper').style.display = 'block';
        document.getElementById('uploadBtn').disabled = true;

        xhr.upload.addEventListener('progress', function (e) {
            if (e.lengthComputable) {
                var percent = Math.round((e.loaded / e.total) * 100);
                var bar = document.getElementById('uploadProgressBar');
                bar.style.width = percent + '%';
                bar.setAttribute('aria-valuenow', percent);
                bar.textContent = percent + '%';
            }
        });

        xhr.addEventListener('load', function () {
            document.open();
            document.write(xhr.responseText);
            document.close();
        });

        xhr.addEventListener('error', function () {
            alert('فشل الاتصال بالخادم. يرجى التحقق من الاتصال والمحاولة مرة أخرى.');
            document.getElementById('uploadBtn').disabled = false;
            document.getElementById('uploadProgressWrapper').style.display = 'none';
        });

        xhr.open('POST', form.action, true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.send(formData);
    });
});
</script>

</x-layout>

