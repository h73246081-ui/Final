<?php

namespace App\Http\Controllers\Api\Admin\TermsAndCondition;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrivacyAndPolicy;
use App\Models\TermAndService;

class TermAndConditionController extends Controller
{
    public function allPolicy(){
        $data=PrivacyAndPolicy::latest()->get();
        $final=$data->map(function($q){
            return [
                'title'=>$q->title,
                'description'=>$q->description
            ];
        });
        return response()->json($final);
    }
    public function allTerm(){
        $data=TermAndService::latest()->get();
        $final=$data->map(function($q){
            return [
                'title'=>$q->title,
                'description'=>$q->description
            ];
        });
        return response()->json($final);
    }
}
