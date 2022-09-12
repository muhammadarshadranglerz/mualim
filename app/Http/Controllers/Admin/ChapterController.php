<?php

namespace App\Http\Controllers\Admin;

use App\Models\Chapter;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\ChapterContent;
use App\Http\Controllers\Controller;
use App\Models\Question;

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
                "subject_id" => "required|integer",
                "title" => "required|string|max:100",
                "note" => "required|string|max:255",
                "video" => "nullable|mimetypes:video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv",
                "file" => "nullable|file|max:10240",
            ],
            [
                "subject_id.required" => "Select a Subject",
                "video.mimetypes" => "Video formate is not supported",
            ]
        );
        
        $inputs = $request->only('title', 'note');
        $destinationPath = public_path('uploads');
        if ($request->file('video')) {
            $video = $request->file('video');
            $videoName = time() . '_' . $video->getClientOriginalName();
            $video->move($destinationPath, $videoName);
            $inputs += ['video' => 'uploads/' . $videoName];
        }
        if ($request->file('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move($destinationPath, $fileName);
            $inputs += ['file' => 'uploads/' . $fileName];
        }
        // dd($request->only('name', 'description', 'subject_id'));
        // dd($inputs);
        $chapter = Chapter::create($request->only('name', 'description', 'subject_id'));
        $inputs += ['chapter_id' => $chapter->id];
        ChapterContent::create($inputs);
        if($request->only("submittedFromEdit")){
            return redirect()->route('admin.chapter.index');
        }
        // $chapter->content()->save($chapter);
        return redirect()->back();
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
                "ccid" => "required|integer",
                "name" => "required|string|max:100",
                "description" => "required|string|max:255",
                "subject_id" => "required|integer",
                "title" => "required|string|max:100",
                "note" => "required|string|max:255",
                "video" => "nullable|mimetypes:video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv",
                "file" => "nullable|file|max:10240",
            ],
            [
                "subject_id.required" => "Select a Subject",
                "video.mimetypes" => "Video formate is not supported",
            ]
        );
        $chapter = Chapter::find($id);
        $chapterContent = ChapterContent::find($request->ccid);
        $inputs = $request->only('title', 'note');
        $destinationPath = public_path('uploads');
        if ($request->file('video')) {
            $oldVideo =  $chapterContent->video;
            if (file_exists($oldVideo)) {
                unlink($oldVideo);
            }
            $video = $request->file('video');
            $videoName = time() . '_' . $video->getClientOriginalName();
            $video->move($destinationPath, $videoName);
            $inputs += ['video' => 'uploads/' . $videoName];
        }
        if ($request->file('file')) {
            $oldFile =  $chapterContent->file;
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move($destinationPath, $fileName);
            $inputs += ['file' => 'uploads/' . $fileName];
        }
        $chapterContent->update($inputs);
        $chapter->update($request->only('name', 'description', 'subject_id'));
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
