<?php

namespace App\Http\Controllers;

use App\Models\UserPanal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index(){
        return view('login');
    }

    public function authenticate(Request $request){
        $validator = Validator::make($request->all(),[
            'email'=> 'required|email',
            'password'=>'required'
        ]);

        
        
        if($validator->passes()){
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                $user = Auth::user();

                if ($user->status) {
                    return redirect()->route('user.dashboard');
                } else {
                    Auth::logout();
                    return redirect()->route('user.login')->with('error', 'User is not active. Contact Admin, please.');
                }
                
            }else{
                return redirect()->route('user.login')->with('error','Email or Password is incorrect');
            }
        }else{
            return redirect()->route('user.login')
            ->withInput()
            ->withErrors($validator);
        }
    }

    public function dashboard(){
        return view('dashboard');
    }

    public function register(){

        return view('register');
    }

    public function processRegister(Request $request){

        $validator = Validator::make($request->all(),[
            'name'=>'required|unique:user_panals',
            'email'=> 'required|email|unique:user_panals',
            'password'=>'required|confirmed'
        ]);

        if($validator->passes()){
           
            $user = new UserPanal();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            
            return redirect()->route('user.login')->with('success','Registration has been successfully.');

        }else{
            return redirect()->route('user.register')
            ->withInput()
            ->withErrors($validator);
        }

    }

    public function logout(){
        Auth::logout();
        return redirect()->route('user.login');
    }

    public function blank(){

        return view('blank');
    }

    public function charge(){
        
        return view('charge');
    }

    public function howtowork(){
        
        return view('howtowork');
    }

    

    public function payment(){
        
        return view('payment');
    }

    public function product(){
        
        return view('product');
    }

    public function track(){
        
        return view('track');
    }



}
