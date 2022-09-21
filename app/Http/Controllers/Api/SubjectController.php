<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Chapter;
use App\Models\Subject;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $subject = Subject::with('chapter.content')->get();

        return response()->json(['subject' => $subject], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     
    public function subject(Request $request)
    {

        $subject = Subject::with('chapter.content')->find($request->subject_id);

        return response()->json(['subject' => $subject], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function chapter(Request $request)
    {
        $chapter = Chapter::with('content','quiz')->find($request->chapter_id);

        return response()->json(['chapter' => $chapter], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function quiz(Request $request)
    {
       $question = Question::where('chapter_id',$request->chapter_id)->get()->random(5);
       return response()->json(['quiz' => $question], 200);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
