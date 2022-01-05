<?php

namespace App\Http\Controllers;

use App\Models\Academic;
use App\Models\School;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDOException;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $schools=School::whereNull('deleted_at')->get();
        $schools = School::all();
        return view('school.index', compact('schools'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('school.create');
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

        $data = [
            'acronym' => $request->acronym,
            'name' => $request->name,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = Storage::disk('public')->put('schools', $request->image);
        }



        try {
            $school = School::create($data);
        } catch (PDOException $e) {
            Storage::disk('public')->delete($data['image']);
            return back()->withErrors(['error' => $e->getMessage()]);
        }

        return redirect(route('school.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function show(School $school)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function edit(School $school)
    {
        return view('school.edit', compact('school'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, School $school)
    {
        $validator = \Validator::make($request->all(), [
            'acronym' => ['required'],
            'name' => ['required'],
            'description' => ['required'],
        ]);

        $data = [
            'acronym' => $request->acronym,
            'name' => $request->name,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            if (!is_null($school->image)) {
                Storage::disk('public')->delete($school->image);
            }
            $data['image'] = Storage::disk('public')->put('schools', $request->image);
        }

        try {
            $school->update($data);
        } catch (PDOException $e) {
            Storage::disk('public')->delete($data['image']);
            return back()->withErrors(['error' => $e->getMessage()]);
        }


        return redirect(route('school.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function destroy(School $school)
    {
        if (!is_null($school->image)) {
            Storage::disk('public')->delete($school->image);
        }
        $school->delete();
        return redirect(route('school.index'));
    }

    public function subjects(School $school)
    {
        $academics = Academic::join('subjects', 'subjects.id', 'academics.subject_id')->where('school_id', $school->id)
            ->select('academics.*', 'subjects.name')->get();
        $subjects = Subject::all();
        return view('school.subjects', compact('academics', 'school'), compact('subjects'));
    }

    public function updateSubjects(Request $request, School $school)
    {
        $subjects_add = $request->subjects_add;
        $subjects_remove = $request->subjects_remove;

        if (!is_null($subjects_add)) {
            foreach ($subjects_add as $subject) {
                try {
                    $academic = Academic::where('school_id', $school->id)->where('subject_id', $subject)->first();
                    if (is_null($academic)) {
                        Academic::create([
                            'school_id' => $school->id,
                            'subject_id' => $subject
                        ]);
                    }
                } catch (PDOException $e) {
                }
            }
        }

        if (!is_null($subjects_remove)) {

            try {
                foreach ($subjects_remove as $subject) {
                    Academic::where('school_id', $school->id)->where('subject_id', $subject)
                        ->first()->delete();
                }
            } catch (PDOException $e) {
            }
        }

        return redirect(route('school.subjects', $school->id));
    }
}
