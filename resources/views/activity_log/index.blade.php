{{--<table class="table table-bordered">
    <thead>
    <tr>
        <td>المستخدم</td>
        <td>الحدث</td>
        <td>التعليق</td>
        <td>الحالة</td>
        <td>ارسل بريد الكتروني</td>
        <td>التاريخ</td>
    </tr>
    </thead>
    <tbody>
    @foreach(@$activity_logs as $actvity_log)

        <tr>
            <td>{{$actvity_log->causer->name}}</td>
            <td>{{$actvity_log->description}}</td>
            <td>{{$actvity_log->comment}}</td>
            <td>
                @switch($actvity_log->getExtraProperty('status'))
                    @case(1)
                        <span class="badge badge-danger">متوقف</span>
                        @break
                    @case(2)
                        <span class="badge badge-danger">جاري العمل عليه</span>
                        @break
                    @case(3)
                        <span class="badge badge-success">تم الحل</span>
                        @break
                @endswitch
            </td>
            <td>
                @switch($actvity_log->getExtraProperty('send_email'))
                    @case("on")
                        <span class="badge badge-danger">لم يتم</span>
                        @break
                    @default
                        <span class="badge badge-success">تم</span>
                        @break
                @endswitch
            </td>

            <td>{{$actvity_log->created_at->format('d/m/Y h:i A')}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

{{@$activity_logs->links()}}--}}
