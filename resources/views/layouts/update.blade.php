<div class="container">
  <div class="modal fade" role="dialog" id="update_{{$id}}">
    <div class="modal-dialog">
      <div class="modal-content"> 
      {!! Form::open(['route'=>$route,'method'=>'post','id'=>'form_'.$id]) !!}
        <div class="modal-header" style="padding:35px 50px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          </span> {{trans('form.changepw')}}</h4>
        </div>
        {{ Form::hidden('id',$id) }}
        <div class="modal-body" style="padding:40px 50px;">
          <form role="form">

       <div class="form-group">
        <div class="row">
          <div class="col-md-3 align_center_right">
          {{ Form::label('new_password',trans('user.new_password'),array('class'=>'control-label'))}}
          </div>
          <div class="col-md-9">
             <input type="textbox" name="new_password" class="form-control" value="abc123">
          </div>
        </div>
        </div>
        <div class="modal-footer">
        {!! Form::submit(trans('form.update'),['class'=>'btn btn-primary','form'=>'form_'.$id]) !!}
        <button type="button"  class="btn btn-default" data-dismiss="modal" >{{trans('form.cancel')}}</button>
      </div>
      {!! Form::close() !!}
      </div>
      
    </div>
  </div> 
</div>
 
