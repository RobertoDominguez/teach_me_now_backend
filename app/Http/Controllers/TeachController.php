<?php

namespace App\Http\Controllers;

use App\Models\Teach;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TeachController extends Controller
{
    public function index(){

        $studies=Teach::where('teacher_id',auth()->user()->id)->get();

        $responseArr['status'] = true;
        $responseArr['data'] = $studies;
        $responseArr['message'] = 'universities';
        $responseArr['is_valid'] = 1;
        $responseArr['token'] = '';
        return response()->json($responseArr, Response::HTTP_OK);
    }

    public function store(Request $request){
        $validator = \Validator::make($request->all(), [
            'subject_id' => ['required'],
            'level' => ['required'],
        ]);
        $study=Teach::where('teacher_id',auth()->user()->id)
        ->where('subject_id',$request->subject_id)->get()->first();

        if (!is_null($study)){
            $responseArr['status'] = false;
            $responseArr['data'] = [];
            $responseArr['message'] = 'La materia ya esta asignado a esta Facultad';
            $responseArr['is_valid'] = 1;
            $responseArr['token'] = '';
            return response()->json($responseArr, Response::HTTP_UNAVAILABLE_FOR_LEGAL_REASONS);
        }

        $responseArr['status'] = true;
        $responseArr['data'] = Teach::create(['teacher_id'=>auth()->user()->id,'subject_id'=>$request->subject_id,'level'=>$request->level]);
        $responseArr['message'] = 'La materia se asigno con exito';
        $responseArr['is_valid'] = 1;
        $responseArr['token'] = '';
        return response()->json($responseArr, Response::HTTP_OK);
    }

    public function destroy(Request $request){
        $validator = \Validator::make($request->all(), [
            'subject_id' => ['required'],
        ]);
        $study=Teach::where('teacher_id',auth()->user()->id)
        ->where('subject_id',$request->subject_id)->get()->first();

        if (is_null($study)){
            $responseArr['status'] = false;
            $responseArr['data'] = [];
            $responseArr['message'] = 'La materia no esta asignada a este profesor';
            $responseArr['is_valid'] = 1;
            $responseArr['token'] = '';
            return response()->json($responseArr, Response::HTTP_UNAVAILABLE_FOR_LEGAL_REASONS);
        }

        $responseArr['status'] = true;
        $responseArr['data'] = $study->delete();
        $responseArr['message'] = 'La materia se elimino con exito';
        $responseArr['is_valid'] = 1;
        $responseArr['token'] = '';
        return response()->json($responseArr, Response::HTTP_OK);
    }
}
