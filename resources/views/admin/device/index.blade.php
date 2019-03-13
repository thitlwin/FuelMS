@extends('layouts.app')

@section('contentheader')

	@section('contentheader_title')	
	{{ trans('device.device') }}			
	@endsection	
@endsection
@section('breadcumb')
		  <li class="active">{{ trans('device.device') }}</li> 
@endsection

@section('content')
	<div class="container-fluid full-screen">
		<div class="row">			
				<div class="panel panel-default">
				@include('vendor.toast.messages')
					<?php Session::forget('toasts'); ?>
					
					<div class="panel-heading">{{ trans('device.list') }}
					<a href="{{route('device.create')}}" class="btn btn-primary btn-xs pull-right">{{ trans('device.add') }}</a>
					</div>

					<div class="panel-body">
					<table class="table table-bordered table-striped table-hover" id="devices_list">
							<thead>
								<th>{{ trans('device.name')}}</th>
								<th>{{trans('device.location')}}</th>
								<th></th>
							</thead>
							<tbody>
							@if(count($device)>0)
								@foreach($device as $d)
								<tr>
									<td>{{$d->name}}</td>
									<td>{{ $d->location_name}}</td>
									<td>
									{{Form::open(['route'=>'device.edit','method'=>'get'])}}
										{{Form::hidden('id',$d->id)}}
									<button type="submit" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-edit"></span></button>
									<button type="button" class="btn btn-danger btn-xs" data-toggle='modal' data-target="#delete_{{$d->id}}" ><span class="glyphicon glyphicon-remove"></span></button>
									{{Form::close()}}									
									</td>
									@include('layouts.delete',['id'=>$d->id,'route'=>'device.delete'])
								</tr>
								@endforeach
							@endif
							</tbody>
						</table>
					</div>
				</div>			
		</div>		
	</div>
@endsection
@section('footer_scripts')
@include('script_datatable')
<script type="text/javascript">
	$(document).ready(function(){
    	$('#devices_list').DataTable({
    		responsive: true
    	});
	});
</script>
@endsection