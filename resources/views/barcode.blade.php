@extends('layouts.app')

@section('content')
 

<a download="suisi" name="image1" href="data:image/png;base64, <?php echo base64_encode(QrCode::format('png')->size(500)->encoding('UTF-8')->errorCorrection('H')->generate('‌This is qr code testing'));?> "
                                            class="btn btn-info btn-lg">
          <img src="data:image/png;base64, <?php echo base64_encode(QrCode::format('png')->margin(1)->size(50)->encoding('UTF-8')->errorCorrection('H')->generate('‌This is qr code testing'));?>"><span class="glyphicon glyphicon-download-alt"></span> </a>



@endsection