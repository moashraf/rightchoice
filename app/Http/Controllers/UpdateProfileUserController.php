<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class UpdateProfileUserController extends Controller
{

   public function UpdateProfileUser(Request $request)
    {
        $vendor = auth()->user();


        if ($request->isMethod('post')) {
            if ($request->has('MOP') && (string) $request->MOP !== (string) $vendor->MOP) {
                return redirect()->back()
                    ->withErrors(['MOP' => 'لا يمكن تغيير رقم الهاتف من لوحة التحكم.'])
                    ->withInput($request->except('MOP'));
            }

            $rules = [
                'name'                  => 'required|max:255',
                'email'                 => "required|email|unique:users,email,".$vendor->id,
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
                       if ($request->hasFile('img') && !is_null($request->img))
                       {
                               $request->merge(['profile_image' => _uploadFileWeb($request->img, 'user/')]);
                       }
                       //Change Password
                       if($request->old_password && $request->password){
                           if (Hash::check($request->old_password, $vendor->password)) {

                                   $request->merge(['password' =>  Hash::make($request->password)]);

                                   //update User
                                    $vendor->update($request->only(['name','email','password','AGE','TYPE','profile_image','Employee_Name','Job_title','Tax_card','Commercial_Register']));

                                    session()->flash('success', 'تم التعديل بنجاح');
                                     return redirect()->back();

                            } else {
                                   session()->flash('error', 'كلمة المرور القديمة غير صحيحة');
                                   return redirect()->back();
                            }
                        }else{

                            //update User
                            $vendor->update($request->only(['name','email','AGE','TYPE','profile_image','Employee_Name','Job_title','Tax_card','Commercial_Register']));

                            session()->flash('success', 'تم التعديل بنجاح');
                            return redirect()->back();
                        }
                }catch (\Exception $ex) {
                    session()->flash('error', 'عفوا, يوجد خطأ ما');

                    return redirect()->back()->withInput($request->all());
                }
            }
        }

        return redirect()->back();

    }
}
