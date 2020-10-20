<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

    <title>VietNam Hometown - Bản Đồ Realtime Các Điểm Cần Cứu Trợ Đồng Bào Miền Trung!</title>
    <meta name="description" content="VietNam Hometown - Bản Đồ Realtime Các Điểm Cứu Trợ Đồng Bào Miền Trung!">
    <meta name="keywords" content="VietNam Hometown,Miền Trung, ngập, cứu trợ">
    <meta name="author" content="VietNam Hometown">

    <meta property="og:image" content="/vietnamhometown.jpg?v=1"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="https://vietnamhometown"/>
    <meta property="og:title" content="VietNam Hometown - Bản Đồ Realtime Các Điểm Cứu Trợ Đồng Bào Miền Trung!"/>
    <meta property="og:description" content="VietNam Hometown - Bản Đồ Realtime Các Điểm Cứu Trợ Đồng Bào Miền Trung!"/>

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://gmaps-marker-clusterer.github.io/gmaps-marker-clusterer/assets/css/docs.min.css"
          rel="stylesheet">
    <link href="https://gmaps-marker-clusterer.github.io/gmaps-marker-clusterer/assets/css/style.css" rel="stylesheet">
    <link rel="icon" href="/favico.png" type="image/gif" sizes="16x16">
    <style>
        #content {
            background: #008080;
            background: linear-gradient(135deg, #008080, #673051);
        }
    </style>

    <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.3.0/bootbox.min.js"></script>
    <script src="https://gmaps-marker-clusterer.github.io/gmaps-marker-clusterer/assets/js/docs.min.js"></script>
    <style>
        .overlay {
            display: none;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 999999999;
            background: rgba(255, 255, 255, 0.8) url("/images/loader.gif") center no-repeat;
        }

        /* Turn off scrollbar when body element has the loading class */
        body.loading {
            overflow: hidden;
        }

        /* Make spinner image visible when body element has the loading class */
        body.loading .overlay {
            display: block;
        }

        .btn {
            cursor: pointer !important;
        }

        .bs-docs-footer {
            padding-top: 0px;
            padding-bottom: 40px;
            margin-top: 10px;
        }

        #map {
            width: 100%;
            height: 700px;
            max-width: 100%;
        }
    </style>
</head>

<body>
<!-- Main navigation
=========================================== -->
<header class="navbar navbar-static-top bs-docs-nav" id="top">
    <div class="container">
        <div class="navbar-header" role="banner">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">VietNam Hometown</a>
        </div>
        <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
            <ul class="nav navbar-nav">
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a target="_blank" href="https://www.facebook.com/Vietnam-Hometown-108705317620863">FanPage</a>
                </li>
            </ul>
        </nav>
    </div>
</header>


<!-- Header
=========================================== -->

<div class="bs-docs-header" id="content">
    <div class="container">
        <h1>Thông tin cứu trợ đồng bào miền Trung!</h1>
        <p></p>
    </div>
</div>


<div class="container bs-docs-container">
    <div class="row">
        <!-- Content
        =========================================== -->
        <div class="col-md-9" role="main" style="min-height: 500px">
            <h4>Đang cập nhật...</h4>
        </div>
    </div>
</div>
<!-- Page navigation
=========================================== -->
<div class="col-md-3" role="complementary">
    <div class="bs-docs-sidebar hidden-print">
        <ul class="nav bs-docs-sidenav">
        </ul>
        <a class="back-to-top" href="#top">
            <i class="glyphicon glyphicon-chevron-up"></i> Back to top
        </a>
    </div>
</div>


<!-- Footer
=========================================== -->
<footer class="bs-docs-footer" role="contentinfo">
    <div class="container">
        <div class="bs-docs-social">
            <ul class="bs-docs-social-buttons">

            </ul>
        </div>
        <p>Licensed under <a href="https://www.apache.org/licenses/LICENSE-2.0" target="_blank">Apache License</a>, <a
                href="/chinh-sach" target="_blank">Chính sách điều khoản</a>
        </p>
        <p>
            Power by <a href="https://vietnamhometown.com">VietNam HomeTown</a>
        </p>

        <ul class="bs-docs-footer-links muted">
            <li>Currently v1.0.0</li>

        </ul>
    </div>
</footer>


<!-- Async scripts
=========================================== -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-56178425-10"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-56178425-10');
</script>

</body>
</html>
