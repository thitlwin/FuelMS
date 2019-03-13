<?php

namespace PowerMs\Http\Controllers;

use Illuminate\Http\Request;

use PowerMs\Http\Requests;
use Charts;
class TestController extends Controller
{
   public function index()
    {
    	$chart = Charts::realtime(url('/path/to/json'), 2000, 'gauge', 'google')
            ->values([65, 0, 260])
            ->labels(['First', 'Second', 'Third'])
            ->responsive(false)
            ->height(300)
            ->width(0)
            ->title("Permissions Chart")
            ->valueName('value');
        // $chart = Charts::multi('bar', 'material')
        //     // Setup the chart settings
        //     ->title("My Cool Chart")
        //     // A dimension of 0 means it will take 100% of the space
        //     ->dimensions(0, 400) // Width x Height
        //     // This defines a preset of colors already done:)
        //     ->template("material")
        //     // You could always set them manually
        //     // ->colors(['#2196F3', '#F44336', '#FFC107'])
        //     // Setup the diferent datasets (this is a multi chart)
        //     ->dataset('Element 1', [5,20,100])
        //     ->dataset('Element 2', [15,30,80])
        //     ->dataset('Element 3', [25,10,40])
        //     // Setup what the values mean
        //     ->labels(['One', 'Two', 'Three']);

        return view('chart', ['chart' => $chart]);
    }
}
