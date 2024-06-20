@include('components.header')

@yield('content')

@stack('scripts')

@include('components.inline-scripts')

@include('components.footer')