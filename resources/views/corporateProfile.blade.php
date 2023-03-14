<!-- Loopple Templates: https://www.loopple.com/templates | Copyright Loopple (https://www.loopple.com) | This copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Chatbot</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <link rel="stylesheet" href="https://rawcdn.githack.com/Loopple/loopple-public-assets/ad60f16c8a16d1dcad75e176c00d7f9e69320cd4/argon-dashboard/css/nucleo/css/nucleo.css">
    <link rel="stylesheet" href="{{ asset('chat-template/assets/css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('chat-template/assets/css/loopple/loopple.css') }}">
</head>

<body>
    <nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white loopple-fixed-start" id="sidenav-main">
        <nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
            <div class="sidenav-header  align-items-center">
                <a class="navbar-brand" href="javascript:void(0)">
                    <img src="https://demos.creative-tim.com/argon-dashboard/assets-old/img/brand/blue.png" class="navbar-brand-img" alt="...">
                </a>
            </div>
            <hr class="mt-0 mb-3">
            <div class="d-flex align-items-center">
                <img src="https://demos.creative-tim.com/argon-dashboard/assets-old/img/theme/team-4.jpg" class="avatar ml-3">
                <div class="ml-3">
                    <h4 class="mb-0">Tania Amber</h4>
                    <p class="text-xs mb-0">Web Developer</p>
                </div>
            </div>
            <hr class="mt-3 mb-0">
            <div class="navbar-inner">

            </div>
        </nav>
    </nav>
    <div class="main-content" id="panel">
        <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom" id="navbarTop">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <form class="navbar-search navbar-search-dark form-inline mr-sm-3 mb-0" id="navbar-search-main">
                        <div class="form-group mb-0">
                            <div class="input-group input-group input-group-merge">
                                <input class="form-control ml-2" placeholder="Type here..." type="text">
                                <div class="input-group-append mr-2">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </form>
                </div>
            </div>
        </nav>
        <div class="container-fluid pt-3">
            <div class="row removable">
                <div class="col-lg-12 px-sm-0">
                    <div class="card shadow-none px-0 bg-transparent mt-0 mb-4">
                        <div class="card-body px-0 pb-0">
                            <div class="px-0 pb-4">
                                <div class="row flex-row">
                                    <div class="col-lg-12">
                                        <div class="card max-height-vh-70" style="max-height: 70vh;">
                                            <div class="card-header shadow-xl">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="d-flex align-items-center">
                                                            <div class="ms-3">
                                                                <h3 class="mb-0 d-block">Corporate Profile</h3>
                                                                <span class="text-sm text-muted"><span class="font-weight-bold">Chatbot</span> | Corporate Profile</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body overflow-auto overflow-x-hidden">
                                                <div class="row justify-content-start mb-4">
                                                    <div class="col-auto">
                                                        <div class="card ">
                                                            <div class="card-body p-2">
                                                                <p class="mb-1">
                                                                    It contains a lot of good lessons about effective practices
                                                                </p>
                                                                <div class="d-flex align-items-center text-sm opacity-6">
                                                                    <i class="far fa-clock mr-1" aria-hidden="true"></i>
                                                                    <small>3:14am</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-end text-right mb-4">
                                                    <div class="col-auto">
                                                        <div class="card bg-gradient-primary text-white">
                                                            <div class="card-body p-2">
                                                                <p class="mb-1">
                                                                    Can it generate daily design links that include essays and data visualizations ?<br>
                                                                </p>
                                                                <div class="d-flex align-items-center justify-content-end text-sm opacity-6">
                                                                    <i class="fa fa-check-double mr-1 text-xs" aria-hidden="true"></i>
                                                                    <small>4:42pm</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col-md-12 text-center">
                                                        <span class="badge text-dark">Wed, 3:27pm</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer d-block" id="input">
                                                <form action="{{ route('chatbot.store') }}" class="align-items-center">
                                                    <div class="input-group mb-3">
                                                        <input type="text" id="message" name="message" placeholder="Search" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">
                                                                <button type="submit"><i class="fa fa-paper-plane">Kirim</i></button>
                                                            </span>
                                                        </div>
                                                        <!-- <button type="submit"><i class="fa fa-paper-plane">Kirim</i></button> -->
                                                    </div>
                                                </form>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <footer class="footer pt-0 px-4">
            <div class="row align-items-center justify-content-lg-between">
                <div class="col-lg-6">
                    <div class="copyright text-center  text-lg-left  text-muted">
                        © 2021 Made with
                        <a href="https://www.creative-tim.com/product/argon-dashboard" class="font-weight-bold ml-1" target="_blank">Argon Dashboard</a>
                        &amp;<a href="https://www.loopple.com" class="font-weight-bold ml-1" target="_blank">Loopple</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                        <li class="nav-item">
                            <a href="javascript:void(0);" class="nav-link">About us</a>
                        </li>
                        <li class="nav-item">
                            <a href="javascript:;" class="nav-link">Company</a>
                        </li>
                        <li class="nav-item">
                            <a href="javascript:;" class="nav-link">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a href="javascript:;" class="nav-link">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
    <div class="loopple-badge">Made with<a href="https://www.loopple.com"><img src="https://www.loopple.com/img/loopple-logo.png" class="loopple-ml-1" style="width:55px"></a></div>
    <script src="https://rawcdn.githack.com/Loopple/loopple-public-assets/5cef8f62939eeb089fa26d4c53a49198de421e3d/argon-dashboard/js/vendor/jquery.min.js"></script>
    <script src="https://rawcdn.githack.com/Loopple/loopple-public-assets/5cef8f62939eeb089fa26d4c53a49198de421e3d/argon-dashboard/js/vendor/bootstrap.bundle.min.js"></script>
    <script src="https://rawcdn.githack.com/Loopple/loopple-public-assets/5cef8f62939eeb089fa26d4c53a49198de421e3d/argon-dashboard/js/vendor/js.cookie.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <script src="https://rawcdn.githack.com/Loopple/loopple-public-assets/5cef8f62939eeb089fa26d4c53a49198de421e3d/argon-dashboard/js/vendor/chart.extension.js"></script>
    <script src="https://rawcdn.githack.com/Loopple/loopple-public-assets/7bb803d2af2ab6d71d429b0cb459c24a4cd0fbb4/argon-dashboard/js/argon.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function() {
            $('#chatbot form').submit(function(e) {
                e.preventDefault();

                var message = $('#message').val();

                if (message.trim() == '') {
                    return false;
                }

                $('#message').val('');

                $.ajax({
                    type: 'POST',
                    url: '/chatbot',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        message: message,
                    },
                    success: function(response) {
                        $('#messages').append('<div class="message"><div class="message-body">' + message + '</div></div>');
                        $('#messages').append('<div class="message"><div class="message-body">' + response.message + '</div></div>');
                        $('#messages').scrollTop($('#messages')[0].scrollHeight);
                    },
                    error: function(xhr, status, error) {
                        alert('Maaf, terjadi kesalahan saat memproses permintaan Anda: ' + error);
                    },
                });
            });
        });
    </script>
</body>