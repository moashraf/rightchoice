<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;

use App\Models\aqar;
use App\Models\OfferTypes;
use App\Models\Category;
use App\Models\TypeOfProp;
use App\Models\Calltime;
use App\Models\Location;
use App\Models\Compound;
use App\Models\Governrate;
use App\Models\SubArea;
use App\Models\District;
use App\Models\Finish_type;
use App\Models\license_type;
use App\Models\Mzaya;
use App\Models\MzayaAqar;
use App\Models\Images;
use App\Models\Floor;
use App\Models\Slider;
use App\Models\Service;
use App;

class SiteHomeController extends Controller

{


  




    

    public function home($lang)

    {

        App::setLocale($lang);
        $locale = App::currentLocale();
       // dd($locale);
        //dd("ddd");
        $offers = OfferTypes::all();
        $vipAqars = aqar::where('status',1)->where('vip', 1)->with('governrateq')->with('districte')->with('subAreaa')->with('images') ->latest()->take(10)->get();
        $saleAqars = aqar::where('status',1)->where('status',1)->whereIn('offer_type', [1, 2])->with('governrateq')->with('districte')->with('subAreaa')->with('images')->latest()->take(4)->get();
        $rentAqars = aqar::where('status',1)->where('status',1)->whereIn('offer_type', [3, 4])->with('governrateq')->with('districte')->with('subAreaa')->with('images')->latest()->take(5)->get();
       
        $mostRecent = aqar::where('status',1)->where('status',1)->with('governrateq')->with('districte')->with('subAreaa')->with('images')->take(5)->inRandomOrder()->get();
       
             //  dd($saleAqars);

        $services = Service::take(4)->get();
        $user = Auth::user();
        
        $slider = Slider::all();
        

        return view('SiteHome', compact('vipAqars', 'saleAqars', 'rentAqars', 'offers', 'mostRecent','slider', 'services'));

    }



    

}

