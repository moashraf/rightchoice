<?php

namespace App\Http\Controllers;

use App\Models\aqar;
use App\Models\OfferTypes;
use App\Models\Category;
use App\Models\TypeOfProp;
use App\Models\Calltime;
use App\Models\Location;
use App\Models\Compound;
use App\Models\Ads;

use App\Models\Governrate;
use App\Models\SubArea;
use App\Models\District;
use App\Models\Finish_type;
use App\Models\license_type;
use App\Models\Mzaya;
use App\Models\MzayaAqar;
use App\Models\Images;
use App\Models\archive;
use App\Models\Floor;
use App\Models\UserContactAqar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Auth;
use App\Models\wish;
use App\Models\UserPriceing;
use App\Models\Complaints;
use Redirect;
use Config;
use App;

class AqarController extends Controller
{


    public function submited()
    {


        return view('aqars.thenk_you');
    }
 
 
 
    public function search(Request $request,$locale)
    {
        
             
        $cat_id = $request->licat;
        $prop_id = $request->Propertytype;
        $saletype = $request->saletype;
        $governratew = $request->location1;
        $districtw = $request->location2;
        $areaw = $request->area;
        $finishType = $request->finishtype2;
        $minArea = $request->minArea;
        $maxArea = $request->maxArea;
        $minRooms = $request->minRooms;
        $maxRooms = $request->maxRooms;
        $minBaths = $request->minBaths;
        $maxBaths = $request->maxBaths;
        $maz = $request->mzaya;
        $offs = $request->saletype;

       if($request->offerType == 1 || $request->offerType == 2 || $request->offerType == 5 ){
                    $offerTypes = OfferTypes::all()->whereIn('id', [1, 2, 5]);

       }else {
           $offerTypes = OfferTypes::all()->whereIn('id', [3, 4]);
       }
       
       
        $vipAqars = aqar::where('vip', 1)->take(10)->latest()->get();
        $finishes = Finish_type::all();
        $categories = Category::all();


        
        $minPrice = $request->minPrice;
        $maxPrice = $request->maxPrice;
        $keyWords = $request->keywords;
        $offer =    $request->offerType;
        $sort = $request->sort;
      
      
        $key1= str_ireplace("ي","ى", $keyWords);
        $key2= str_ireplace("ة","ه", $key1);

              $allAqars = aqar::where('status',1)->where (function($query) use ($offer)
                        {
                             
                            if (!empty($offer)) {
                                  // dd($offer);
                                  $query ->where('offer_type', $offer);
                        
                            
                            }
                        })->where (function($query) use ($maxPrice , $offer)
                        {
                        
                         if (!empty($maxPrice)) {
                             
                             
                             if ($offer == 3 || $offer == 4)
                             {      $query ->where('monthly_rent', '<=' ,$maxPrice );
                                 
                             }
                             
                             else{   $query ->where('total_price', '<=' ,$maxPrice ); }
                                
                        
                            
                          }
                        })->where (function($query) use ($minPrice , $offer )
                        {
                        
                            if (!empty($minPrice)) {
                               if ($offer == 3 || $offer == 4){

                                  $query ->where('monthly_rent', '>=' ,$minPrice );
                            }
                            else{
                                
                                 $query ->where('total_price', '>=' ,$minPrice );
                                
                            }
                            
                            }
                        })->where (function($query) use ($keyWords)
                        {
                        
                            if (!empty($keyWords)) {
                             
                       $find = array("ى");
        $replace = array("ي");
        $val_filter=(str_replace($find,$replace,$keyWords));

 
                   
                              $query ->orWhere('title', 'like' ,"%{$val_filter}%");
                              
                              
                               $find = array("ي");
                                    $replace = array("ى");
                                     $val_filter22=(str_replace($find,$replace,$keyWords));

 
                              
                              $query ->orWhere('title', 'like' ,"%{$val_filter22}%");
                              $query ->orWhere('title', 'like' ,"%{$keyWords}%");

                           $query ->orWhere('description', 'like' ,"%{$keyWords}%");
                           $query ->orWhere('description', 'like' ,"%{$val_filter22}%");
                           $query ->orWhere('description', 'like' ,"%{$val_filter}%");
                        
                             
                            }
                        })
                      
                        
                     
                      
                        
                        ->with('images')->with('districte')->with('governrateq')->with('images')->with('subAreaa')->paginate(9);
            
       
        $compounds = Compound::all();
        $governrates = Governrate::all();
        $district = District::all();
        $areas = SubArea::select('area')->distinct()->get();
        $mzaya = Mzaya::all();
        return view('aqars.all-aqars',compact('allAqars', 'vipAqars', 'mzaya', 'finishes', 'categories', 'offerTypes', 'governrates', 'district', 'areas',
        'compounds','maxPrice', 'minPrice' , 'keyWords','cat_id', 'prop_id', 'saletype' , 'governratew'
        ,'districtw', 'areaw', 'finishType','minPrice', 'maxPrice' , 'minArea' , 'maxArea'  , 'minRooms' ,'maxRooms' , 'minBaths', 'maxBaths' , 'maz', 'offs','sort'));
   
   
   
    }
    
    
    
