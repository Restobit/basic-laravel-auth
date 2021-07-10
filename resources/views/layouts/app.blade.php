<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('components.head')
<body id="page-top">
<div id="wrapper">
    @auth
        @if(Route::is('admin.*'))
            @include('components.sidebar')
        @endif
    @endauth
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            @include('components.navbar')

            @if (\Session::has('status'))
                <div class="alert alert-success">
                    <ul>
                        <li>{!! \Session::get('status') !!}</li>
                    </ul>
                </div>
            @endif
            <main class="py-4">
                @yield('content')
            </main>

        </div>
        @include('components.footer')
    </div>

</div>
</body>
</html>
