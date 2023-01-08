<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Bootstrap -->
    <!-- css -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- js -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

    <!-- font awesome -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>

<style>
    /* prompt */
    .prompt{
        display:none;

        background:#ff8080;
        width:100%;

        position:fixed;
        top:0;
        padding:20px;

        color:#fff;
        text-align:center;

        z-index:1;
    }
    .prompt_message{

    }
    .prompt_close{
        cursor:pointer;
    }
    /* navbar */
    .wellcome_text{
        padding-right: 12px;
    }
</style>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/main_page') }}">
                    <!-- {{ config('app.name', 'Laravel') }} -->
                    Photo Gallery
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <div class="navbar-text wellcome_text">歡迎, {{ Auth::user()->name }}</div>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    管理相簿 <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <!-- photo_gallery -->
                                    <a class="dropdown-item" href="{{ route('main_page') }}">
                                        動態牆
                                    </a>
                                    <a class="dropdown-item" href="{{ route('all_photo') }}">
                                        我的相片
                                    </a>
                                    <a class="dropdown-item" href="{{ route('manage_photo') }}">
                                        發布 / 管理相片
                                    </a>
                                    <!-- <a class="dropdown-item" href="{{ route('all_photo') }}">
                                        搜尋 / 我的好友
                                    </a> -->

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <!-- {{ __('Logout') }} -->
                                        登出
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- <main class="py-4"> -->
        <main>
            <div class="prompt">
                <div class="prompt_message">test</div>

                <div class="prompt_close">x</div>
            </div>

            @yield('content')
        </main>
    </div>
</body>
</html>

<script>
    // prompt
    // =========================================
    $('.prompt_close').click(function(){
        $('.prompt').css('display','none');
    });

    // prompt
    function prompt_success($message){
        $('.prompt').css('display','initial');
        $('.prompt_message').html($message);
        $('.prompt').css('background','#004080');
    }

    // prompt
    function prompt_faild($message){
        $('.prompt').css('display','initial');
        $('.prompt_message').html($message);
        $('.prompt').css('background','#ff8080');
    }
    // validation
    // =========================================
    function text_validation($text){
        validation_status = true;

        // 長度驗證
        $length = $text.length;
        console.log('text_length: '+$length);

        if($length>255){
            prompt_faild('文字內容請勿超過255個字');
            validation_status = false;
        }
        // 特殊字符驗證
        filter_str = RegExp("<script>|<\/script>|<\?php|\\?>|<\\?|<\\?=","i");

        result = filter_str.test($text);
        console.log('filter_str_match: '+result);

        if(result == true){
            prompt_faild('請勿輸入特殊字符');
            validation_status = false;

            // 跳出迴圈
            return false;
        }

        return validation_status;
    }
</script>