    //////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    public function getAqars(Request $request){
        
        
    }
    
    
        //////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    public function filter(Request $request,$locale)
    {

        
        $governrates = Governrate::all();
        $district = District::all();
        $areas = SubArea::distinct()->get();
        $mzaya = Mzaya::all();
      //  $offerTypes = OfferTypes::all()->whereIn('id', [1, 2, 5]);
       $offerTypes = OfferTypes::all() ;
        $vipAqars = aqar::where('status',1)->where('vip',1)->with('governrateq')->with('districte')->with('subAreaa')
        ->with('offerTypes')->latest()->take(10)->get();

       
         $finishes = Finish_type::all();
         $categories = Category::with('all_property_type_of_cat')->get();
         $compounds = Compound::all();
         $keyWords = $request->keywords;
          $cat_id = $request->licat;
        $prop_id = $request->Propertytype;
        $compound_singel = $request->compound;

        $saletype = $request->saletype;
        $governratew = $request->location1;
        $districtw = $request->location2;
        $areaw = $request->area;
        $finishType = $request->finishtype2;
        $minArea = $request->minArea;
        $maxArea = $request->maxArea;
        $minPrice = $request->minPrice;
        $maxPrice = $request->maxPrice;
        $minRooms = $request->minRooms;
        $maxRooms = $request->maxRooms;
        $minBaths = $request->minBaths;
        $maxBaths = $request->maxBaths;
        $maz = $request->mzaya;
        $offs = $request->saletype;
        $sort = $request->sort;
       // dd($request->area);
  
        $searchValues = preg_split('/\s+/', $areaw, -1, PREG_SPLIT_NO_EMPTY); 
                $keys = explode(" ",$areaw);

 
                       if (isset($keys[1])) {
                           
                                                   $areaID= SubArea::where('area', 'like', "%{$keys[0]}%"  )->orWhere('area', 'like', "%{$keys[1]}%" )->get();
                           
                           
                       }else{
                                                   $areaID= SubArea::where('area', 'like', "%{$areaw}%"  )->get();

                       }
                       
                       
      
           

        $allAqars = aqar::where('status',1) ->orderBy('created_at', 'DESC') 
        
        ->when($request->has('location1') && $request->location1 != null,function ($query) use ($request) {

                       $query ->where('governrate_id', $request->location1) ;

                    })
        ->when($request->has('location2') && $request->location2 != null ,function ($query) use ($request) {

                       $query ->where('district_id', $request->location2) ;

                    })
                    
        ->when($request->has('area') && $request->area != null ,function ($query) use ($request,$areaw) {
            
            
            if($request->area != null){
                $keys = explode(" ",$areaw);

                       if (isset($keys[1])) {
                           
                                                   $areaID= SubArea::where('area', 'like', "%{$keys[0]}%"  )->orWhere('area', 'like', "%{$keys[1]}%" )->get();
                           
                           
                       }else{
                                                   $areaID= SubArea::where('area', 'like', "%{$areaw}%"  )->get();

                       }
                   $stack = array();

            foreach($areaID as $valu){
                array_push($stack, $valu->id);

                
            }
                   $query ->whereIn('area_id', $stack);
                    }
         

                    })
        ->when($request->has('compound')&& $request->compound != null,function ($query) use ($request) {
            

                    $query ->where('compound', $request->compound);
                    
         

                    })
     
                    
         ->when($request->has('licat') && $request->licat != null ,function ($query) use ($request) {

                       $query ->where('category', $request->licat) ;

                    })
        
        ->when($request->has('Propertytype') && $request->Propertytype != null,function ($query) use ($request) {

                       $query ->where('property_type', $request->Propertytype) ;

                    })
                    
                    
                            //////////////////////////////////////////////////////////////////////////////////////////////////////


                        /*
                        ->when($request->has('keywords') && $request->keywords  != null,function ($query) use ($keyWords)    {
                                                //  dd("fffff");
                                                    if (!empty($keyWords)) {
                                                    
                                                        // $query ->where('title', 'like', '%' . $keyWords . '%');
                                                        
                        $find = array("ى");
                        $replace = array("ي");
                        $val_filter=(str_replace($find,$replace,$keyWords));

                        
                   
                              $query ->where('title', 'like' ,"%{$val_filter}%");
                              
                              
                               $find = array("ي");
                                    $replace = array("ى");
                                     $val_filter22=(str_replace($find,$replace,$keyWords));

 
                              
                              $query ->orWhere('title', 'like' ,"%{$val_filter22}%");
                              $query ->orWhere('title', 'like' ,"%{$keyWords}%");

                           $query ->orWhere('description', 'like' ,"%{$keyWords}%");
                           $query ->orWhere('description', 'like' ,"%{$val_filter22}%");
                           $query ->orWhere('description', 'like' ,"%{$val_filter}%");

                             
                            }
                        })
                      
              */
           //////////////////////////////////////////////////////////////////////////////////////////////////////
               
                            
                            
                ->where (function($query) use ($keyWords)
                                        {
                                        
                                            if (!empty($keyWords)) {
                                            
                $find = array("ى");
                $replace = array("ي");
                $val_filter=(str_replace($find,$replace,$keyWords));

                
                   
                        $query ->orWhere('title', 'like' ,"%{$val_filter}%");


                        $find = array("ي");
                        $replace = array("ى");
                        $val_filter22=(str_replace($find,$replace,$keyWords));



                        $query ->orWhere('title', 'like' ,"%{$val_filter22}%");
                        $query ->orWhere('title', 'like' ,"%{$keyWords}%");

                        $query ->orWhere('description', 'like' ,"%{$keyWords}%");
                        $query ->orWhere('description', 'like' ,"%{$val_filter22}%");
                        $query ->orWhere('description', 'like' ,"%{$val_filter}%");
                        
                           
                                     
                $areaID= SubArea::where('area', 'like', "%{$keyWords}%"  )
                ->orWhere('area', 'like', "%{$val_filter22}%"  )
                ->orWhere('area', 'like', "%{$val_filter}%"  )->get();
            //dd($areaID);
                        
                                $stack = array();

                foreach($areaID as $valu){
                    array_push($stack, $valu->id);

                    
                }
                   $query ->orwhereIn('area_id', $stack);
                   
                   
                   
                   
                   
                     $DistrictID= District::where('district', 'like', "%{$keyWords}%"  )
                ->orWhere('district', 'like', "%{$val_filter22}%"  )
                ->orWhere('district', 'like', "%{$val_filter}%"  )->get();
          //  dd($DistrictID);
                                        
                                $stack = array();

                foreach($DistrictID as $valu){
                    array_push($stack, $valu->id);

                    
                }
                   $query ->orwhereIn('district_id', $stack);
                   
                   
                   
                   
                             
                            }
                        })
                      
                  
                          //////////////////////////////////////////////////////////////////////////////////////////////////////
 
                /*
                ->where (function($query) use ($keyWords)
                                        {
                                        
                                            if (!empty($keyWords)) {
                $find = array("ى");
                $replace = array("ي");
                $val_filter=(str_replace($find,$replace,$keyWords));

                $find = array("ي");
                $replace = array("ى");
                $val_filter22=(str_replace($find,$replace,$keyWords));
                                                    
                                                    
                                                    
                                $areaID= SubArea::where('area', 'like', "%{$keyWords}%"  )
                                ->orWhere('area', 'like', "%{$val_filter22}%"  )
                                ->orWhere('area', 'like', "%{$val_filter}%"  )->get();
                            //dd($areaID);
                                        
                                $stack = array();

                foreach($areaID as $valu){
                    array_push($stack, $valu->id);

                    
                }
                                $query ->orwhereIn('area_id', $stack);
                                    
                        //  dd($stack);

                                    }})
                                */
                                
                        //////////////////////////////////////////////////////////////////////////////////////////////////////
                
                /*
                ->when($request->has('keywords') && $request->keywords  != null,function ($query) use ($keyWords )    {

                $find = array("ى");
                $replace = array("ي");
                $val_filter=(str_replace($find,$replace,$keyWords));

                $find = array("ي");
                $replace = array("ى");
                $val_filter22=(str_replace($find,$replace,$keyWords));
                                                    
                                                    
                                                    
                                $DistrictID= District::where('district', 'like', "%{$keyWords}%"  )
                                ->orWhere('district', 'like', "%{$val_filter22}%"  )
                                ->orWhere('district', 'like', "%{$val_filter}%"  )->get();
                        //  dd($DistrictID);
                                        
                                $stack = array();

                foreach($DistrictID as $valu){
                    array_push($stack, $valu->id);

                    
                }
                                $query ->whereIn('district_id', $stack);
                                    
                        //  dd($stack);

                                    })
                                    
                                */  
                                    
                                        //////////////////////////////////////////////////////////////////////////////////////////////////////   
                    
                    


                ->when($request->has('saletype') && $request->saletype != null,function ($query) use ($request,$saletype) {

        //dd($saletype);
                           if($saletype == 5){
                    $query->where('finannce_bank', 1);
                            }
                            
                            elseif($saletype == 'ALL1'){

                                $query ->whereIn('offer_type', [1,2]) ;

                            }

                            elseif($saletype == 'ALL2'){

                                $query ->whereIn('offer_type', [3,4]) ;

                            }


                            
                            else{
                                
                                
                            $query ->where('offer_type', $request->saletype) ;
                                //dd($query);
                                
                            } 
                    
                    

                    })
               
        ->when($request->has('finishtype2') && $request->finishtype2 != null,function ($query) use ($request) {

                       $query ->where('finishtype', $request->finishtype2) ;

                    })   
                    
            /*                
                ->when($request->has('minArea'),function ($query) use ($request) {

                            $query ->where('total_area', '<=' , $request->minArea) ;

                            })   
                            
                        
                ->when($request->has('maxArea'),function ($query) use ($request) {

                            $query ->where('total_area', '>=' , $request->maxArea) ;

                            })  
                            
                ->when($request->has('minPrice'),function ($query) use ($request) {

                            $query ->where('total_price', '<=' , $request->minPrice) ;

                            })   
                ->when($request->has('maxPrice'),function ($query) use ($request) {

                            $query ->where('total_price', '>=' , $request->maxPrice) ;

                            }) 
                ->when($request->has('minRooms'),function ($query) use ($request) {

                            $query ->where('rooms', '<=' , $request->minRooms) ;

                            })   
                ->when($request->has('maxRooms'),function ($query) use ($request) {

                            $query ->where('rooms', '>=' , $request->maxRooms) ;

                            }) 
                            
                ->when($request->has('minBaths'),function ($query) use ($request) {

                            $query ->where('baths', '<=' , $request->minBaths) ;

                            })   
                ->when($request->has('maxBaths'),function ($query) use ($request) {

                            $query ->where('baths', '>=' , $request->maxBaths) ;

                            }) 
                            
                */
                
                ->with('districte')->with('governrateq')->with('images')->with('subAreaa')
                //  ->get();

                ->paginate(9);
                //  dd($request->all());

        return view('aqars.all-aqars',compact('allAqars', 'vipAqars', 'mzaya', 'finishes',
         'categories', 'offerTypes', 'governrates', 'district', 'areas','compounds','compound_singel',
        'cat_id', 'prop_id', 'saletype' , 'governratew', 'keyWords' 
        
        ,'districtw', 'areaw', 'finishType','minPrice', 'maxPrice' ,
        'minArea' , 'maxArea'  , 'minRooms' ,'maxRooms' , 'minBaths', 
        'maxBaths' , 'maz', 'offs','sort'));

    }
    
    
        //////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function sorting(Request $request,$locale)
 {
        //dd("55");
        $cat_id = $request->licat;
        $prop_id = $request->Propertytype;
        $saletype = $request->saletype;
        $governratew = $request->location1;
        $districtw = $request->location2;
        $areaw = $request->area;
        $finishType = $request->finishtype2;
        $minArea = $request->minArea;
        $maxArea = $request->maxArea;
        $minPrice = $request->minPrice;
        $maxPrice = $request->maxPrice;
        $minRooms = $request->minRooms;
        $maxRooms = $request->maxRooms;
        $minBaths = $request->minBaths;
        $maxBaths = $request->maxBaths;
        $maz = $request->mzaya;
        $offs = $request->typeoff;
   //   dd("fff");   
        $governrates = Governrate::with('districts')->get();
        $district = District::all();
        $areas = SubArea::distinct()->get();
        $mzaya = Mzaya::all();
        $sort = $request->sort;
        $offerType = $request->typeoff;
           // dd($governrates);
$araay=explode(",",$offerType);
  
 //dd($araay[0]);
        $allAqars = aqar::where('status',1)->whereIn('offer_type', $araay)
        
        ->when( $sort == 1 &&   $araay[0] == 1 , function ($q){
 
                   return $q->orderBy('total_price', 'DESC'); 
            
           
        })
        
        
         ->when( $sort == 1 &&   $araay[0] == 2 , function ($q){
 
                   return $q->orderBy('total_price', 'DESC'); 
            
           
        })
        
          
          ->when( $sort == 1 &&   $araay[0] ==3    , function ($q){
 
                   return $q->orderBy('monthly_rent', 'DESC'); 
            
           
        })
        
           ->when( $sort == 1 &&   $araay[0] ==4    , function ($q){
 
                   return $q->orderBy('monthly_rent', 'DESC'); 
            
           
        })
        
        ->when( $sort == 2 && $araay[0] == 2 , function ($q){
             
            
            return $q->orderBy('total_price', 'ASC'); 
        })  
        
        
             ->when( $sort == 2 &&   $araay[0] == 1 , function ($q){
             
            
            return $q->orderBy('total_price', 'ASC'); 
        })  
        
        
            
        ->when( $sort == 2  &&   $araay[0] == 4 , function ($q){
           return $q->orderBy('monthly_rent', 'ASC');
            
            
         })  
        
          ->when( $sort == 2  &&   $araay[0] == 3 , function ($q){
           return $q->orderBy('monthly_rent', 'ASC');
            
            
         })  
        
        
        
        
        ->when( $sort == 3, function ($q){
            return $q->orderBy('total_area', 'DESC');
        })  
        ->when( $sort == 4, function ($q){
            return $q->orderBy('total_area', 'ASC');
        })
        ->when( $sort == 5, function ($q){
            return $q->orderBy('created_at', 'DESC');
        })
        ->when( $sort == 6, function ($q){
            return $q->orderBy('created_at', 'ASC');
        })  

        ->with('images')->with('governrateq')->with('districte')->with('subAreaa')->with('offerTypes')->latest()->paginate(9);
        $compounds = Compound::all();
      
        //dd(   $allAqars);
        $offerTypes = OfferTypes::all();
        $vipAqars = aqar::where('vip',1)->with('governrateq')->with('districte')->with('subAreaa')->with('offerTypes')->whereIn('offer_type', $araay)->latest()->take(4)->get();
        $finishes = Finish_type::all();
        $categories = Category::all();
         
        return view('aqars.all-aqars',compact('allAqars', 'vipAqars', 'mzaya', 'finishes', 'categories', 'offerTypes', 'governrates', 'district', 'areas','compounds', 'cat_id', 'prop_id', 'saletype' , 'governratew'
        ,'districtw', 'areaw', 'finishType','minPrice', 'maxPrice' , 'minArea' , 'maxArea'  , 'minRooms' ,'maxRooms' , 'minBaths', 'maxBaths' , 'maz', 'offs','sort'));
        
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////


 public function finnance(Request $request,$locale)
    {
        
        
        
        
    

        $cat_id = $request->licat;
        $prop_id = $request->Propertytype;
        $saletype = $request->saletype;
        $governratew = $request->location1;
        $districtw = $request->location2;
        $areaw = $request->area;
        $finishType = $request->finishtype2;
        $minArea = $request->minArea;
        $maxArea = $request->maxArea;
        $minPrice = $request->minPrice;
        $maxPrice = $request->maxPrice;
        $minRooms = $request->minRooms;
        $maxRooms = $request->maxRooms;
        $minBaths = $request->minBaths;
        $maxBaths = $request->maxBaths;
        $maz = $request->mzaya;
        $sort = $request->sort;
        
        

        $governrates = Governrate::with('districts')->get();
        $compounds = Compound::all();
        $district = District::all();
        $areas = SubArea::distinct()->get();
        $mzaya = Mzaya::all();
        $allAqars = aqar::where('status',1)->where('finannce_bank', 1)->with('governrateq')->with('districte')->with('subAreaa')->with('offerTypes')->paginate(9);
       // dd($allAqars);
        $offerTypes = OfferTypes::all();
        $vipAqars = aqar::where('status',1)->where('vip', 1)->with('governrateq')->with('districte')->with('subAreaa')->with('offerTypes')->latest()->take(10)->get();
        $finishes = Finish_type::all();
        $categories = Category::all();
        $off = 1;
        $offs = $off;
        return view('aqars.all-aqars',compact('off','allAqars', 'vipAqars', 'mzaya', 'finishes', 'categories', 'offerTypes', 'governrates', 'district', 'areas','compounds','cat_id', 'prop_id', 'saletype' , 'governratew'
        ,'districtw', 'areaw', 'finishType','minPrice', 'maxPrice', 'minArea' , 'maxArea'  , 'minRooms' ,'maxRooms' , 'minBaths', 'maxBaths' , 'maz', 'offs','sort'));
        
    }
    
    
        //////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
  /*  public function installment(Request $request)
    {
        //
     
        $cat_id = $request->licat;
        $prop_id = $request->Propertytype;
        $saletype = $request->saletype;
        $governratew = $request->location1;
        $districtw = $request->location2;
        $areaw = $request->area;
        $finishType = $request->finishtype2;
        $minArea = $request->minArea;
        $maxArea = $request->maxArea;
        $minPrice = $request->minPrice;
        $maxPrice = $request->maxPrice;
        $minRooms = $request->minRooms;
        $maxRooms = $request->maxRooms;
        $minBaths = $request->minBaths;
        $maxBaths = $request->maxBaths;
        $maz = $request->mzaya;
        $offs = $request->saletype;

        $governrates = Governrate::with('districts')->get();
        $compounds = Compound::all();
        $district = District::all();
        $areas = SubArea::distinct()->get();
        $mzaya = Mzaya::all();
        $allAqars = aqar::where('status',1)->where('offer_type', 2)->with('governrateq')->with('districte')->with('subAreaa')->with('offerTypes')->latest()->paginate(9);
       
        $offerTypes = OfferTypes::all();
        $vipAqars = aqar::where('status',1)->where('vip', 1)->with('images')->with('governrateq')->with('districte')->with('subAreaa')->with('offerTypes')->inRandomOrder()->take(5)->get();
        $finishes = Finish_type::all();
        $categories = Category::all();
         
        $off = 2;
         
         
         
        return view('aqars.all-aqars',compact('off','allAqars', 'vipAqars', 'mzaya', 'finishes', 'categories', 'offerTypes', 'governrates', 'district', 'areas','compounds','cat_id', 'prop_id', 'saletype' , 'governratew'
        ,'districtw', 'areaw', 'finishType', 'minPrice', 'maxPrice','minArea' , 'maxArea'  , 'minRooms' ,'maxRooms' , 'minBaths', 'maxBaths' , 'maz', 'offs'));
        
    }
    public function rentNew(Request $request)
    {
        //

        $cat_id = $request->licat;
        $prop_id = $request->Propertytype;
        $saletype = $request->saletype;
        $governratew = $request->location1;
        $districtw = $request->location2;
        $areaw = $request->area;
        $finishType = $request->finishtype2;
        $minArea = $request->minArea;
        $maxArea = $request->maxArea;
        $minPrice = $request->minPrice;
        $maxPrice = $request->maxPrice;
        $minRooms = $request->minRooms;
        $maxRooms = $request->maxRooms;
        $minBaths = $request->minBaths;
        $maxBaths = $request->maxBaths;
        $maz = $request->mzaya;
        $offs = $request->saletype;

        $governrates = Governrate::with('districts')->get();
        $compounds = Compound::all();
        $district = District::all();
        $areas = SubArea::distinct()->get();
        
        $categories = Category::all();;
        $mzaya = Mzaya::all();
        $allAqars = aqar::where('status',1)->where('offer_type', 3)->with('governrateq')->with('districte')->with('subAreaa')->with('offerTypes')->latest()->paginate(9);
        $offerTypes = OfferTypes::all();
        $vipAqars = aqar::where('status',1)->where('vip', 1)->with('images')->inRandomOrder()->with('governrateq')->with('districte')->with('subAreaa')->with('offerTypes')->inRandomOrder()->take(5)->get();
        $finishes = Finish_type::all();
        $off = 3;
        
        return view('aqars.all-aqars',compact('off','allAqars', 'vipAqars', 'mzaya', 'finishes', 'categories', 'offerTypes', 'governrates', 'district', 'areas','compounds','cat_id', 'prop_id', 'saletype' , 'governratew'
        ,'districtw', 'areaw', 'finishType','minPrice', 'maxPrice', 'minArea' , 'maxArea'  , 'minRooms' ,'maxRooms' , 'minBaths', 'maxBaths' , 'maz', 'offs'));
    }
    public function rentFinish(Request $request)
    {
        //

        $cat_id = $request->licat;
        $prop_id = $request->Propertytype;
        $saletype = $request->saletype;
        $governratew = $request->location1;
        $districtw = $request->location2;
        $areaw = $request->area;
        $finishType = $request->finishtype2;
        $minArea = $request->minArea;
        $maxArea = $request->maxArea;
        $minPrice = $request->minPrice;
        $maxPrice = $request->maxPrice;
        $minRooms = $request->minRooms;
        $maxRooms = $request->maxRooms;
        $minBaths = $request->minBaths;
        $maxBaths = $request->maxBaths;
        $maz = $request->mzaya;
        $offs = $request->saletype;

        $governrates = Governrate::with('districts')->get();
        $compounds = Compound::all();
        $district = District::all();
        $areas = SubArea::distinct()->get();
        $categories = Category::all();;
        $mzaya = Mzaya::all();
        $allAqars = aqar::where('status',1)->where('offer_type', 4)->with('governrateq')->with('districte')->with('subAreaa')->with('offerTypes')->paginate(9);
        $offerTypes = OfferTypes::all();
        $vipAqars = aqar::where('status',1)->where('vip', 1)->with('images')->with('governrateq')->with('districte')->with('subAreaa')->with('offerTypes')->inRandomOrder()->take(5)->get();
        $finishes = Finish_type::all();
        $off = 4;

        return view('aqars.all-aqars',compact('off','allAqars', 'vipAqars', 'mzaya', 'finishes', 'categories', 'offerTypes', 'governrates', 'district', 'areas','compounds','cat_id', 'prop_id', 'saletype' , 'governratew'
        ,'districtw', 'areaw', 'finishType','minPrice', 'maxPrice', 'minArea' , 'maxArea'  , 'minRooms' ,'maxRooms' , 'minBaths', 'maxBaths' , 'maz', 'offs'));
        
    }*/
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    

        //////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function create($locale)
    {
      
       // dd(App::currentLocale());
        $offerTypes = OfferTypes::all();
        $categories = Category::all();
        $lic_types = license_type::all();
        $properties = TypeOfProp::all();
        $floors = Floor::all();
        $compounds = Compound::all();
        $governrate = Governrate::all();
    
        $district = District::all();
        $areas = SubArea::distinct()->get();
        $calls = CallTime::all();
        $finishes = Finish_type::all();
        $mzaya = Mzaya::all();
        
        return view('aqars.create',compact('compounds','floors', 'offerTypes', 'categories', 'properties', 'governrate', 'district', 'areas', 'calls', 'finishes','lic_types','mzaya'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     
     
         //////////////////////////////////////////////////////////////////////////////////////////////////////
    public function store(Request $request)
    {
 //dd("ff");
                        
        if (!empty($request->area_id)) {
                $areaCheck =  SubArea::where('area', $request->area_id)->orWhere('area', $request->area_id)->first();
            if($areaCheck){
               $areaTab = $areaCheck->id; 
            }else{
            $areaTab = new SubArea();
            $areaTab->area = $request->area_id;
            $areaTab->save();

            }

         }

        
         if (!empty($request->compound)) {
                $compoundCheck =  Compound::where('compound', $request->compound)->orWhere('compound', $request->compound)->first();
            if($compoundCheck){
               $compound = $compoundCheck->id; 
            }else{
            $compound = new Compound();
            $compound->compound = $request->compound;
            $compound->save();

            }
           

         }
       
        $findSlug = false;
       // $cheackSlug = aqar::where('status',1)->where('slug',Str::slug($request->title, '-'))->first();
        $cheackSlug = aqar::where('slug',Str::slug($request->title, '-'))->first();
        
       
        if($cheackSlug){
            
           $findSlug = true;
        }
        
  //      dd($findSlug);
        $aqar = new aqar();
        $archive = new archive();
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:60',
            'description' => 'required|min:5|max:5100',
            'call_id' => 'required|integer',
            'governrate_id' => 'required|integer',
            'district_id' => 'integer',
        //    'photos_id' => ' mimes:jpg,png,jpeg',
            
           
            'category' => 'required|integer',
            'property_type' => 'required|integer',
            'offer_type' => 'required|integer',
            'total_area' => 'required|integer',
           // 'finishtype' => 'required_unless:property_type,9|nullable|integer',
            //'rooms' => 'required_unless:property_type,9,7,22,23|nullable|integer',
           // 'baths' => 'required_unless:property_type,9,7,22,23|nullable|integer',
           // 'floor' => 'required_unless:property_type,2,7,22,23|nullable|integer',
            'number_of_floors' => 'required_if:property_type,7,22,23|nullable|integer',
            'finannce_bank' => 'required_if:offer_type,1,2|nullable|integer',
            'trade' => 'required_if:offer_type,1,2|nullable|integer',
            'licensed' => 'required_if:offer_type,1,2|nullable|integer',
            'installment_time' => 'required_if:offer_type,2|nullable|integer',
            //'installment_value' => 'required_if:offer_type,2|nullable|integer',
           // 'installment_time' => 'required_if,reciving,0|integer',
            'rec_time' => 'required_if:reciving,0|max:255|nullable',
            'reciving' => 'required_if:offer_type,2|nullable|integer',
            'downpayment' => 'required_if:offer_type,2|nullable|integer',
            //'mtr_price' => 'required_if:offer_type,2|nullable|integer',
            'monthly_rent' => 'required_if:offer_type,3,4|nullable|integer',
            'total_price' => 'required_if:offer_type,1,2|nullable|integer',
            'license_type' => 'required_if:property_type,9|nullable|integer',
            //'mzaya' => 'required|array|min:1',
            'endorsement' => 'required'
            ]);
            
     
        //$mzaya_implode = implode(",",$arr);
     if(!$validator->fails()){
        $aqar->title = request('title');
        // $aqar->slug = request('title');
        
        
        if($findSlug == true){
            
                
                $namerand = '-'.rand(1,999900).rand(1,999900).rand(1,999900).'-';

            
             $aqar->slug = Str::slug($request->title, '-').$namerand.'-'.Str::random(2);
        }else{
          //  dd($findSlug);
         $aqar->slug = Str::slug($request->title, '-');  
        }
        $aqar->description = request('description');
        $aqar->vip = 0;
        $aqar->finannce_bank = request('finannce_bank');
        $aqar->trade = request('trade');
        $aqar->licensed = request('licensed');
        $aqar->number_of_floors = request('number_of_floors');
        $aqar->total_area = request('total_area');
        $aqar->rooms = request('rooms');
        $aqar->baths = request('baths');
        $aqar->floor = request('floor');
        $aqar->downpayment = request('downpayment');
        $aqar->installment_time = request('installment_time');
        //$aqar->installment_value = request('installment_value');
        //$aqar->mtr_price = request('mtr_price');
        $aqar->reciving = request('reciving');
        $aqar->rec_time = request('rec_time');
        $aqar->monthly_rent = request('monthly_rent');
        $aqar->call_id = request('call_id');
        $aqar->offer_type = request('offer_type');
        $aqar->property_type = request('property_type');
        $aqar->license_type = request('license_type');
        $aqar->user_id = auth()->user()->id;
        $aqar->category = request('category');
    
        $aqar->endorsement =1;
        $aqar->finishtype = request('finishtype');
        
                
        if($request->total_price  == NULL){
                     $aqar->total_price = 0;

        }
else{
        $aqar->total_price = request('total_price');

}
 
 
        //$aqar->mzaya = 'refer_to_mzayAqar_table';
        $arr = request('mzaya');      
        $aqar->governrate_id = request('governrate_id');
        if (!empty($request->area_id)) {
            if($areaCheck){
            $aqar->area_id = $areaTab;
            }else{
              $aqar->area_id = $areaTab->id;  
            }
        }
            if (!empty($request->compound)) {
            if($compoundCheck){
            $aqar->compound = $compound;
            }else{
              $aqar->compound = $compound->id;  
            }
        }

        if($request->offer_type == 1 || $request->offer_type == 2 || $request->offer_type == 5){
            $aqar->points_avail = aqar::pointCalculate($request->total_price);
        }else {
            $aqar->points_avail = aqar::pointCalculateRent($request->monthly_rent);;
        }
        $aqar->district_id = request('district_id');
            
    
//        dd(request('photos_id'));

        $aqar->save();
        $id = $aqar->id;
        // dd($request->mzaya);
        if($request->mzaya){
             foreach($request->mzaya as $maz)
                {
             
                $mazaqar = new MzayaAqar();
                $mazaqar->aqar_id = $aqar->id;
                $mazaqar->mzaya_id = $maz;
                $mazaqar->save();
                }
        }
       
       
                   if($request->photos_id){ 
                        $counter=0;
                            foreach($request->photos_id as $photo1)
                            {
    
      //  dd(getimagesize($photo1)["bits"]);
                            $namerand = '-'.rand(1,999900).rand(1,999900).rand(1,999900).'-';
                            $imageNameGallery = $namerand . '.' . $photo1->getClientOriginalExtension();
                            $photo1->move(base_path() . '/public/images/', $imageNameGallery);
                            
                            $news_photo = new Images();
                            $news_photo->aqar_id = $aqar->id;
                            $news_photo->img_url = "$imageNameGallery";
                            /*if($counter == 1) {
                                $news_photo->main_img = 1;
                            }else {
                                
                            }*/
    
                            if($request->main_img){
                                if( $counter == $request->main_img){
                                    $news_photo->main_img = 1;
        
                                }
                                
                                
                                else{  $news_photo->main_img =0;  }
                               }else{
                                if($counter == 1) {
                                    $news_photo->main_img = 1;
                                }else {
                                    $news_photo->main_img = 0;
    
                                }
                               }
                            $news_photo->save();
                            $counter++;
                            if($counter >= 8){
                                break;
                                }
                            }
                    
                    }
                        
                        
                        
                        
                        
                        /***************** store to archive **************/
                        
                                $archive->title = request('title');
        // $aqar->slug = request('title');
        if($findSlug == true){
                                        $namerand = '-'.rand(1,999900).rand(1,999900).rand(1,999900).'-';

             $archive->slug = Str::slug($request->title, '-').$namerand.'-'.Str::random(2);
        }else{
            
         $archive->slug = $aqar->slug;  
        }
        $archive->description = $aqar->description;
        $archive->vip = 0;
        $archive->finannce_bank = $aqar->finannce_bank;
        $archive->trade = $aqar->trade;
        $archive->licensed = $aqar->licensed;
        $archive->number_of_floors = $aqar->number_of_floors;
        $archive->total_area = $aqar->total_area;
        $archive->rooms = $aqar->rooms;
        $archive->baths = $aqar->baths;
        $archive->floor = $aqar->floor;
        $archive->downpayment = $aqar->downpayment;
        $archive->installment_time = $aqar->installment_time;

        $archive->reciving = $aqar->reciving;
        $archive->rec_time = $aqar->rec_time;
        $archive->monthly_rent = $aqar->monthly_rent;
        $archive->call_id = $aqar->call_id;
        $archive->offer_type = $aqar->offer_type;
        $archive->property_type = $aqar->property_type;
        $archive->license_type = $aqar->license_type;
        $archive->user_id = auth()->user()->id;
        $archive->category = $aqar->category;
    
        $archive->endorsement =1;
        $archive->finishtype = $aqar->finishtype;
        $archive->total_price = $aqar->total_price;
        $archive->governrate_id = $aqar->governrate_id;
        $archive->area_id = $aqar->area_id;
        $archive->compound = $aqar->compound;
        $archive->points_avail = $aqar->points_avail;

            

        
        $archive->district_id =$aqar->district_id;
        $archive->org_aqar_id = $aqar->id;
            
    
//        dd(request('photos_id'));

        $archive->save();

       
                       
                }                    

         /* if (!empty($request->main_img)) {
                
            $photoexplode = $request->main_img->getClientOriginalName();
       $photoexplode = explode(".", $photoexplode);
       $namerand = '-'.rand(1,900).'-';
       $namerand.= $photoexplode[0];
       $imageNameGallery2 = $namerand . '.' . $request->main_img->getClientOriginalExtension();
       $request->main_img->move(base_path() . '/public/images/', $imageNameGallery2);
       $input['main_img']=    $imageNameGallery2; 
       $main_photo = new Images();
                        $main_photo->aqar_id = $aqar->id;
                        $main_photo->img_url = "$imageNameGallery2";
                        $main_photo->main_img = 1;
                        $main_photo->save();
       
       }*/
      
     // return redirect("/")->with('status', '  تم الحفظ بنجاح!');
     
     $message= 'تم اضافه الاعلان بنجاح و جاري المراجعه';
     if($validator->fails()) {
         
        return Redirect::back()->withErrors($validator)->withInput($request->input());
    }else {

        session()->flash('success', 'تم اضافه الاعلان بنجاح و جاري المراجعه');
        return Redirect()->to('ar/aqar-added')->with('message', $message)->with('id',$id);
      //  view('th', compact('message', 'id'));
        }

        //        return redirect("aqars/$aqar->id")->with('status', '  تم الحفظ بنجاح!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\aqar  $aqar
     * @return \Illuminate\Http\Response
     */
     
         //////////////////////////////////////////////////////////////////////////////////////////////////////
    public function show($locale, $aqar)
{ 
  // dd(phpinfo());
   $random_ads= Ads::inRandomOrder()->first();
       //   dd($random_ads);
            $aqar_chexk= aqar::where('slug',$aqar)->with('mzaya')->with('compounds')->with('governrateq')
            ->with('districte')->with('subAreaa')->with('images')->with('finishType')->with('callTimes')
             ->with('propertyType')->with('offerTypes')->with('floorNo')  ->first();
    
    
           if (empty($aqar_chexk)) {  return redirect()->route('homeBlade', [ 'locale'=>$locale]) ;}


      if(Auth::user() && Auth::user()->id == $aqar_chexk->user_id ){
           
         // dd($aqar);
             $aqar = aqar::where('slug',$aqar)->with('mzaya')->with('compounds')->with('governrateq')
            ->with('districte')->with('subAreaa')->with('images')->with('finishType')->with('callTimes')
             ->with('propertyType')->with('offerTypes')->with('floorNo') ->first();
          $fgfg=55;
          
      
      
            }
      
      else{
             
            $aqar = aqar::where('slug',$aqar)->with('mzaya')->with('compounds')->with('governrateq')
            ->with('districte')->with('subAreaa')->with('images')->with('finishType')->with('callTimes')
             ->with('propertyType')->with('offerTypes')->with('floorNo')->where('status', 1)  ->first();
          
      }
 
 
        if (!empty($aqar)) {
    
 //dd( $aqar->offer_type);
       
        $allAqars = aqar::where('offer_type',$aqar->offer_type)
        ->where('category',$aqar->category) 
        ->where('district_id',$aqar->district_id)
        ->where('status',1)
        ->where('id','!=',$aqar->id)
        ->with('images')->with('governrateq')->with('districte')
        ->with('subAreaa')->inRandomOrder()->take(5)->latest()->get();
        $getUser = Auth::user();
         
           // dd($userSeenAqar);
        $show = false;
        $show2 = false;
            if(Auth::user() && Auth::user()->userpricin){
                         $userSeenAqar= UserContactAqar::with('all_aqat_viw')->where('aqars_id',$aqar->id)->where('user_id',$getUser->id)->first();
               if( $userSeenAqar != null  || Auth::user()->id ==    $aqar->user->id){
              
                             $show2 = true;
                        $show = true;
                    }else if( Auth::user()->userpricin->current_points >= $aqar->points_avail){
                           $show2 = false;
                      
                            $show = true;
                     
                    }
                    else{
                            $show2 = false;
                            $show = false;
                    }  
            }
        
        $updateview = aqar::findOrFail($aqar->id);
        
        }
    
    
    
       if (!empty($updateview)) {
               $updateview->increment('views' , 1);
        return view('aqars.show', ['aqar' => $aqar], compact('allAqars', 'show', 'show2','random_ads'));
       }else{
                 return redirect()->route('homeBlade', [ 'locale'=>$locale]) ;

 
       }
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\aqar  $aqar
     * @return \Illuminate\Http\Response
     */
         //////////////////////////////////////////////////////////////////////////////////////////////////////
    public function edit($locale,$aqar)
    {
        //
        
        
        $offerTypes = OfferTypes::all();
        $categories = Category::all();
        $lic_types = license_type::all();
        $properties = TypeOfProp::all();
        $floors = Floor::all();
        $compounds = Compound::all();
        $governrate = Governrate::all();
    
        $district = District::all();
        $areas = SubArea::distinct()->get();
        $calls = CallTime::all();
        $finishes = Finish_type::all();
        $mzaya = Mzaya::all();
        
    
    
        $aqarSingle= aqar::where('slug', $aqar)->where('user_id',Auth::user()->id)->with('mzaya')->with('compounds')
        ->with('governrateq')->with('districte')->with('subAreaa')
        ->with('images')->with('finishType')->with('callTimes')
        ->with('propertyType')->with('offerTypes')->with('floorNo')->first();
               // dd($aqarSingle->offer_type);

        $type = $aqarSingle->offer_type;
        $prop = $aqarSingle->property_type;
        //dd($type);

        return view('aqars.edit', ['aqar' => $aqarSingle], compact('prop','type', 'compounds','floors', 'offerTypes', 'categories', 'properties', 'governrate', 'district', 'areas', 'calls', 'finishes','lic_types','mzaya'));
    }

 
    public function ajx_main_img_edit_only(Request $request )
    {
                $cheack = Images::where( 'aqar_id' ,$request->aqar_id)->get( );
                  //  dd($cheack);
                foreach($cheack as $cheack_val){
                    
                    
                    
                    $cheack_val->update(['main_img' => 0]);
                      $cheack_val->save();  
                    


                     if($cheack_val->id == $request->img_id){
                    $updateCount = Images::where('main_img', 0)->where('id', $request->img_id)->first();
                    $updateCount->update(['main_img' => 1]);
                      $updateCount->save();
                    } 
                        
                   

              
                
                }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\aqar  $aqar
     * @return \Illuminate\Http\Response
     */
    public function destroy(aqar $aqar)
    {
        //
    }
    
    
    //Add Wish List
    
            //////////////////////////////////////////////////////////////////////////////////////////////////////
            
            
     public function addwish_list(Request $request)
    {
        
        $cheackAqar = wish::where('user_id',Auth::user()->id)->where('aqars_id',$request->aqars_id)->first();
        
        if($cheackAqar){
            
           return response()->json(['massage'=>'This item is already in the favourites','status'=>202], 202); 
        }
        
         Auth::user()->wishlist()->create($request->all());
        
        return response()->json(['massage'=>'Add Suucess!','status'=>200], 200); 

    }


        //////////////////////////////////////////////////////////////////////////////////////////////////////
        
        
        
    public function removewish_list(Request $request)
    {
        
        $cheackAqar = wish::find($request->item_id)->delete();
        
        if(!$cheackAqar){
            
           return response()->json(['massage'=>'This item is not found','status'=>202], 202); 
        }
        
        
        return response()->json(['massage'=>'Deleted Suucess!','status'=>200], 200); 

    }
    
    
    
    
            //////////////////////////////////////////////////////////////////////////////////////////////////////
            
            
            
            
     public function addContact(Request $request)
    {
        //dd("dd");
        $pointAqqr = aqar::where('id',$request->aqars_id)->first();
        
        $cheackPoint = UserPriceing::where('user_id',Auth::user()->id)->orderBy('id', 'DESC')->first();
        $all_data= UserContactAqar::where('aqars_id','=',$request->aqars_id)->where('user_id','=' ,Auth::user()->id)->get();

        if($cheackPoint && count($all_data)<=0){
            if($cheackPoint->current_points == 0 || $pointAqqr->points_avail > $cheackPoint->current_points){
                 
                
               return response()->json(['massage'=>'You do not have enough points to communicate with the customer, you must renew the package','status'=>202], 202); 
                
            }
            
            //dd($pointAqqr->points_avail);
            $Pointbaqa    = $pointAqqr->points_avail;
            $subPoint     = $Pointbaqa + $cheackPoint->sub_points;
            $currentPoint = $cheackPoint->start_points - $subPoint ;
            
            $request->merge(['sub_points'       => $subPoint]);
            $request->merge(['current_points'    => $currentPoint]);
            
            $cheackPoint->update($request->all());
            
 
                Auth::user()->contact()->create($request->all());
             
            
        }
        
        
        return response()->json(['massage'=> $pointAqqr->user->MOP,'status'=>200], 200); 
    }
    
    
    
    
            //////////////////////////////////////////////////////////////////////////////////////////////////////
            
            
            
            
            
    public function updatedAqar(Request $request ,aqar $aqar)
    { 
        //dd($request->offer_type);
        
         if (!empty($request->area_id)) {
                $areaCheck =  SubArea::where('area', $request->area_id)->orWhere('area', $request->area_id)->first();
            if($areaCheck){
               $areaTab = $areaCheck->id; 
            }else{
            $areaTab = new SubArea();
            $areaTab->area = $request->area_id;
            $areaTab->save();

            }

         }
     
        if ($request->isMethod('post')) {
      //  dd($request->all());
            $rules = [
                         //   'photos_id' => ' mimes:jpg,png,jpeg',

               // 'aqar_slug_unique' => 'required|min:2|unique:aqar',
                'title' => 'required|min:3|max:60',
                'description' => 'required|min:10|max:5100',
                'call_id' => 'required|integer',
                'governrate_id' => 'integer',
                'area_id' => 'nullable',
                'district_id' => 'integer',
                'compound' => 'nullable',
                'category' => 'required|integer',
                'total_area' => 'required|integer',
                'finishtype' => 'required|integer',
             //   'rooms' => 'required|integer',
              //  'baths' => 'required|integer',
              //  'floor' => 'required|integer',
                
            ];
            $Validator = Validator::make($request->all(),$rules);
            if($Validator->fails()) {

                session()->flash('error', 'تأكد من البيانات المطلوب ادخالها');
                return Redirect::back()->withErrors($Validator)->withInput($request->input());
            } else {
                try {

                         
                   //update aqarDetails
                   
                   /*
                   if($request->title){
                       $six_digit_random_number = random_int(100000, 999999);

                    $request->merge(['slug' => Str::slug($request->title.$six_digit_random_number, '-')]);
                    }
*/


     if (!empty($request->area_id)) {
                $areaCheck =  SubArea::where('area', $request->area_id)->orWhere('area', $request->area_id)->first();
            if($areaCheck){
               $areaTab = $areaCheck->id; 
               
               
               
                    $request->merge(['area_id' =>  $areaCheck->id]);
                  
                  
                  
            }else{
            $areaTab = new SubArea();
            $areaTab->area = $request->area_id;
            $areaTab->save();

            }

         }
    
        
        
         
     if (!empty($request->compound)) {
                $CompoundCheck =  Compound::where('compound', $request->compound)->orWhere('compound', $request->compound)->first();
                
        
            if($CompoundCheck){
               $areaTab = $CompoundCheck->id; 
               
               
               
                    $request->merge(['compound' =>  $CompoundCheck->id]);
                  
                  
                  
            }else{
            $areaTab = new Compound();
            $areaTab->compound = $request->compound;
            $areaTab->save();
    
            
                                $request->merge(['compound' =>  $areaTab->id]);


            }

         }
    
    
       


 
          if($request->offer_type == 1 || $request->offer_type == 2 || $request->offer_type == 5){
                        $request->merge(['points_avail' =>  aqar::pointCalculate($request->total_price)]);

        }else {
           $request->merge(['points_avail' =>  aqar::pointCalculateRent($request->monthly_rent)]);
        }
        
        
        
        
                   
   
        
                    $updatedata = aqar::WHERE('id',$aqar->id)->where('user_id',Auth::user()->id)->first();
                   
                    $updatedata->update($request->all());
                     //dd( $updatedata);
                    if(is_array($request->input('mzaya'))){
                        MzayaAqar::where('aqar_id',$updatedata->id)->delete();
                         foreach($request->mzaya as $maz)
                            {
                         
                            $mazaqar = new MzayaAqar();
                            $mazaqar->aqar_id = $updatedata->id;
                            $mazaqar->mzaya_id = $maz;
                            $mazaqar->save();
                            }
                    }
                    
                    
                    
              $old_uploded_img_count = Images::WHERE('aqar_id',$aqar->id)->get();
   // dd($old_uploded_img_count->count() );
if($old_uploded_img_count->count() < 8){ 
  //  dd("ddd");
                    if (is_array($request->photos_id)) {
                        //dd(sdsd);
                        $counter=0;
                            foreach($request->photos_id as $photo1)
                            {
    
                            //$namerand = '-'.rand(1,900).'-';
                                                        $namerand = '-'.rand(1,999900).rand(1,999900).rand(1,999900).'-';

                            $imageNameGallery = $namerand . '.' . $photo1->getClientOriginalExtension();
                            $photo1->move(base_path() . '/public/images/', $imageNameGallery);
                            
                            $news_photo = new Images();
                            $news_photo->aqar_id = $updatedata->id;
                            $news_photo->img_url = "$imageNameGallery";
                            /*if($counter == 1) {
                                $news_photo->main_img = 1;
                            }else {
                                $news_photo->main_img = 0;

                            }*/
    
                           if($request->main_img){
                            if( $counter == $request->main_img){
                                $news_photo->main_img = 1;
    
                            }
                           }else{
                            if($counter == 1) {
                                $news_photo->main_img = 1;
                            }else {
                                $news_photo->main_img = 0;

                            }
                           }
                            $news_photo->save();
                            $counter++;
                            if($counter >= 8-$old_uploded_img_count->count()){
                                break;
                                }
                            }
                    
                    }
}
                    session()->flash('success', 'تم التعديل بنجاح');
                    return Redirect(Config::get('app.locale').'/user_ads');
                }catch (\Exception $ex) {
                    
                    dd($ex);
                    session()->flash('error', 'عفوا, يوجد خطأ ما');

                    return Redirect::back()->withInput($request->all());
                }
                
               
            }
        }
        return Redirect::back();
    }
    
    
    
    
            //////////////////////////////////////////////////////////////////////////////////////////////////////
            
            
            
    public function destroyImages(Request $request ,Images $img)
    {
        try {
        
                if(file_exists(public_path().'/'.$img->img_url)){
                    $image_path = public_path().'/'.$img->img_url;
                          unlink($image_path);    
                }
              
                    $cheack = Images::find($img->id);
                    // dd($cheack);
                    if($cheack->main_img == 1){
                    $updateCount = Images::where('main_img', 0)->where('aqar_id', $cheack->aqar_id)->first();
                    $updateCount->update(['main_img' => 1]);
                    }


                $img->delete();
                session()->flash('success',  'تم الحذف بنجاح');
                return Redirect::back();
        }catch (\Exception $ex) {
            session()->flash('error', 'عفوا, يوجد خطأ ما');
    
            return Redirect::back()->withInput($request->all());
        }
    }
    
    
    
    
    
            //////////////////////////////////////////////////////////////////////////////////////////////////////
            
            
            
            
      public function removeuserAds(Request $request)
    {
       // DD('FF');
        
        $cheackAqar = aqar::find($request->item_id)->delete();
        
        if(!$cheackAqar){
            
           return response()->json(['massage'=>'This item is not found','status'=>202], 202); 
        }
        
        
        return response()->json(['massage'=>'Deleted Suucess!','status'=>200], 200); 

    }  
    
    
                //////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
    
     public function usercomplain(Request $request)
    {
       
        $rules = array('message' => 'required');
        $validator = Validator::make($request->all(), $rules);
        
        // Validate the input and return correct response
        if ($validator->fails())
        {
            return response()->json(['massage'=>'يجب إدخال رساله البلاغ المقدم من سيادتكم','status'=>400], 400);
        }else{

            try {
            
                $request->merge(['user_id' => Auth::user()->id]);
                $request->merge(['aqars_id' => $request->item_id]);
                
                $Comp = Complaints::create($request->all());
    
            
            
                 return response()->json(['massage'=>'تم إرسال بلاغك بنجاح','status'=>200], 200); 
            
            }catch (\Exception $ex) {
                
             //   dd( $ex ); 
                return response()->json(['massage'=>'يوجد خطأ ما ، حاول مرة اخرى','status'=>404], 404);
            }
        }

    } 
    
                //////////////////////////////////////////////////////////////////////////////////////////////////////
    
       
       public function all_aqar_for_rent (Request $request,$locale )
    {
      
        $cat_id = $request->licat;
        $prop_id = $request->Propertytype;
        $saletype = $request->saletype;
        $governratew = $request->location1;
        $districtw = $request->location2;
        $areaw = $request->area;
        $finishType = $request->finishtype2;
        $minArea = $request->minArea;
        $maxArea = $request->maxArea;
        $minPrice = $request->minPrice;
        $maxPrice = $request->maxPrice;
        $minRooms = $request->minRooms;
        $maxRooms = $request->maxRooms;
        $minBaths = $request->minBaths;
        $maxBaths = $request->maxBaths;
        $maz = $request->mzaya;
        $sort = $request->sort;

        $governrates = Governrate::with('districts')->get();
        $district = District::all();
        $areas = SubArea::distinct()->get();
        $mzaya = Mzaya::all();

        $compounds = Compound::all();
        
        //dd(   $allAqars);
        $offerTypes = OfferTypes::all();
        $vipAqars = aqar::where('status',1)->whereIn('offer_type', [4, 3]) ->where('vip',1)->with('governrateq')->with('districte')->with('subAreaa')
        ->with('offerTypes') ->take(10)->get();
        $finishes = Finish_type::all();
        $categories = Category::all();
        
        
        $getOffers = OfferTypes::where('id',1)->first();
        
        $offs ="ALL2";
        if($offs){
            
          $allAqars = aqar::where('status',1)->whereIn('offer_type', [3,4])->latest()->paginate(9);

        }else{
            $allAqars = [];
        }
            
        $off = $getOffers; 
        
      //  dd($allAqars,$getOffers,$slug);
        return view('aqars.all-aqars',
        compact('off','allAqars', 'vipAqars', 'mzaya', 'finishes', 'categories', 'offerTypes', 'governrates', 'district', 'areas','compounds','cat_id', 'prop_id', 'saletype' , 'governratew'
      ,'districtw', 'areaw', 'finishType','minPrice', 'maxPrice' , 'minArea' , 'maxArea'  , 'minRooms' ,'maxRooms' , 'minBaths', 'maxBaths' , 'maz', 'offs' ,'sort'));
        
    }
    
    
    
    
                //////////////////////////////////////////////////////////////////////////////////////////////////////
    
       public function all_aqar_for_sale (Request $request,$locale )
    {
      
        $cat_id = $request->licat;
        $prop_id = $request->Propertytype;
        $saletype = $request->saletype;
        $governratew = $request->location1;
        $districtw = $request->location2;
        $areaw = $request->area;
        $finishType = $request->finishtype2;
        $minArea = $request->minArea;
        $maxArea = $request->maxArea;
        $minPrice = $request->minPrice;
        $maxPrice = $request->maxPrice;
        $minRooms = $request->minRooms;
        $maxRooms = $request->maxRooms;
        $minBaths = $request->minBaths;
        $maxBaths = $request->maxBaths;
        $maz = $request->mzaya;
        $sort = $request->sort;

        $governrates = Governrate::with('districts')->get();
        $district = District::all();
        $areas = SubArea::distinct()->get();
        $mzaya = Mzaya::all();

        $compounds = Compound::all();
        
        //dd(   $allAqars);
        $offerTypes = OfferTypes::all();
        
        
        $vipAqars = aqar::where('status',1) ->whereIn('offer_type', [1, 2])  ->where('vip',1)->with('governrateq')->with('districte')->with('subAreaa')
        ->with('offerTypes')->latest()->take(10)->get();
        $finishes = Finish_type::all();
        $categories = Category::all();
        
        
        $getOffers = OfferTypes::where('id',1)->first();
        
        $offs ="ALL1";
        if($offs){
            
          $allAqars = aqar::where('status',1)->whereIn('offer_type', [1,2,5])->latest()->paginate(9);

        }else{
            $allAqars = [];
        }
            
        $off = $getOffers; 
        
       // dd($offs);
        return view('aqars.all-aqars',
        compact('off','allAqars', 'vipAqars', 'mzaya', 'finishes', 'categories', 'offerTypes', 'governrates', 'district', 'areas','compounds'
        ,'cat_id', 'prop_id', 'saletype' , 'governratew'
     ,'districtw', 'areaw', 'finishType','minPrice', 'maxPrice' , 'minArea' , 'maxArea'  , 'minRooms' ,'maxRooms' , 'minBaths', 'maxBaths' , 'maz', 'offs' ,'sort'));
        
    }
    
    
    
                //////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function mainAqar(Request $request,$locale ,$slug)
    {
      
        $cat_id = $request->licat;
        $prop_id = $request->Propertytype;
        $saletype = $request->saletype;
        $governratew = $request->location1;
        $districtw = $request->location2;
        $areaw = $request->area;
        $finishType = $request->finishtype2;
        $minArea = $request->minArea;
        $maxArea = $request->maxArea;
        $minPrice = $request->minPrice;
        $maxPrice = $request->maxPrice;
        $minRooms = $request->minRooms;
        $maxRooms = $request->maxRooms;
        $minBaths = $request->minBaths;
        $maxBaths = $request->maxBaths;
        $maz = $request->mzaya;
        $sort = $request->sort;

        $governrates = Governrate::with('districts')->get();
        $district = District::all();
        $areas = SubArea::distinct()->get();
        $mzaya = Mzaya::all();

        $compounds = Compound::all();
        
        //dd(   $allAqars);
        $offerTypes = OfferTypes::all();
        $finishes = Finish_type::all();
        $categories = Category::all();
        
                $getOffers = OfferTypes::where('slug',$slug)->first();


        
        $offs = $getOffers->id;
        
         $vipAqars = aqar::where('status',1)->where('vip',1)->whereIn('offer_type', [$offs]) ->with('governrateq')->with('districte')->with('subAreaa')
         ->with('offerTypes')->latest()->take(10)->get();



      //   dd($offs);
        if($getOffers){
            
          $allAqars = aqar::where('status',1)->where('offer_type', $offs)->latest()->paginate(9);

        }else{
            $allAqars = [];
        }
            
        $off = $getOffers; 
        
      //  dd($allAqars,$getOffers,$slug);
        return view('aqars.all-aqars',
        compact('off','allAqars', 'vipAqars', 'mzaya', 'finishes', 'categories', 'offerTypes', 'governrates', 'district', 'areas','compounds','cat_id', 'prop_id', 'saletype' , 'governratew'
      ,'districtw', 'areaw', 'finishType','minPrice', 'maxPrice' , 'minArea' , 'maxArea'  , 'minRooms' ,'maxRooms' , 'minBaths', 'maxBaths' , 'maz', 'offs' ,'sort'));
        
    }
}