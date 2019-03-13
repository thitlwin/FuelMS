<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ url('/home') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>P</b>MS</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b> PowerMS</b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
               <li  class="user dropdown"><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-flag-o"></i><i class="caret"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right icons-right">
                            <form action="{{url('/language')}}" method="post">
                                <select name='locale' class="form-control" onchange="this.form.submit()">
                                    <li><i class="icon-flag"></i><option  value="en" {{App::getLocale() == 'en' ? 'selected' : ''}}>English</option></li>
                                    <li><i class="icon-flag"></i><option  value="mm" {{App::getLocale() == 'mm' ? 'selected' : ''}}>Myanmar</option></li>
                                </select>
                                {{csrf_field()}}
                            </form> 
                        </ul>
                </li> 

                

                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <li><a href="{{ url('/register') }}">Register</a></li>
                @else
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->                            
                            @if(Auth::user()->user_type_id==2)
                                <img src="/img/admin_avatar.jpg" class="user-image" alt="User Image" />
                                @else
                                <img src="/img/avatar5.png" class="user-image" alt="User Image" />
                                @endif
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                @if(Auth::user()->user_type_id==2)
                                <img src="/img/admin_avatar.jpg" class="img-circle" alt="User Image" />
                                @else
                                <img src="/img/avatar5.png" class="img-circle" alt="User Image" />
                                @endif
                                <p>
                                    {{ Auth::user()->name }}
                                    <small>Member since Nov. 2012</small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <div class="col-xs-4 text-center">                                    
                                </div>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{route('user.profile.show')}}" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('user.get.logout') }}" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                @endif

                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>