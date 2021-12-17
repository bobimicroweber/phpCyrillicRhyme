<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>phpCyrillicRhyme</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <link href="css/jquery.atwho.css" rel="stylesheet">
        <script src="//code.jquery.com/jquery.js"></script>
        <script src="js/jquery.caret.js"></script>
        <script src="js/jquery.atwho.js"></script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
            	margin-top: 30px;
                font-size: 54px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
            input {
            	padding:15px;
            	border: 1px solid #ddd;
            	color: #636b6f;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    phpCyrillicRhyme
                </div>

                <style>
                    .js-autocomplete-editor {
                        margin:0 auto;
                        width:50%;
                        background: #f2f2f2;
                        height: 600px;
                        padding:15px;
                        text-align: left;
                        font-size: 16px;
                        font-weight: bold;
                        color:#000000;
                    }
                </style>


                <div class="js-autocomplete-editor" contenteditable="true"></div>

            </div>
        </div>
    </body>
</html>
