<!DOCTYPE html>

<html lang="en">
<head>
 @include('layouts.partials.fheader')
</head>

<body data-spy="scroll" data-target=".navbar" data-offset="50">

  <div id="navbar-full">
    <div id="navbar">
   @include('layouts.partials.fnavbar')
    </div>
  </div>

   @yield('content')

   @include('layouts.partials.Ffooter')
</body>
</html>
