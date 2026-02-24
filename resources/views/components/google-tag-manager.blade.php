{{-- Google Tag Manager --}}
{{-- Usage: Include @include('components.google-tag-manager', ['section' => 'head']) in <head> --}}
{{--        Include @include('components.google-tag-manager', ['section' => 'body']) after <body> --}}

@if(isset($section) && $section === 'head')
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MXSN7S5R');</script>
<!-- End Google Tag Manager -->

 <meta name="facebook-domain-verification" content="k6v3agddx5gb0bvfva7xsnguqsrleg" />


<!-- Facebook Pixel Code -->
<script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '2084977348310462');
    fbq('track', 'PageView');
</script>
<noscript>
    <img height="1" width="1" style="display:none"
         src="https://www.facebook.com/tr?id=2084977348310462&ev=PageView&noscript=1"
    /></noscript>
<!-- End Facebook Pixel Code -->

<script src="https://t.contentsquare.net/uxa/2a9ac81a6defe.js"></script>
@endif

@if(isset($section) && $section === 'body')
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MXSN7S5R"
height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->
@endif


