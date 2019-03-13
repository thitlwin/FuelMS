@extends('layouts.app')

@section('contentheader')
	@section('contentheader_title')	
		{{ trans('form.logs') }}
	@endsection	
@endsection
@section('breadcumb')
		<li class="active">{{ trans('form.logs') }}</li>     
@endsection

@section('content')
<section class="panel panel-default">				
<div class="panel-body">
	<div class="container-fluid">
      <div class="row">      
        <div class="col-sm-3 col-md-2 sidebar">        
          <h4><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>Daily Logs</h4>          
          <div class="list-group">
            @foreach($files as $file)
              <a href="?l={{ base64_encode($file) }}" class="list-group-item @if ($current_file == $file) llv-active @endif">
                {{$file}}
              </a>
            @endforeach
          </div>          
        </div>        
        <div class="col-sm-9 col-md-10 table-container">
          @if ($logs === null)
            <div>
              Log file >50M, please download it.
            </div>
          @else
          <table id="log_list" class="table table-striped">
            <thead>
              <tr>
                <th>Level</th>
                <th>Date</th>
                <th>Content</th>
              </tr>
            </thead>
            <tbody>

@foreach($logs as $key => $log)
<tr>
  <td class="text-{{{$log['level_class']}}}"><span class="glyphicon glyphicon-{{{$log['level_img']}}}-sign" aria-hidden="true">
  </span> &nbsp;{{$log['level']}}</td>
  <td class="date">{{{$log['date']}}}</td>
  <td class="text">
    @if ($log['stack']) <a class="pull-right expand btn btn-default btn-xs" data-display="stack{{{$key}}}"><span class="glyphicon glyphicon-search"></span></a>@endif
    {{{$log['text']}}}
    @if (isset($log['in_file'])) <br />{{{$log['in_file']}}}@endif
    @if ($log['stack']) <div class="stack" id="stack{{{$key}}}" style="display: none; white-space: pre-wrap;">{{{ trim($log['stack']) }}}</div>@endif
  </td>
</tr>
@endforeach

            </tbody>
          </table>
          @endif
          <div>
            <a href="?dl={{ base64_encode($current_file) }}"><span class="glyphicon glyphicon-download-alt"></span> Download file</a>
            -
            <a id="delete-log" href="?del={{ base64_encode($current_file) }}"><span class="glyphicon glyphicon-trash"></span> Delete file</a>
          </div>
        </div>
      </div>
    </div>
 </div>
</section>
@endsection
@section('footer_scripts')
@include('script_datatable')
<script type="text/javascript">
	$(document).ready(function(){
    	$('#log_list').DataTable({
    		responsive: true
    	});
	});
</script>
@endsection
