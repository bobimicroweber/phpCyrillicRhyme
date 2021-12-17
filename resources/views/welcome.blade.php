<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>phpCyrillicRhyme</title>

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="//fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <script src="js/jquery.js"></script>
        <script src="js/jquery.caret.js"></script>
        <script src="js/autocomplete.js"></script>


        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>

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
                    #js-autocomplete {
                        text-align: left;
                        font-size: 16px;
                        font-weight: bold;
                        color:#000000;
                        width: 60%;
                        margin:0 auto;
                    }
                    #js-autocomplete-editor {
                        width: 70%;
                        float:left;
                        height:700px;
                    }
                    #js-autocomplete-editor-textarea {
                        background: #f2f2f2;
                        border:0px;
                        height:100%;
                        width:98%;
                        padding:15px;
                    }
                    #js-autocomplete-editor-textarea input:focus, textarea:focus, select:focus {
                        outline: none;
                        border:0px;
                    }
                    #js-autocomplete-suggestions {
                        width:24%;
                        padding:15px;
                        float:left;
                        background: #e6e6e6;
                        text-align: center;
                        height:700px;
                    }
                </style>

                <script>
                    $(document).ready(function() {
                        $('body').keyup(function(e){
                            if (e.keyCode == 13) {
                                autocomplete();
                            }
                        });
                    });
                    function autocomplete()
                    {
                        var myTextareaVal = $('#js-autocomplete-editor-textarea').val();
                        var myLineBreak = myTextareaVal.replace(/\n|\n/g,"<br>");

                        $.post("{{route('autocomplete')}}", {
                            text: myLineBreak,
                        }, function(data, status){
                            $('#js-autocomplete-suggestions').html(data);
                        });
                    }
                </script>

                <div id="js-autocomplete">
                    <div id="js-autocomplete-editor">
                       <textarea id="js-autocomplete-editor-textarea" placeholder="Започни да пишеш тук..."></textarea>
                    </div>
                    <div id="js-autocomplete-suggestions">ПОДСКАЗКИ</div>
                </div>

            </div>
        </div>
    </body>
</html>
