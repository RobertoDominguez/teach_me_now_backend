<?php

namespace App\Http\Controllers;

use App\Models\Advertising;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDOException;

class AdvertisingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $advertisings=Advertising::whereNull('deleted_at')->get();
        $advertisings=Advertising::all();
        return view('advertising.index',compact('advertisings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('advertising.create');
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
            'url' => ['required'],
            'image' => ['required','mimes:jpeg,png,jpg,gif,svg','max:2048'],
        ]);

        $data=[
            'url'=>$request->url,
            'enabled'=>true
        ];

        if ($request->hasFile('image')) {
            $data['image'] = Storage::disk('public')->put('advertisings', $request->image);
        }

        

        try{
            $advertising=Advertising::create($data);    
        }catch (PDOException $e){
            Storage::disk('public')->delete($data['image']);
            return back()->withErrors(['error'=>$e->getMessage()]);
        }

        return redirect(route('advertising.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Advertising  $advertising
     * @return \Illuminate\Http\Response
     */
    public function show(Advertising $advertising)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Advertising  $advertising
     * @return \Illuminate\Http\Response
     */
    public function edit(Advertising $advertising)
    {
        return view('advertising.edit',compact('advertising'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Advertising  $advertising
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Advertising $advertising)
    {
        $validator = \Validator::make($request->all(), [
            'url' => ['required'],
            'image' => ['required'],
        ]);

        $data=[
            'url' => $request->url
        ];

        if ($request->hasFile('image')) {
            if (!is_null($advertising->image)) {
                Storage::disk('public')->delete($advertising->image);
            }
            $data['image'] = Storage::disk('public')->put('advertisings', $request->image);
        }

        try{
            $advertising->update($data);
        }catch (PDOException $e){
            Storage::disk('public')->delete($data['image']);
            return back()->withErrors(['error'=>$e->getMessage()]);
        }
        

        return redirect(route('advertising.index'));
    }

    public function disableEnable(Advertising $advertising)
    {
        if ($advertising->enabled) {
            $advertising->update(['enabled'=>false]);
        }else{
            $advertising->update(['enabled'=>true]);
        }
        return redirect(route('advertising.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Advertising  $advertising
     * @return \Illuminate\Http\Response
     */
    public function destroy(Advertising $advertising)
    {
        if (!is_null($advertising->image)) {
            Storage::disk('public')->delete($advertising->image);
        }
        $advertising->delete();
        return redirect(route('advertising.index'));
    }
}
