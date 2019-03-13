@extends('layouts.app')

@section('contentheader')

	@section('contentheader_title')	
	{{trans('location.location')}}
	@endsection	
@endsection
@section('breadcumb')
		  <li class="active">{{trans('location.location')}}</li> 
@endsection

@section('content')
	<div class="container-fluid full-screen">
		<div class="row">			
				<div class="panel panel-default">
				@include('vendor.toast.messages')
					<?php Session::forget('toasts'); ?>	
					
					<div class="panel-heading">{{trans('location.list')}}
					<a href="{{url('control-panel/location/create')}}" class="btn btn-primary btn-xs pull-right">{{trans('location.add')}}</a>
					</div>

					<div class="panel-body">
					<table class="table table-bordered table-striped table-hover" id="location_list">
							<thead>
								<th>{{trans('location.name')}}</th>
								<th></th>
							</thead>
							<tbody>
							@if(count($location)>0)
								@foreach($location as $d)
								<tr>
									<td>{{$d->location_name}}</td>
									<td>
									{{Form::open(['route'=>'location.edit','method'=>'get'])}}
										{{Form::hidden('id',$d['id'])}}
									<button type="submit" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-edit"></span></button>
									<button type="button" class="btn btn-danger btn-xs" data-toggle='modal' data-target="#delete_{{$d['id']}}" ><span class="glyphicon glyphicon-remove"></span></button>
									{{Form::close()}}									
									</td>
									@include('layouts.delete',['id'=>$d['id'],'route'=>'location.delete'])
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
    	$('#location_list').DataTable({
    		responsive: true
    	});
	});
</script>
@endsection