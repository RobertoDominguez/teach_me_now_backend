<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDOException;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $subjects=Subject::whereNull('deleted_at')->get();
        $subjects=Subject::all();
        return view('subject.index',compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('subject.create');
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
            'image' => ['required','mimes:jpeg,png,jpg,gif,svg','max:2048'],
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
            $subject=Subject::create($data);    
        }catch (PDOException $e){
            Storage::disk('public')->delete($data['image']);
            return back()->withErrors(['error'=>$e->getMessage()]);
        }

        return redirect(route('subject.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        return view('subject.edit',compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
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
            if (!is_null($subject->image)) {
                Storage::disk('public')->delete($subject->image);
            }
            $data['image'] = Storage::disk('public')->put('universities', $request->image);
        }

        try{
            $subject->update($data);
        }catch (PDOException $e){
            Storage::disk('public')->delete($data['image']);
            return back()->withErrors(['error'=>$e->getMessage()]);
        }
        

        return redirect(route('subject.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        if (!is_null($subject->image)) {
            Storage::disk('public')->delete($subject->image);
        }
        $subject->delete();
        return redirect(route('subject.index'));
    }
}
