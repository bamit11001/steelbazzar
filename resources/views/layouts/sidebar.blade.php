<!doctype html>
<html>
<head>
    @include('includes.head')
</head>
<body>

        @include('includes.header')
        <aside id="slide-out" class="side-nav white fixed">
            @include('includes.sidebar')
        </aside>
            @yield('content')
   
        @include('includes.footer')
  

</div>
</body>
</html>