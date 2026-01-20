<?php

namespace App\Http\Controllers\Admin\TermCondition;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TermAndService;
use App\Models\PrivacyAndPolicy;

class TermConditionController extends Controller
{
    public function indexTerm(){
        $data=TermAndService::latest()->get();
        return view('admin.termCondition.indexTermCondition',[
            'data'=>$data
        ]);
    }
    public function store(Request $request){
        $request->validate([
            'title'=>'required',
            'description'=>'required'
        ]);
        $data=new TermAndService;
        $data->title=$request->title;
        $data->description=$request->description;
        $data->save();
        return redirect()->back()->with('success','Term & Service added successfuly!');
    }
    // Fetch single Term & Service data for edit
public function edit($id){
    $term = TermAndService::find($id);
    return response()->json($term);
}

    public function update(Request $request,$id){
        $request->validate([
            'title'=>'required',
            'description'=>'required'
        ]);
        $data=TermAndService::find($id);
        $data->title=$request->title;
        $data->description=$request->description;
        $data->save();
        return redirect()->back()->with('success','Term & Service Updated successfuly!');
    }
    public function delete($id){
        $data=TermAndService::find($id);
        $data->delete();
        return redirect()->back();
    }

    public function indexPolicy(){
        $data=PrivacyAndPolicy::latest()->get();
        return view('admin.privacyPolicy.indexPrivacyPolicy',compact('data'));
    }
    public function storePolicy(Request $request){
        $request->validate([
            'title'=>'required',
            'description'=>'required'
        ]);
        $data=new PrivacyAndPolicy;
        $data->title=$request->title;
        $data->description=$request->description;
        $data->save();
        return redirect()->back()->with('success','Privacy & Policy added successfuly!');
    }
    public function editPolicy($id){
        $term = PrivacyAndPolicy::find($id);
        return response()->json($term);
    }
    public function updatePolicy(Request $request,$id){
        $request->validate([
            'title'=>'required',
            'description'=>'required'
        ]);
        $data=PrivacyAndPolicy::find($id);
        $data->title=$request->title;
        $data->description=$request->description;
        $data->save();
        return redirect()->back()->with('success','Privacy & Policy Updated successfuly!');
    }

    public function deletePolicy($id){
        $data=PrivacyAndPolicy::find($id);
        $data->delete();
        return redirect()->back();
    }

}
