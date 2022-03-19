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
        <div class="h-screen flex flex-col">
            @hasSection('cover')
                <section class="cover">
                    @yield('cover')
                </section>
            @else
                @hasSection('header')
                    <header class="bg-blue-500 text-white pt-12 pb-6 px-12">
                        @yield('header')
                    </header>
                @endif

                @hasSection('body')
                    <div class="flex-1 border-b mx-12">
                        <div class="py-8">
                            @yield('body')
                        </div>
                    </div>
                @endif
            @endif

            @include('_partials.footer')
        </div>
    </body>
</html>
