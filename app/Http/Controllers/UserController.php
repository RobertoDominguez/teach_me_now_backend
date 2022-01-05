<?php

namespace App\Http\Controllers;

use App\Models\Academic;
use App\Models\Advertising;
use App\Models\School;
use App\Models\Study;
use App\Models\Subject;
use App\Models\System;
use App\Models\Teach;
use App\Models\University;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function universities(){
        $responseArr['status'] = true;
        $responseArr['data'] = University::all();
        $responseArr['message'] = 'universities';
        $responseArr['is_valid'] = 1;
        $responseArr['token'] = '';
        return response()->json($responseArr, Response::HTTP_OK);
    }

    public function schools(){
        $responseArr['status'] = true;
        $responseArr['data'] = School::all();
        $responseArr['message'] = 'schools';
        $responseArr['is_valid'] = 1;
        $responseArr['token'] = '';
        return response()->json($responseArr, Response::HTTP_OK);
    }

    public function subjects(){
        $responseArr['status'] = true;
        $responseArr['data'] = Subject::all();
        $responseArr['message'] = 'subjects';
        $responseArr['is_valid'] = 1;
        $responseArr['token'] = '';
        return response()->json($responseArr, Response::HTTP_OK);
    }

    public function academics(){
        $responseArr['status'] = true;
        $responseArr['data'] = Academic::all();
        $responseArr['message'] = 'academics';
        $responseArr['is_valid'] = 1;
        $responseArr['token'] = '';
        return response()->json($responseArr, Response::HTTP_OK);
    }

    public function studies(){
        $responseArr['status'] = true;
        $responseArr['data'] = Study::all();
        $responseArr['message'] = 'studies';
        $responseArr['is_valid'] = 1;
        $responseArr['token'] = '';
        return response()->json($responseArr, Response::HTTP_OK);
    }

    public function teaches(){
        $responseArr['status'] = true;
        $responseArr['data'] = Teach::all();
        $responseArr['message'] = 'teaches';
        $responseArr['is_valid'] = 1;
        $responseArr['token'] = '';
        return response()->json($responseArr, Response::HTTP_OK);
    }

    public function teachers(){

        $system=System::all()->first();

        //$teachers=User::where('teacher',true)->whereDate(now()->toDateString(), '>' ,'end_subscription')
        //->orWhereDate(now()->toDateString(),'<',$system->free_date)->get();

        $teachers=User::where('teacher',true)->orWhereRaw(DB::raw("'".now()->toDateString()."' < "."end_subscription"))
        ->orWhereRaw(DB::raw("'".now()->toDateString()."' < '".$system->free_date."'"))->get();

        $responseArr['status'] = true;
        $responseArr['data'] = $teachers;
        $responseArr['message'] = 'teachers';
        $responseArr['is_valid'] = 1;
        $responseArr['token'] = '';
        return response()->json($responseArr, Response::HTTP_OK);
    }

    public function advertisings(){
        $responseArr['status'] = true;
        $responseArr['data'] = Advertising::where('enabled',true)->get();
        $responseArr['message'] = 'advertisings';
        $responseArr['is_valid'] = 1;
        $responseArr['token'] = '';
        return response()->json($responseArr, Response::HTTP_OK);
    }

    public function system(){
        $responseArr['status'] = true;
        $responseArr['data'] = System::all()->first();
        $responseArr['message'] = 'system';
        $responseArr['is_valid'] = 1;
        $responseArr['token'] = '';
        return response()->json($responseArr, Response::HTTP_OK);
    }
}
