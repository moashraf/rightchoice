<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\User;
use App\Models\UserPriceing;


use DataTables;
class UserController extends AppBaseController
{
    public function index()
    {
        return view('user.index');
    }
    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request,User $user)
    {
        $input = $request->all();

        $this->validate($request,$user->rules($request->password));
        //generate => image file
        if ($request->has('img') && !is_null($request->img))
        $request->merge(['profile_image' => _uploadFileWeb($request->img, 'user/')]);
        else
        $request->merge(['profile_image' => $request->img_logo]);

        $user->create($request->all());

        Flash::success('user saved successfully.');

        return redirect(route('user.index'));
    }


    public function edit($id)
    {
        $user = User::find($id);
        
    $all_point_of_user = UserPriceing::where('user_id','=',$user->id)->latest()->first();


//if($all_point_of_user->count() > 0){dd($all_point_of_user);} 
        return view('user.edit',compact('user','all_point_of_user' )) ;
    }
    
    
    

    public function update(Request $request,User $user)
    {
      //  $this->validate($request,$user->rules($request->password,$user->id),$user->errorMessages());
      
      
          $all_point_of_user = UserPriceing::where('user_id','=',$user->id)->latest()->first();

 
$all_point_of_user->start_points = $request->current_points ;
$all_point_of_user->current_points = $request->current_points ;
$all_point_of_user->sub_points = 0 ;

$all_point_of_user->save();

        $user->update($request->all());
        return redirect(route('user.index'));
    }
    
    
    
  
    
    
    
    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }
 
 
 
    public function destroy(User $user)
    {
        $user->delete();
        return redirect(route('user.index'));
    }
    
    
    
    public function dataTable()
    {
        $users = User::get();
        return DataTables::of($users)
            ->editColumn('control', function ($model){
                $all  = '<!--<a data-toggle="tooltip" data-skin-class="tooltip-primary"  data-placement="top" title = "Show User Profile" href = "' . url('/users/' . $model->id) . '"   class="btn btn-sm btn-outline-primary"><i class="fas fa-user"></i></a>--> ';
                if ($model->status == 1) {
                    $all .= '<a onClick="return confirm(\'Are You Sure You Want To Block This Users?\')" data-toggle="tooltip" data-skin-class="tooltip-danger"  data-placement="top" title = "Block User" href="' . url('/users/' . $model->id . '/block') . '"  class="btn btn-sm btn-outline-danger ml-2"><i class="fas fa-times"></i></a>';
                } else {

                    $all .= '<a onClick="return confirm(\'Are You Sure You Want To Active This User ?\')" data-toggle="tooltip" data-skin-class="tooltip-danger" data-placement="top" title = "Active User"  href="' . url('/users/' . $model->id . '/activate') . '"  class="btn btn-sm btn-outline-success ml-2"><i class="fas fa-check"></i></a>';
                }
                $all .= '<a onClick="return confirm(\'Are You Sure You Want To Delete This Record ?  \')" data-toggle="tooltip" data-skin-class="tooltip-danger"  data-placement="top" title = "Delete" href = "' . url('/users/' . $model->id . '/delete'). '"  class="btn btn-sm btn-outline-danger ml-2" style="margin-left:5px"><i class="fas fa-trash"></i></a>';
                $all .= '<a     href = "' . url('/user/' . $model->id . '/edit'). '"  class="btn btn-sm btn-outline-edit   ml-2" style="margin-left:5px"><i class="fas fa-edit  "></i></a>';
                return $all;
            })->editColumn('phone', function ($model) {
                 $phone = '<span class="d-block font-weight-bold small mt-1 mb-1">'.$model->MOP.'</span>';
                
                return $phone;
            })->editColumn('active', function ($model) {
                if($model->status == 1){
                    $status = '<span class="badge badge-success">Active</span>';
                }elseif($model->status == 0){
                    $status = '<span class="badge badge-warning">Wait</span>';
                }else{
                    $status = '<span class="badge badge-danger">UnActive</span>';
                }
                return $status;
            })->rawColumns(['control','phone','active'])->make(true);
    }
    
    
    
    public function block(User $user)
    {
        $user->update(['status' => 0]);
   
        Flash::success('user blocked successfully.');

        return redirect(route('user.index'));

    }
    
    
    
    
     public function activate(User $user)
    {
        $user->update(['status' => 1]);
   
        Flash::success('user activated successfully.');

        return redirect(route('user.index'));

    }
}




