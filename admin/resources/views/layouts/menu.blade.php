<li class="nav-item">
    <a href="{{ route('user.index') }}"
       class="nav-link {{ Request::is('user*') ? 'active' : '' }}">
        <p>المستخدمين</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('blogs.index') }}"
       class="nav-link {{ Request::is('blogs*') ? 'active' : '' }}">
        <p>المدونات</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('offerTypes.index') }}"
       class="nav-link {{ Request::is('offerTypes*') ? 'active' : '' }}">
        <p>انواع العروض</p>
    </a>
</li>



<li class="nav-item">
    <a href="{{ route('aqarCategories.index') }}"
       class="nav-link {{ Request::is('aqarCategories*') ? 'active' : '' }}">
        <p>فئات العقارات</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('propertyTypes.index') }}"
       class="nav-link {{ Request::is('propertyTypes*') ? 'active' : '' }}">
        <p>انواع العقارات</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('callTimes.index') }}"
       class="nav-link {{ Request::is('callTimes*') ? 'active' : '' }}">
            <p>أوقات المكالمات</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('compounds.index') }}"
       class="nav-link {{ Request::is('compounds*') ? 'active' : '' }}">
        <p>مجمعات سكنية</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('governrates.index') }}"
       class="nav-link {{ Request::is('governrates*') ? 'active' : '' }}">
        <p>المحافظات</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('districts.index') }}"
       class="nav-link {{ Request::is('districts*') ? 'active' : '' }}">
        <p>المناطق</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('finishTypes.index') }}"
       class="nav-link {{ Request::is('finishTypes*') ? 'active' : '' }}">
        <p>أنواع التشطيب</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('floors.index') }}"
       class="nav-link {{ Request::is('floors*') ? 'active' : '' }}">
        <p>الطوابق</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('licenseTypes.index') }}"
       class="nav-link {{ Request::is('licenseTypes*') ? 'active' : '' }}">
        <p>أنواع التراخيص</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('subareas.index') }}"
       class="nav-link {{ Request::is('subareas*') ? 'active' : '' }}">
        <p>المناطق الفرعية</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('services.index') }}"
       class="nav-link {{ Request::is('services*') ? 'active' : '' }}">
        <p>خدمات</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('priceingSales.index') }}"
       class="nav-link {{ Request::is('priceingSales*') ? 'active' : '' }}">
        <p>تسعير المبيعات</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('mzayas.index') }}"
       class="nav-link {{ Request::is('mzayas*') ? 'active' : '' }}">
        <p>مزايا</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('pages.index') }}"
       class="nav-link {{ Request::is('pages*') ? 'active' : '' }}">
        <p>الصفحات</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('aqars.index') }}"
       class="nav-link {{ Request::is('aqars*') ? 'active' : '' }}">
        <p>عقارات</p>
    </a>
</li>


<!-- <li class="nav-item">
    <a href="{{ route('images.index') }}"
       class="nav-link {{ Request::is('images*') ? 'active' : '' }}">
        <p>Images</p>
    </a>
</li> -->


<!-- <li class="nav-item">
    <a href="{{ route('aqarMzayas.index') }}"
       class="nav-link {{ Request::is('aqarMzayas*') ? 'active' : '' }}">
        <p>Aqar Mzayas</p>
    </a>
</li> -->


<li class="nav-item">
    <a href="{{ route('companies.index') }}"
       class="nav-link {{ Request::is('companies*') ? 'active' : '' }}">
        <p>الشركات</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('priceVips.index') }}"
       class="nav-link {{ Request::is('priceVips*') ? 'active' : '' }}">
        <p>سعر كبار الشخصيات</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('requestPhotoSessions.index') }}"
       class="nav-link {{ Request::is('requestPhotoSessions*') ? 'active' : '' }}">
        <p>طلب جلسات تصوير</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('sliders.index') }}"
       class="nav-link {{ Request::is('sliders*') ? 'active' : '' }}">
        <p>سلايدر</p>
    </a>
</li>

<!-- 
<li class="nav-item">
    <a href="{{ route('userContactAqars.index') }}"
       class="nav-link {{ Request::is('userContactAqars*') ? 'active' : '' }}">
        <p>User Contact Aqars</p>
    </a>
</li> -->


<!-- <li class="nav-item">
    <a href="{{ route('userPriceings.index') }}"
       class="nav-link {{ Request::is('userPriceings*') ? 'active' : '' }}">
        <p>User Priceings</p>
    </a>
</li> -->


<!-- <li class="nav-item">
    <a href="{{ route('wishes.index') }}"
       class="nav-link {{ Request::is('wishes*') ? 'active' : '' }}">
        <p>Wishes</p>
    </a>
</li> -->


<li class="nav-item">
    <a href="{{ route('complaints.index') }}"
       class="nav-link {{ Request::is('complaints*') ? 'active' : '' }}">
        <p>شكاوي</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('contactForms.index') }}"
       class="nav-link {{ Request::is('contactForms*') ? 'active' : '' }}">
        <p>نماذج الاتصال</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('notifications.index') }}"
       class="nav-link {{ Request::is('notifications*') ? 'active' : '' }}">
        <p>إشعارات</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('settingSites.index') }}"
       class="nav-link {{ Request::is('settingSites*') ? 'active' : '' }}">
        <p>إعداد الموقع </p>
    </a>
</li>


