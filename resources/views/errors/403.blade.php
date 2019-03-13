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
                <h2 class="headline text-yellow"> 403</h2>
                <div class="error-content">
                    <h2><i class="fa fa-warning text-yellow"></i> Access forbidden.</h2>
                    <p><h3>
                        You don't have permission to do this.
                        Meanwhile, you may <a href='{{ url('/') }}'>return to home page.</a>.
                        </h3>
                    </p>
                </div><!-- /.error-content -->
            </div><!-- /.error-page -->
        </section><!-- /.content -->
</div><!-- ./wrapper -->
</body>
</html>