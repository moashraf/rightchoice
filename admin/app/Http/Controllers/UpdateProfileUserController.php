<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use Auth;
use App\Models\User;
Use Redirect;


class UpdateProfileUserController extends Controller
{
   
   public function UpdateProfileUser(Request $request)
    {   
        $vendor = Auth::user();
        
        $oldmob= $vendor->MOP;
        
        $locale=   app()->getLocale();

        $random_mass_num= random_int(111, 10000);
        
        if ($request->isMethod('post')) {
            $rules = [
                'name'                  => 'required|max:255',
                'email'                 => "required|email|unique:users,email,".$vendor->id,
                'MOP'                   => "required|min:11|numeric|unique:users,MOP,".$vendor->id,
                'password'              => ( $request->password != null ? 'required|confirmed|min:8' : ''),
                'old_password'          => ( $request->old_password != null ? 'required|min:8' : ''),
                'img'                   => ( $request->img != null ? 'required|image|mimes:jpeg,jpg,png,gif' : ''),
                'AGE'                   => ( $request->AGE != null ? 'required|integer' : ''),
                'TYPE'                  => ( $request->TYPE != null ? 'required|integer' : ''),
                'Employee_Name'         => ($request->TYPE != null && $request->TYPE  == 3 ? 'required' : ''),
                'Job_title'             => ($request->TYPE != null &&  $request->TYPE  == 3 ? 'required' : ''),
                'Tax_card'              => ($request->TYPE != null &&  $request->TYPE  == 3 ? 'required' : ''),
                'Commercial_Register'   => ($request->TYPE != null &&  $request->TYPE  == 3 ? 'required' : ''),
            ];
            $Validator = Validator::make($request->all(),$rules);
            //   dd($rules,$Validator->fails(),$Validator);
            if ($Validator->fails()) {
                return redirect()->back()->withErrors($Validator)->withInput($request->all());
            } else {
              
                try {

                      //Upload Image
                       if ($request->has('img') && !is_null($request->img))
                       {
                                
                               $photoexplode = $request->img->getClientOriginalName();
                               $photoexplode = explode(".", $photoexplode);
                           //    $namerand = '-'.rand(1,900).'-';
                                                           $namerand = '-'.rand(1,999900).rand(1,999900).rand(1,999900).'-';

                               $namerand.= $photoexplode[0];
                               $imageNameGallery2 = $namerand . '.' . $request->img->getClientOriginalExtension();
                               $request->img->move(base_path() . '/public/images/', $imageNameGallery2);
                               $input['img'] =    $imageNameGallery2; 
                     
                               $request->merge(['profile_image' =>  $input['img']]);
                                  
                       }
                       //Change Password
                       if($request->old_password && $request->password){
                           if (Hash::check($request->old_password, $vendor->password)) { 
                            
                                   $request->merge(['password' =>  Hash::make($request->password)]);
                                   
                                   //update User
                                    $vendor->update($request->only(['name','email','MOP','password','AGE','TYPE','profile_image','Employee_Name','Job_title','Tax_card','Commercial_Register']));
                                    
                                    session()->flash('success', 'تم التعديل بنجاح');
                                     return Redirect::back();
                             
                            } else {
                                   session()->flash('error', 'كلمة المرور القديمة غير صحيحة');
                                   return Redirect::back();
                            }
                        }else{
                            
                            //update User
                            $vendor->update($request->only(['name','email','MOP','AGE','TYPE','profile_image','Employee_Name','Job_title','Tax_card','Commercial_Register']));

                            if($oldmob == $request->MOP){
                                 session()->flash('success', 'تم التعديل بنجاح');
                             return Redirect::back();
                            }else{
                                
                                


                            }
                        }
                }catch (\Exception $ex) {
                    session()->flash('error', 'عفوا, يوجد خطأ ما');
            
                    return Redirect::back()->withInput($request->all());
                }
            }
        }
       
    } 
}

