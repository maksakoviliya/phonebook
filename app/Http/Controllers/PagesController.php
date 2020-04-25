<?php

namespace App\Http\Controllers;

use App\Charts\PhoneBooksChart;
use App\PhoneBook;
use Illuminate\Http\Request;

class PagesController extends Controller
{
  public function home()
  {
    return view('home');
  }
    public function index()
    {
      $chart = new PhoneBooksChart;

      $total = 0;
      // $data = PhoneBook::all()
      //                 ->groupBy(function($item){ 
      //                   return $item->created_at->format('d-M-y');
      //                 })
      //                 ->map(function ($item) use (&$total) {
      //                   $total = count($item) + $total;
      //                   return $total;
      //                 });
      
      // $chart->labels($data->keys());
      // $chart->dataset('My dataset', 'line', $data->values());

      $data = collect([]); // Could also be an array
      $labels = collect([]);

      for ($days_backwards = 7; $days_backwards >= 0; $days_backwards--) {
          // Could also be an array_push if using an array rather than a collection.
          $labels->push(today()->subDays($days_backwards)->format('d-m-Y'));
          $todayCount = PhoneBook::whereDate('created_at', today()->subDays($days_backwards))->count();
          // dd($todayCount);
          $data->push($todayCount+$total);
          $total = $todayCount+$total;
      }
      $data->push($data->max()+1);
      $chart = new PhoneBooksChart;
      $chart->labels($labels);
      $chart->dataset('Справочники', 'line', $data);
      $chart->options([
        'legend' => [
            'labels' => [
                // This more specific font property overrides the global property
                'fontColor' => '#fff'
            ]
        ],
       
    ]);


      return view('dashboard', compact('chart'));
    }
}
