<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane active" id="control-sidebar-home-tab">
            <ul class="sidebar-menu">            
            <li><a href="{{ url('control-panel/device_settings') }}"><i class='fa fa-cog'></i> <span>{{trans('setting.device_setting')}}</span></a></li>
            {{-- <!-- <li><a href="{{ url('control-panel/report_settings') }}"><i class='fa fa-cog'></i> <span>{{trans('setting.report_setting')}}</span></a></li> 
                 <li><a href="{{ route('unit_settings.show') }}"><i class='fa fa-cog'></i> <span>{{trans('setting.unit_setting')}}</span></a></li> --> --}}
            @if(Auth::user()->user_type_id==2)
            <li><a href="{{ url('control-panel/dashboard_settings') }}"><i class='fa fa-cog'></i> <span>{{ trans('dashboard.dashboard_setting') }} </span></a></li>
            
            <li><a href="{{ route('log') }}"><i class='fa fa-link'></i><span>{{ trans('form.logs') }}</span></a></li>
            @endif
            </ul>
            
        </div><!-- /.tab-pane -->
        <!-- Stats tab content -->
        <div class="tab-pane" id="control-sidebar-stats-tab">{{ trans('adminlte_lang::message.statstab') }}</div><!-- /.tab-pane -->
        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">
            <h3 class="control-sidebar-heading">{{ trans('adminlte_lang::message.progress') }}</h3>
            <ul class='control-sidebar-menu'>
                <li>
                    <a href='javascript::;'>
                        <h4 class="control-sidebar-subheading">
                            {{ trans('adminlte_lang::message.customtemplate') }}
                            <span class="label label-danger pull-right">70%</span>
                        </h4>
                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                        </div>
                    </a>
                </li>
            </ul><!-- /.control-sidebar-menu -->
        </div><!-- /.tab-pane -->
    </div>
</aside><!-- /.control-sidebar

<!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
<div class='control-sidebar-bg'></div>