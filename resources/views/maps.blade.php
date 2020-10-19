<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
        <div class="col-md-9" role="main">
            <input class="form-control" type="text" id="locationTextField">
        </div>
    </div>
</div>
<br>
<div id="map"></div>
<script>

    var currentLatLng = {};

    function getCreateBtn(latLng) {
        currentLatLng = latLng;
        return '<a class="btn btn-info" onclick="addMaker()"> Thêm mới điểm cứu trợ</a>';
    }

    function initialize() {
        var infowindow = new google.maps.InfoWindow({
            disableAutoPan: true
        });


        var center = new google.maps.LatLng('{{$lat}}', '{{$lng}}', 13);

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: center,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        //
        var dbClick = false;
        map.addListener("dblclick", function (mapsMouseEvent) {
            dbClick = true;
        });
        map.addListener("click", function (mapsMouseEvent) {
            setTimeout(function () {
                if (dbClick) {
                    dbClick = false;
                    return false;
                }
                // Close the current InfoWindow.
                infowindow.close();
                // Create a new InfoWindow.
                infowindow = new google.maps.InfoWindow({
                    position: mapsMouseEvent.latLng,
                    disableAutoPan: true
                });
                var ll = mapsMouseEvent.latLng.toJSON();
                infowindow.setContent(getCreateBtn(ll));
                infowindow.open(map);
            }, 200)

        });


        var l = data.length;
        for (var i = 0; i < l; i++) {
            var latLng = new google.maps.LatLng(data[i].lat, data[i].lng);
            var marker = new google.maps.Marker({
                position: latLng,
                icon: data[i].icon,
                title: data[i]['title'],
                idx: i
            });

            google.maps.event.addListener(marker, 'mouseover', (function (marker) {
                return function () {
                    var content = getContent(data[marker.idx]);
                    infowindow.setContent(content);
                    infowindow.open(map, marker);
                }
            })(marker));

            google.maps.event.addListener(marker, 'click', (function (marker) {
                return function () {
                    var content = getContent(data[marker.idx]);
                    infowindow.setContent(content);
                    infowindow.open(map, marker);
                }
            })(marker));


            markers.push(marker);
        }


        var input = document.getElementById('locationTextField');
        var autocomplete = new google.maps.places.Autocomplete(input);

        var options = {
            imagePath: '/images/m'
        };
        var markerCluster = new MarkerClusterer(map, markers, options);
    }

    var data = [];
        @foreach($data as $map)
    var latLng = {
            lat: '{{$map->lat}}',
            lng: '{{$map->lng}}',
            icon: getIcon({{$map->type}}),
            title: '{{$map->title}}',
            description: "{{str_replace( array( "\n", "\r" ), array( "\\n", "\\r" ),$map->description)}}",
            type: '{{$map->type}}',
            id: '{{$map->id}}',
        };
    data.push(latLng);
        @endforeach

    var markers = [];

    $(document).on({

        ajaxStart: function () {
            $("body").addClass("loading");
        },
        ajaxStop: function () {
            $("body").removeClass("loading");
        }
    });

    var currentItem = {};

    function getIcon(type) {
        return '/images/m' + type + '.png';
    }

    function getStatus(type) {
        switch (type) {
            case '1':
                return '<p class="btn btn-info">Đã cứu trợ</p>';
            case '2':
                return '<p class="btn btn-warning">Đang tìm kiếm</p>';
            case '3':
                return '<p class="btn btn-dark">Đang cứu trợ</p>';
            case '4':
                return '<p class="btn btn-danger">Nguy cấp</p>';
            case '5':
                return '<p class="btn btn-danger">Cực kỳ nguy cấp</p>';
            default:
                return '<p class="btn btn-info">Chưa rõ</p>';
        }

    }

    function getEditBtn(data) {
        currentItem = data;
        return ' <a class="btn btn-warning" onclick="setFormData()"> Chỉnh sửa</a> ';
    }

    function getContent(data) {
        return "<div> <h2>" + data['title'] + "</h2> " + getStatus(data['type']) + getEditBtn(data) + " <p style='padding: 10px; font-size: 18px'>" + data['description'].replace(/\n/g, "<br />");
        +"</p></div>";
    }

    function setFormData() {
        $('#id').val(currentItem['id']);
        $('#title').val(currentItem['title']);
        $('#type').val(currentItem['type']);
        $('#lat').val(currentItem['lat']);
        $('#lng').val(currentItem['lng']);
        $('#description').val(currentItem['description']).html(currentItem['description']);
        $('#exampleModalCenter').modal('show');
    }

    function save() {

        if (!$.trim($('#title').val())) {
            return alert('Bạn cần nhập tên');
        }
        if (!$.trim($('#description').val())) {
            return alert('Bạn cần nhập ghi chú');
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "maps/post",
            type: "post",
            data: {
                id: $('#id').val(),
                title: $('#title').val(),
                type: $('#type').val(),
                description: $('#description').val(),
                lat: $('#lat').val(),
                lng: $('#lng').val(),
            },
            success: function (response) {
                if (response.status) {
                    alert('Cảm ơn bạn đã hỗ trợ chúng tôi cập nhật thông tin người cần cứu trợ!');
                    return window.location.reload();
                }
                return alert(response.message);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
                alert('Đã có lỗi xảy ra, vui lòng thử lại hoặc tải lại trang!');
            }
        });
    }


    function addMaker() {
        $('#id').val('');
        $('#title').val('');
        $('#type').val('0');
        $('#lat').val(currentLatLng['lat']);
        $('#lng').val(currentLatLng['lng']);
        $('#description').val('');
        $('#exampleModalCenter').modal('show');
    }
</script>

<script
    src="https://gmaps-marker-clusterer.github.io/gmaps-marker-clusterer/assets/js/markerclusterer.js"></script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?callback=initialize&key=AIzaSyBd4yBeOz4tTvNkwzkV0JJRS80xtKGqsaA&libraries=places&sensor=false"></script>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.4.11/d3.min.js"></script>
<!-- Modal -->
<div class="modal fade" data-backdrop="static" id="exampleModalCenter" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Thông tin người cần cứu trợ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="form">
                    <input id="id" type="hidden">
                    <input id="lat" type="hidden">
                    <input id="lng" type="hidden">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Tên <span class="text-danger"> * </span></label>
                        <input id="title" type="email" class="form-control"
                               placeholder="Nhập tên người cần cứu trợ">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Tình trạng hiện tại <span class="text-danger"> * </span></label>
                        <select class="form-control" id="type">
                            <option value="0">Chưa rõ</option>
                            <option value="1">Đã cứu trợ</option>
                            <option value="2">Đang tìm kiếm</option>
                            <option value="3">Đang cứu trợ</option>
                            <option value="4">Nguy cấp</option>
                            <option value="5">Cực kỳ nguy cấp</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Ghi chú <span class="text-danger"> * </span></label>
                        <textarea class="form-control" id="description" rows="8"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" onclick="save()">Lưu lại</button>
            </div>
        </div>
    </div>
</div>
<div class="overlay"></div>
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
