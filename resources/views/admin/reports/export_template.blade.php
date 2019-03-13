<table class="table table-bordered table-striped table-hover">
							<tbody>
								@if(count($data_rows)>0)
								<tr><th colspan="{{count($columns)+1}}">Electrical Usage of {{$device_name}} from {{$start_date}} to {{$end_date}}</th></tr>
								<tr>						
									<th style="text-align: center;">{{trans('form.no')}}</th>
									<th style="text-align: center;">{{trans('form.created_at')}}</th>
									@foreach($columns as $c)			
									<th style="text-align: center;">{{ $c }}</th>								
									@endforeach
								</tr>
								<?php $i=1;?>
								@foreach($data_rows as $row)
								<tr>				
									<td style="text-align: center;">{{$i++}}</td>
									<td style="text-align: center;">{{$row->created_at}}</td>									
									@foreach($columns as $c)	
									<td style="text-align: right;">{{ $row->$c }}</td>								
									@endforeach
								</tr>								
								@endforeach
								@endif
							</tbody>
							

						</table>

