@extends('layouts.app')

@section('additional_scripts')
{!! Charts::assets() !!}
@endsection

@section('contentheader')
	@section('contentheader_title')	
		{{ trans('user.user') }} {{ trans('form.graphs') }}
	@endsection	
@endsection
@section('breadcumb')
		<li class="active">{{ trans('user.user') }} {{ trans('form.graphs') }}</li>     
@endsection

@section('content')
<div class="row">
<div class="col-md-2">
	<div class="panel panel-default">
		<div class="panel-body">
			{!!Form::open(['route'=>'admin.users_graphs','method'=>'get','class'=>'form-inline'])!!}	
				{!! Form::select('selected_year',$years,$selected_year,['class'=>'form-control'])!!}
				{!! Form::submit('Search',['class'=>'btn btn-primary'])!!}
			{!!Form::close()!!}
		</div>	
	</div>
</div>
<div class="col-md-10">
	<div class="container-fluid full-screen">
				<div class="panel panel-default">
					<div class="panel-heading">
						<ul class="nav nav-tabs nav-justified">
							<li class="active"><a href="#bar_content" data-toggle="tab" href="#bar_content">Bar Chart</a></li>
							<li><a data-toggle="tab" href="#line_content">Line Chart</a></li>
							<li><a data-toggle="tab" href="#pie_content">Donut Chart</a></li>
						</ul>
					</div>

					<div class="panel-body">						  
						
						<div class="tab-content">
							<div id="bar_content" class="tab-pane fade in active">
								{!! $bar_chart->render() !!}
							</div>
							<div id="line_content" class="tab-pane fade">
								{!! $line_chart->render() !!}
							</div>
							<div id="pie_content" class="tab-pane fade">
								{!! $donut_chart->render() !!}
							</div>
						</div>						
				
					</div>					
				</div>			
		</div>		
	</div>	
</div>
@endsection 
