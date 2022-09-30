<?php

namespace App\Http\Controllers\Admin;

use App\Models\Chapter;
use App\Models\Subject;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\ChapterContent;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chapters = Chapter::all();
        return view('admin.chapter.index', compact('chapters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = Subject::select('id', 'name')->get();
        return view('admin.chapter.create', ['subjects' => $subjects]);
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
                "description" => "required|string|max:255",
                "chapter_no" => "required|integer",
                "subject_id" => "required|integer",
                "video.*" => "nullable|url",
                "file.*" => "nullable|mimes:pdf|max:10000",
            ],
            [
                "subject_id.integer" => "Invalid data",
                "video.*" => "Invalid url",
            ]
        );
        $inputs = $request->only('title', 'note', 'video');
        $destinationPath = public_path('uploads');
        if ($request->file('file')) {
            $filesArray = [];
            foreach ($request->file('file') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move($destinationPath, $fileName);
                $filesArray[] = 'uploads/' . $fileName;
            }
            $inputs += ['files' =>  $filesArray];
        }
        $chapterinputs = $request->only('name', 'description', 'subject_id', 'chapter_no');
        $chapter = Chapter::create($chapterinputs);
        if (isset($inputs['video'])) {
            foreach ($inputs['video'] as $vid) {
                ChapterContent::create([
                    'chapter_id' => $chapter->id,
                    'video' => $vid,
                ]);
            }
        }
        if (isset($inputs['files'])) {
            foreach ($inputs['files'] as $fil) {
                ChapterContent::create([
                    'chapter_id' => $chapter->id,
                    'file' => $fil,
                ]);
            }
        }
        return redirect()->route('admin.chapter.index', ['success', 'chapter added']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $chapter = Chapter::findOrFail($id);
        $questions = Question::where('chapter_id', '=', $id)->get();
        return view('admin.chapter.single', ['chapter' => $chapter, 'questions' => $questions]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subjects = Subject::select('id', 'name')->get();
        $chapter =  Chapter::find($id);
        return view('admin.chapter.edit', ['subjects' => $subjects, 'chapter' => $chapter]);
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
                "name" => "required|string|max:100",
                "description" => "required|string|max:255",
                "chapter_no" => "required|integer",
                "subject_id" => "required|integer",
            ],
            [
                "subject_id.integer" => "Invalid data",
            ]
        );
        $chapter = Chapter::find($id);
        $chapter->update($request->only('name', 'description', 'subject_id', 'chapter_no'));
        return redirect()->route('admin.chapter.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Chapter::destroy($id);
        return redirect()->route('admin.chapter.index');
    }
}
