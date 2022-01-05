<?php

namespace App\Http\Controllers;

use App\Models\Memo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class MemoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $responseArr['status']=true;
        $responseArr['data']=Memo::where('user_id',auth()->user()->id)->get();
        $responseArr['message'] = 'memos';
        $responseArr['is_valid']=1;
        $responseArr['token'] = '';
        return response()->json($responseArr,Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',

            'number' => 'required',
            'money' => 'required',
            'image' => 'required',
        ]);
    
        if ($validator->fails()) {
            $responseArr['status']=false;
            $responseArr['data']=[];
            $responseArr['message'] = $validator->messages()->first();
            $responseArr['is_valid']=0;
            $responseArr['token'] = '';
            return response()->json($responseArr,Response::HTTP_BAD_REQUEST);
        }

        $data=[
            'title'=>$request->title,
            'content'=>$request->content,
            'user_id'=>auth()->user()->id,

            'number'=>$request->number,
            'money'=>$request->money,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = Storage::disk('public')->put('images', $request->image);
        }

        $memo=Memo::create($data);

        $responseArr=array();

        $responseArr['status']=true;
        $responseArr['data']=$memo;
        $responseArr['message'] = '¡La nota se ha creado correctamente!';
        $responseArr['is_valid']=1;
        $responseArr['token'] = '';
        return response()->json($responseArr,Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Memo  $memo
     * @return \Illuminate\Http\Response
     */
    public function show(Memo $memo)
    {
        $responseArr=array();

        $responseArr['status']=true;
        $responseArr['data']=$memo;
        $responseArr['message'] = '¡La nota se ha creado correctamente!';
        $responseArr['is_valid']=1;
        $responseArr['token'] = '';
        return response()->json($responseArr,Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Memo  $memo
     * @return \Illuminate\Http\Response
     */
    public function edit(Memo $memo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Memo  $memo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Memo $memo)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',

            'number' => 'required',
            'money' => 'required',
        ]);
    
        if ($validator->fails()) {
            $responseArr['status']=false;
            $responseArr['data']=[];
            $responseArr['message'] = $validator->messages()->first();
            $responseArr['is_valid']=0;
            $responseArr['token'] = '';
            return response()->json($responseArr,Response::HTTP_BAD_REQUEST);
        }

        $data=[
            'title'=>$request->title,
            'content'=>$request->content,

            'number'=>$request->number,
            'money'=>$request->money,
        ];

        if ($request->hasFile('image')) {
            if (!is_null($memo->image)) {
                Storage::disk('public')->delete($memo->image);
            }
            $data['image'] = Storage::disk('public')->put('images', $request->image);
        }

        $memo->update($data);

        $responseArr=array();

        $responseArr['status']=true;
        $responseArr['data']=$memo;
        $responseArr['message'] = '¡La nota se ha actualizado correctamente!';
        $responseArr['is_valid']=1;
        $responseArr['token'] = '';
        return response()->json($responseArr,Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Memo  $memo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Memo $memo)
    {
        if (!is_null($memo->image)) {
            Storage::disk('public')->delete($memo->image);
        }
        $memo->delete();

        $responseArr['status']=true;
        $responseArr['data']=[];
        $responseArr['message'] = '¡La nota se ha eliminado correctamente!';
        $responseArr['is_valid']=1;
        $responseArr['token'] = '';
        return response()->json($responseArr,Response::HTTP_OK);
    }
}
