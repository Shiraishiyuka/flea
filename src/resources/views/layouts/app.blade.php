<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>flea</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    @yield('css')

    <style>
            * {
                margin: 0;
                padding: 0;
            }

            .header {
                width: 100%;
                height: 50px;
            }

            .header__inner {
                width: 100%;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: left;
                background-color: #000000;
            }

            .logo {
                width: 300px;

            }

            main {
                width: 100%;
                height: 80%;
                background-color: white;
            }

            
    </style>
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a href="logo"><img src="{{ asset('storage/images/logo.svg') }}" class="logo" alt="Logo"></a>

            @yield('header')
        </div>
        
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>