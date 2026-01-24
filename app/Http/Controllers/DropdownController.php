<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use Response;
use Redirect;
use App\Models\{Governrate, District};


class DropdownController extends Controller
{
    //
    
    
    
    public function fetchState(Request $request)
    {
        $data['states'] = District::where("govern_id",$request->country_id)->get(["district", "id"]);
        return response()->json($data);
    }

  
}


