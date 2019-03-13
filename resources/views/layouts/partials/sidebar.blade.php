<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                       <center>
                        <a href="http://www.pecmyanmar.com" target="_blank">
                            <img src="{{asset('/img/pecNew.png')}}"   width="120" height="50">
                            <center style="padding-top: 5px;">Pro Engineering Co., Ltd</center>
                        </a>
                    </center>
            </div>
        @endif

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <!-- <li class="header">{{ trans('adminlte_lang::message.header') }}</li>
            <li class="active"><a href="{{ route('user.home') }}"><i class='fa fa-link'></i> <span>{{ trans('form.home') }}</span></a></li> -->

            <li class="treeview">
                <a href="{{ route('dashboard.create') }}"><i class='fa fa-tachometer'></i> <span>{{ trans('dashboard.dashboard') }}</span></a>
            </li>

            <!-- Optionally, you can add icons to the links -->
            @if(Auth::user()->user_type_id==2)
            <li class="treeview">
                <a href="#"><i class='fa fa-user'></i> <span>{{ trans('user.users') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('user.create') }}"> <i class='fa fa-plus'></i> <span>{{ trans('user.add') }}</span></a></li>
                    <li><a href=" {{ route('user.index') }}"> <i class="fa fa-list"></i> <span>{{ trans('user.list') }}</span></a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class='fa fa-plug'></i> <span>Device</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('device.create') }}"> <i class='fa fa-plus'></i> <span>{{trans('device.add')}}</span></a></li>
                    <li><a href=" {{ route('device.index') }}"> <i class="fa fa-list"></i> <span> {{trans('device.list')}}</span></a></li>
                </ul>
            </li>


             <li class="treeview">
                <a href="#"><i class='fa fa-map-marker'></i> <span>{{trans('location.location')}}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('location.create') }}"> <i class='fa fa-plus'></i> <span>{{trans('location.add')}}</span></a></li>
                    <li><a href=" {{ route('location.index') }}"> <i class="fa fa-list"></i> <span> {{trans('location.list')}}</span></a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#"><i class='fa fa-exchange'></i> <span>Range</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
            <li><a href="{{ route('range.create') }}"> <i class='fa fa-plus'></i> <span>{{trans('range.add')}}</span></a></li>
                    <li><a href=" {{ route('range.index') }}"> <i class="fa fa-list"></i> <span> {{trans('range.list')}}</span></a></li>
                </ul>
            </li>
           @endif
           
           <li><a href="{{ route('daily_w_report','hour') }}"> <i class='fa fa-clipboard'></i> <span>{{trans('report.daily_w_report')}}</span></a></li>
             <li class="treeview">
                <a href="#"><i class='fa fa-clipboard'></i> <span>{{trans('report.wh_reports')}}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">                    
                    {{-- <!-- 
                        <li><a href="{{ route('electrical_report_by_day') }}"> <i class='fa fa-bar-chart-o'></i> <span>{{trans('report.report_by_day')}}</span></a></li> 
                        <li><a href="{{ route('electrical_report_by_month') }}"> <i class='fa fa-bar-chart-o'></i> <span>{{trans('report.report_by_month')}}</span></a></li>
                        <li><a href=" {{ route('electrical_report_by_year') }}"> <i class="fa fa-bar-chart-o"></i> <span>{{trans('report.report_by_year')}}</span></a></li>
                        <li><a href="{{ route('electrical_report_by_hour') }}"> <i class='fa fa-bar-chart-o'></i> <span>{{trans('report.report_by_hour')}}</span></a></li>
                        <li><a href="{{ route('electrical_report_by_time') }}"> <i class='fa fa-bar-chart-o'></i> <span>{{trans('report.report_by_time')}}</span></a></li> -->
                    --}}      
                    <li><a href="{{ route('wh_report_by_hour') }}"> <i class='fa fa-bar-chart-o'></i> <span>{{trans('report.report_by_hour')}}</span></a></li> 
                    <li><a href="{{ route('wh_report_by_day') }}"> <i class='fa fa-bar-chart-o'></i> <span>{{trans('report.report_by_day')}}</span></a></li>
                    <li><a href=" {{ route('wh_report_by_month') }}"> <i class="fa fa-bar-chart-o"></i> <span>{{trans('report.report_by_month')}}</span></a></li>
                    <li><a href="{{ route('wh_report_by_date_range') }}"> <i class='fa fa-bar-chart-o'></i> <span>{{trans('report.daily_fwh_report')}}</span></a></li>
                </ul>
            </li>
            @if(Auth::user()->user_type_id==2)
             <li><a href="{{ route('excel_export') }}"> <i class='fa fa-download'></i> <span>{{trans('report.download')}}</span></a></li>
            @endif

        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
