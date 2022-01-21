<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\aqar;

class HomeController extends Controller
{




    
    
    public function home()
    {
 
        $vipAqars = aqar::where('status',1)->where('vip', true)->take(5)->get();
        // $saleAqars = aqar::where('status',1)->where('offer_type', 1)->orWhere('offer_type',2)->take(4)->get();
        // $rentAqars = aqar::where('status',1)->where('offer_type', 3)->orWhere('offer_type',4)->take(5)->get();
        
        $saleAqars = aqar::where('status',1)->whereIn('offer_type', [1, 2])->take(4)->get();
        $rentAqars = aqar::where('status',1)->whereIn('offer_type', [3, 4])->take(5)->get();
        return view('home', compact('vipAqars', 'saleAqars', 'rentAqars'));
    }

    
}
