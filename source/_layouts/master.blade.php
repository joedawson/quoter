<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <base href="{{ $page->baseUrl }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <link rel="stylesheet" href="{{ mix('css/app.css', 'assets/build') }}">
    </head>
    <body>
        @hasSection('cover')
            <section class="h-screen bg-blue-500 text-white pt-12 pb-6 px-8">
                <div class="max-w-2xl mx-auto">
                    @yield('cover')
                </div>
            </section>
        @endif

        @hasSection('header')
            <header class="pbb-always bg-blue-500 text-white pt-12 pb-6 px-8">
                <div class="max-w-2xl mx-auto">
                    @yield('header')
                </div>
            </header>
        @endif

        @hasSection('body')
            <div class="p-8">
                <div class="max-w-2xl mx-auto">
                    @yield('body')
                </div>
            </div>
        @endif
    </body>
</html>
