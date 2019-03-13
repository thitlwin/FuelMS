 <nav class="navbar navbar-ct-blue navbar-fixed-top" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
       <div class="navbar-brand navbar-brand-logo">
                    <div class="logo">
                    <img src="{{asset('/img/Logo.png')}}">
                     </div>
                     <div class="brand" >Power Monitorning System </div>
              </div>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
                   <li><a href="#home" class="smoothScroll"><i class="fa fa-home"></i><p>{{trans('navbar.home')}}</p></a></li>
                <li><a href="#desc" class="smoothScroll"><i class="fa fa-book"></i><p>{{trans('navbar.description')}}</p></a></li>
                <li><a href="#showcase" class="smoothScroll"><i class="fa fa-picture-o"></i><p>{{trans('navbar.showcases')}}</p></a></li>
                <li><a href="#contact" class="smoothScroll"><i class="fa fa-list"></i><p>{{trans('navbar.contact')}}</p></a></li>
                <li class="dropdown"><a href="#"  class="dropdown-toggle" data-toggle="dropdown">
                           <i class="fa fa-user"></i><p>{{trans('navbar.account')}}</p></a>
                            <ul class="dropdown-menu">
                                  <li><a href="{{ url('/login') }}"><i class="glyphicon glyphicon-log-in"></i>&nbsp;&nbsp;{{trans('navbar.login')}}</a></li>
                            </ul>
                </li>
                <li class="dropdown"><a href="{{url('/language')}}"  class="dropdown-toggle" data-toggle="dropdown" >
                                <i class="fa fa-flag"></i><p>{{trans('navbar.languages')}}</p></a>
                                <ul class="dropdown-menu">
                                  <li><a href="{{url('/language?locale=en')}}"><img src="{{asset('/img/gb.png')}}">&nbsp;&nbsp;{{trans('navbar.english')}}</a></li>
                                  <li><a href="{{url('/language?locale=mm')}}"><img src="{{asset('/img/mm.png')}}">&nbsp;&nbsp;{{trans('navbar.myanmar')}}</a></li>
                                 
                                </ul>
                    </li>
      </ul>
    </div>
  </div>
</nav>