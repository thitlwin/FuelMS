<?php

namespace PowerMs\Http\Controllers;
use PowerMs\Http\Requests\QRcodeRequest;
use Illuminate\Http\Request;

use PowerMs\Http\Requests;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Storage;
class BarcodeController extends Controller
{
     public function barcode()
   {
   	  $sql="select * from users where id=2";
   	  $result=\DB::select($sql);

   	  foreach ($result as $e) {
   	  	$ss=$e->name;
   	  }

      $f='png';
      $s=512;
      $text="This is QrCode";
 
   	   $png = QrCode::format($f)->size($s)->generate($text);
       $png = base64_encode($png);
        $image= "<img src='data:image/png;base64," . $png . "'>";
        //echo $image;
        

   	  return view('barcode');


    }

    public function create()
    {
    	return view('barcodecreate');
    }

    public function save(QRcodeRequest $Requests)
    {
       $data=$Requests->all(); 
       $encrypt=$Requests->encrypt;
       $filename=$Requests->filename;

       return view('barcodeindex',compact('encrypt','filename'));
    }
}
