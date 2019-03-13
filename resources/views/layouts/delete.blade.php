<div class="modal fade" role="dialog" id="delete_{{$id}}">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
		{!! Form::open(['route'=>$route,'method'=>'post','id'=>'form_'.$id]) !!}			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Confirmation</h4>
			</div>
			{{ Form::hidden('id',$id) }}
			<div class="modal-body"> 
				<div class="form-group">										
					<p>{{trans('form.delete_confirm_msg')}}</p>					
				</div>
			</div>
			<div class="modal-footer">
				{!! Form::submit(trans('form.delete'),['class'=>'btn btn-danger','form'=>'form_'.$id]) !!}
				<button type="button" class="btn btn-default" data-dismiss="modal" >{{trans('form.cancel')}}</button>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>