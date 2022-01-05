<?php

namespace App\Http\Controllers;

use App\Models\Study;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StudyController extends Controller
{
    public function index(){

        $studies=Study::where('teacher_id',auth()->user()->id)->get();

        $responseArr['status'] = true;
        $responseArr['data'] = $studies;
        $responseArr['message'] = 'estudios';
        $responseArr['is_valid'] = 1;
        $responseArr['token'] = '';
        return response()->json($responseArr, Response::HTTP_OK);
    }

    public function store(Request $request){
        $validator = \Validator::make($request->all(), [
            'school_id' => ['required'],
        ]);

        $study=Study::where('teacher_id',auth()->user()->id)
        ->where('school_id',$request->school_id)->get()->first();

        if (!is_null($study)){
            $responseArr['status'] = false;
            $responseArr['data'] = [];
            $responseArr['message'] = 'El profesor ya esta asignado a esta Facultad';
            $responseArr['is_valid'] = 1;
            $responseArr['token'] = '';
            return response()->json($responseArr, Response::HTTP_UNAVAILABLE_FOR_LEGAL_REASONS);
        }

        $responseArr['status'] = true;
        $responseArr['data'] = Study::create(['teacher_id'=>auth()->user()->id,'school_id'=>$request->school_id]);
        $responseArr['message'] = 'La facultad se asigno con exito.';
        $responseArr['is_valid'] = 1;
        $responseArr['token'] = '';
        return response()->json($responseArr, Response::HTTP_OK);
    }

    public function destroy(Request $request){
        $validator = \Validator::make($request->all(), [
            'school_id' => ['required'],
        ]);
        
        $study=Study::where('teacher_id',auth()->user()->id)
        ->where('school_id',$request->school_id)->get()->first();

        if (is_null($study)){
            $responseArr['status'] = false;
            $responseArr['data'] = [];
            $responseArr['message'] = 'La facultad no esta asignada a este profesor';
            $responseArr['is_valid'] = 1;
            $responseArr['token'] = '';
            return response()->json($responseArr, Response::HTTP_UNAVAILABLE_FOR_LEGAL_REASONS);
        }

        $responseArr['status'] = true;
        $responseArr['data'] = $study->delete();
        $responseArr['message'] = 'La facultad se elimino con exito';
        $responseArr['is_valid'] = 1;
        $responseArr['token'] = '';
        return response()->json($responseArr, Response::HTTP_OK);
    }
}
