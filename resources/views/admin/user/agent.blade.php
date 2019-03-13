@extends('layouts.app')

@section('contentheader')
	@section('contentheader_title')	
		{{ trans('user.agentusers') }}		
	@endsection	
@endsection
@section('breadcumb')
		<li class="active">{{ trans('user.agentusers') }}</li>   
@endsection

@section('content')
	<div class="container-fluid full-screen">
		<div class="row">			
				<div class="panel panel-default">
				@include('vendor.toast.messages')
					<?php Session::forget('toasts'); ?>	
					
					<div class="panel-heading">{{ trans('user.agentlist') }}
					<a href="{{url('users/create')}}" class="btn btn-primary btn-xs pull-right">{{ trans('user.agentadd') }}</a>
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
									@if($u->user_type_id<4)
										<a href="{{url('users/show_users_of/'.$u->id)}}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-user"></span>{{trans('user.users') }}</a>
									@endif
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
