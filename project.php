<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\project1;

class project extends Controller
{
    public function index(){
        return view('index');
    }
    public function store(Request $request){
        $request->validate([
            'name'=>'required|max:40',
            'email' => 'required|email|unique:users',
            'phone' => 'required|min:11|numeric',
        ]);
        $sury=new project1;
        $sury->name=$request['name'];
        $sury->email=$request['email'];
        $sury->phone=$request['phone'];
        $sury->example=$request['example'];
        $sury->save();
        return back()->with('message','your message is succesfully sent');
}
       public function dashboard(Request $request){
          $search=$request['search'] ??"";
          if($search!=""){
              $customer=project1::where('name',"LIKE","%$search%")->orwhere('email',"LIKE","%$search%")->get();
          }else{
          $customer=project1::paginate(15);
          }
          $data=compact('customer','search');
          return view('dashboard')->with($data);
}      
        public function delete($id){
    
       $cr=project1::find($id);
       if(!is_null($cr)){
         $cr->delete();
        }
        return redirect('dashboard');
 
 }
 public function edit($id)
 {
     $customer=project1::find($id);
    //  echo "<pre>";
    //  print_r($customer->toArray());
    //  die;
     if(is_null($customer)){
         return redirect('dashboard');
     }else{
     $data=compact('customer');
     return view('edit')->with($data);
     }
 }
 public function update($id, Request $data){
    $sury= project1::find($id);
   $sury->name=$data['name'];
   $sury->email=$data['email'];
   $sury->phone=$data['phone'];
   $sury->example=$data['example'];
   $sury->save();
   return redirect('dashboard');
}

}
