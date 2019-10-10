<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <link rel="stylesheet" href="{{ mix('css/main.css', 'assets/build') }}">
    </head>
    <body>
        @hasSection('header')
            <header class="bg-blue-500 text-white pt-12 pb-6 px-8">
                <div class="container">
                    @yield('header')
                </div>
            </header>
        @endif

        <div class="p-8">
            @yield('body')
        </div>

        @hasSection('footer')
            <footer class="py-6 px-8">
                <div class="container">
                    @yield('footer')
                </div>
            </footer>
        @endif
    </body>
</html>
