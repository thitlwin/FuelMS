@extends('layouts.app')

@section('contentheader')
	@section('contentheader_title')	
		{{ trans('user.user') }}		
	@endsection	
@endsection
@section('breadcumb')
		<li class="active">{{ trans('user.users') }}</li>   
@endsection

@section('content')
	<div class="container-fluid full-screen">
		<div class="row">			
				<div class="panel panel-default">
				@include('vendor.toast.messages')
					<?php Session::forget('toasts'); ?>	
					
					<div class="panel-heading">{{ trans('user.list') }}
					<a href="{{route('user.create')}}" class="btn btn-primary btn-xs pull-right">{{ trans('user.add') }}</a>
					</div>

					<div class="panel-body">
						<table class="table table-bordered table-striped table-hover" id="users_list">
							<thead>
								<th>{{ trans('user.name')}}</th>
								<th>{{trans('user.login_name')}}</th>
								<th>{{ trans('user.type')}}</th>
								<th>{{trans('user.nrc')}}</th>
								<th>{{ trans('user.email')}}</th>
								<th>{{ trans('user.phone')}}</th>
								<th>{{ trans('user.address')}}</th>
								<th></th>
							</thead>
							<tbody>
							@if(count($users)>0)
								@foreach($users as $u)
								<tr>
									<td>{{$u->name}}</td>
									<td>{{ $u->login_name }}</td>
									<td>{{ $user_types->getById($u->user_type_id)->name }}</td>
									<td>{{$u->nrc}}</td>
									<td>{{$u->email}}</td>
									<td>{{$u->phone}}</td>
									<td>{{ $u->address }}</td>
									<td>
									{{Form::open(['route'=>'user.edit','method'=>'get'])}}
										{{Form::hidden('id',$u['id'])}}
									<button type="submit" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-edit"></span> {{trans('form.edit')}}</button>
									@if(!$u->is_used)
									<button type="button" class="btn btn-danger btn-xs" data-toggle='modal' data-target="#delete_{{$u['id']}}" ><span class="glyphicon glyphicon-remove"></span> {{trans('form.delete')}}</button>
									@endif
									{{Form::close()}}	
									</td>
									@include('layouts.delete',['id'=>$u['id'],'route'=>'user.delete'])
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
    	$('#users_list').DataTable({
    		responsive: true
    	});
	});
</script>
@endsection
