<?php

namespace App\Http\Controllers;

use App\Models\Reportus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function index(){
        return view('report');
    }

    public function authenticate(Request $request){
        //validation data
        $validator = Validator::make($request->all(),[
            'type'=>'required',
            'subject'=> 'required',
            'description'=>'required'
        ]);
       // user check to curren users
       
       
        // validation check------

        if($validator->passes()){
           
            $user = Auth::user();
            $attachmentPath = [];

            if ($request->hasFile('attachment')) {
                foreach ($request->file('attachment') as $file) {
                    if ($file->isValid()) {
                        $path = $file->store('reports', 'public');
                        $attachmentPath[] = $path;
                    }
                }
            }
            Reportus::insert([
                'user_name' => $user->name,
                'type' => $request->type,
                'subject' => $request->subject,
                'description' => $request->description,
                'attachment' => json_encode($attachmentPath),
                'created_at' => now(),
                'updated_at' => now(),
            ]);            
            return redirect()->route('user.report')->with('success','Report has been successfully.');

        }else{
            return redirect()->route('user.report')
            ->withInput()
            ->withErrors($validator);
        }

    }
    
    public function reportPage(){



        if (Auth::check()) {
            $users = DB::table('reportuses')->where('user_name',Auth::user()->name)->get();
            return view('report', [
                'users' => $users,
            ]);
        }

        // If not authenticated, redirect to login or show an error
        return redirect()->route('user.login')->with('error', 'Please login to view reports.');
    }

    public function viewReport(Request $request){
        $id = $request->query('id'); // Get the ?id=5 from URL

        $report = Reportus::findOrFail($id);

        return view('reportsview', compact('report'));
    }

}
