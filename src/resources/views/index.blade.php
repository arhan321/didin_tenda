<!DOCTYPE html>
<html lang="en">
  @include('layouts.inc.header')

  <body>
  @include('layouts.inc.navbar')
    
    @yield('section')


  @include('layouts.inc.footers')
  @include('layouts.inc.script')
  @yield('script')
  </body>
</html>
