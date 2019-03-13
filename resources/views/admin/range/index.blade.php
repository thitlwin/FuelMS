@extends('layouts.app')

@section('contentheader')

	@section('contentheader_title')	
	{{trans('range.range')}}		
	@endsection	
@endsection
@section('breadcumb')
		  <li class="active">{{trans('range.range')}}</li> 
@endsection

@section('content')
	<div class="container-fluid full-screen">
		<div class="row">			
				<div class="panel panel-default">
				@include('vendor.toast.messages')
					<?php Session::forget('toasts'); ?>	
					
					<div class="panel-heading">{{trans('range.list')}}
					<a href="{{url('control-panel/range/create')}}" class="btn btn-primary btn-xs pull-right">{{trans('range.add')}}</a>
					</div>

					<div class="panel-body">
					<table class="table table-bordered table-striped table-hover" id="ranges_list">
							<thead>
								<th>{{trans('range.range')}}</th>
								<th>{{trans('range.min')}}</th>
								<th>{{trans('range.max')}}</th>
								<th></th>
							</thead>
							<tbody>
							@if(count($range)>0)
								@foreach($range as $d)
								<tr>
									<td>{{$d->unit_name}}</td>
									<td>{{$d->min}}</td>
									<td>{{$d->max}}</td>
									<td>
									{{Form::open(['route'=>'range.edit','method'=>'get'])}}
										{{Form::hidden('id',$d['id'])}}
									<button type="submit" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-edit"></span></button>
									<button type="button" class="btn btn-danger btn-xs" data-toggle='modal' data-target="#delete_{{$d['id']}}" ><span class="glyphicon glyphicon-remove"></span></button>
									{{Form::close()}}									
									</td>
									@include('layouts.delete',['id'=>$d['id'],'route'=>'range.delete'])
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
    	$('#ranges_list').DataTable({
    		responsive: true
    	});
	});
</script>
@endsection

