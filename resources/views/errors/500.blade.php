<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
@include('layouts.partials.htmlheader')

<body class="skin-blue">
<div class="container">

        <!-- Main content -->
        <section class="content">
            <div class="error-page">
        <h2 class="headline text-red">500</h2>
        <div class="error-content">
            <h2><i class="fa fa-warning text-red"></i> Oops! Something went wrong.</h2>
            <p><h3>
                We will work on fixing that right away.
                Meanwhile, you may <a href='{{ url('/') }}'>return to dashboard</a> or try using the search form.</h3>
            </p>
        </div>
    </div><!-- /.error-page -->
        </section><!-- /.content -->
</div><!-- ./wrapper -->
</body>
</html>