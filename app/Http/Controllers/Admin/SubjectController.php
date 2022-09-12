<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use function PHPUnit\Framework\fileExists;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $subjects = Subject::all();
        return view('admin.subject.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subject.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                "name" => "required|string|max:100",
                "thumbnail" => "required|image|max:4096",
                "description" => "required|string|max:255",
            ]
        );
        $file = $request->file('thumbnail');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $destinationPath = public_path('uploads');
        $file->move($destinationPath, $fileName);
        $inputs = $request->only('name', 'thumbnail', 'description');
        $inputs['thumbnail'] =  'uploads/' . $fileName;
        Subject::create($inputs);
        return redirect()->route('admin.subject.index')->with('success', 'Added');
    }

    // $request->validate([
    //     'file' => 'required|mimes:pdf,xlx,csv|max:2048',
    // ]);

    // $fileName = time().'.'.$request->file->extension();  

    // $request->file->move(public_path('uploads'), $fileName);

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subjectId=$id;
        $subject = Subject::findOrFail($id);
        $chapters = $subject->chapter;
        // dd($chapters);
        return view('admin.subject.single', compact("chapters","subjectId"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $subject = Subject::findOrFail($id);
        return view('admin.subject.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate(
            [
                "name" => "required|string||max:100",
                "thumbnail" => "nullable|image|max:4096",
                "description" => "required|string||max:255",
            ]
        );
        if ($request->file('thumbnail')) {
            $subject = Subject::find($id);
            $old =  $subject->thumbnail;
            if (file_exists($old)) {
                unlink($old);
            }
            $file = $request->file('thumbnail');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('uploads');
            $file->move($destinationPath, $fileName);
            $inputs = $request->only('name', 'thumbnail', 'description');
            $inputs['thumbnail'] =  'uploads/' . $fileName;
            Subject::find($id)->update($inputs);
        }
        Subject::find($id)->update($request->only('name', 'description'));
        return redirect()->route('admin.subject.index')->with('success', 'Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subject = Subject::find($id);
        $old = 'uploads/' . $subject->thumbnail;
        if (file_exists($old)) {
            unlink($old);
        }
        $subject->destroy($id);
        return redirect()->route('admin.subject.index');
    }
}
