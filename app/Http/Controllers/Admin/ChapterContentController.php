<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ChapterContent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ChapterContentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(
            [
                "chapter_id" => "required|integer",
                "video.*" => "nullable|url",
                "file.*" => "nullable|mimes:pdf|max:10000",
            ],
            [
                "video.mimes" => "Video formate is not supported",
            ]
        );
        $inputs = $request->only('chapter_id', 'video');
        $destinationPath = public_path('uploads');
        $videoPath = '';
        $filePath = '';
        if ($request->file('file')) {
            $filesArray = [];
            foreach ($request->file('file') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move($destinationPath, $fileName);
                $filesArray[] = 'uploads/' . $fileName;
            }
            $inputs += ['files' =>  $filesArray];
        }
        if (isset($inputs['video'])) {
            foreach ($inputs['video'] as $vid) {
                ChapterContent::create([
                    'chapter_id' => $inputs['chapter_id'],
                    'video' => $vid,
                ]);
            }
        }
        if (isset($inputs['files'])) {
            foreach ($inputs['files'] as $fil) {
                ChapterContent::create([
                    'chapter_id' => $inputs['chapter_id'],
                    'file' => $fil,
                ]);
            }
        }
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $id = $request->id;
        $content = ChapterContent::find($id);
        if ($content) {
            if ($content->file) {
                if (file_exists(asset($content->file))) {
                    unlink(asset($content->file));
                }
            }
            $content->delete();
        }
        return redirect()->back();
    }
}
