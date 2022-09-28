<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ChapterContent;
use App\Http\Controllers\Controller;

class ChapterContentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(
            [
                "chapter_id" => "required|integer",
                "title" => "required|string|max:100",
                "note" => "required|string|max:255",
                "video" => "required|mimetypes:video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv",
                "file" => "required|file|max:10240",
            ],
            [
                "video.mimetypes" => "Video formate is not supported",
            ]
        );
        $inputs = $request->only('title', 'note', 'chapter_id');
        $destinationPath = public_path('uploads');
        $videoPath = '';
        $filePath = '';
        if ($request->file('video')) {
            $video = $request->file('video');
            $videoName = time() . '_' . $video->getClientOriginalName();
            $video->move($destinationPath, $videoName);
            $videoPath = ['video' => 'uploads/' . $videoName];
            $inputs += $videoPath;
        }
        if ($request->file('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move($destinationPath, $fileName);
            $filePath = ['file' => 'uploads/' . $fileName];
            $inputs += $filePath;
        }
        ChapterContent::create($inputs);
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $id = $request->id;
        ChapterContent::destroy($id);
        return redirect()->back();
    }
}
