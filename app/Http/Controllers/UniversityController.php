<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDOException;

class UniversityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $universities=University::whereNull('deleted_at')->get();
        $universities=University::all();
        return view('university.index',compact('universities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('university.create');
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
            'acronym' => ['required'],
            'name' => ['required'],
            'description' => ['required'],
            'image' => ['required'],
        ]);

        $data=[
            'acronym'=>$request->acronym,
            'name'=>$request->name,
            'description'=>$request->description,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = Storage::disk('public')->put('universities', $request->image);
        }

        

        try{
            $university=University::create($data);    
        }catch (PDOException $e){
            Storage::disk('public')->delete($data['image']);
            return back()->withErrors(['error'=>$e->getMessage()]);
        }

        return redirect(route('university.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\University  $university
     * @return \Illuminate\Http\Response
     */
    public function show(University $university)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\University  $university
     * @return \Illuminate\Http\Response
     */
    public function edit(University $university)
    {
        return view('university.edit',compact('university'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\University  $university
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, University $university)
    {
        $validator = \Validator::make($request->all(), [
            'acronym' => ['required'],
            'name' => ['required'],
            'description' => ['required'],
        ]);

        $data=[
            'acronym'=>$request->acronym,
            'name'=>$request->name,
            'description'=>$request->description,
        ];

        if ($request->hasFile('image')) {
            if (!is_null($university->image)) {
                Storage::disk('public')->delete($university->image);
            }
            $data['image'] = Storage::disk('public')->put('universities', $request->image);
        }

        try{
            $university->update($data);
        }catch (PDOException $e){
            Storage::disk('public')->delete($data['image']);
            return back()->withErrors(['error'=>$e->getMessage()]);
        }
        

        return redirect(route('university.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\University  $university
     * @return \Illuminate\Http\Response
     */
    public function destroy(University $university)
    {
        if (!is_null($university->image)) {
            Storage::disk('public')->delete($university->image);
        }
        $university->delete();
        return redirect(route('university.index'));
    }
}
