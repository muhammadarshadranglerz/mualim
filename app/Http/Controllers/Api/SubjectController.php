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


    public function search(Request $request)
    {
        $search = $request->name;

        $chapter = Chapter::with('content')->where('name', 'Like', '%' . $search . '%')->get();
        // $videoArray = [];
        // $fileArray = [];
        // if ($chapter->content) {
        //     foreach ($chapter->content as $content) {
        //         if(isset($content['video'])){
        //             array_push($videoArray,$content['video']);
        //         }
        //         if(isset($content['file'])){
        //             array_push($fileArray,$content['file']);
        //         }
        //     }
        // }
        // unset($chapter->content);
        // $chapter->videos=$videoArray;
        // $chapter->files=$fileArray;
        // // ==================================quizzes====================
        // if ($chapter->quizzes) {

        //     foreach ($chapter->quizzes as $quiz) {
        //         $quizOption=[];
        //         array_push($quizOption,$quiz['first_option']);
        //         array_push($quizOption,$quiz['second_option']);
        //         array_push($quizOption,$quiz['third_option']);
        //         array_push($quizOption,$quiz['fourth_option']);
        //         unset($quiz['first_option']);
        //         unset($quiz['second_option']);
        //         unset($quiz['third_option']);
        //         unset($quiz['fourth_option']);
        //         $quiz->options=$quizOption;
        //         $quiz->correctIndex=$quiz['correct']-1;
        //         unset($quiz['correct']);
        //     }
        // }

        return response()->json(['chapter' => $chapter], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function chapter(Request $request)
    {
        $chapter = Chapter::with('content', 'quizzes')->find($request->chapter_id);
        // by ali
        $videoArray = [];
        $fileArray = [];
        if ($chapter->content) {
            foreach ($chapter->content as $content) {
                if(isset($content['video'])){
                    array_push($videoArray,$content['video']);
                }
                if(isset($content['file'])){
                    array_push($fileArray,$content['file']);
                }
            }
        }
        unset($chapter->content);
        $chapter->videos=$videoArray;
        $chapter->files=$fileArray;
        // ==================================quizzes====================
        if ($chapter->quizzes) {

            foreach ($chapter->quizzes as $quiz) {
                $quizOption=[];
                array_push($quizOption,$quiz['first_option']);
                array_push($quizOption,$quiz['second_option']);
                array_push($quizOption,$quiz['third_option']);
                array_push($quizOption,$quiz['fourth_option']);
                unset($quiz['first_option']);
                unset($quiz['second_option']);
                unset($quiz['third_option']);
                unset($quiz['fourth_option']);
                $quiz->options=$quizOption;
                $quiz->correctIndex=$quiz['correct']-1;
                unset($quiz['correct']);
            }
        }
        // by ali end

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
        $question = Question::where('chapter_id', $request->chapter_id)->get()->random(5);
        
        if ($question) {
            foreach ($question as $quiz) {
                $quizOption=[];
                array_push($quizOption,$quiz['first_option']);
                array_push($quizOption,$quiz['second_option']);
                array_push($quizOption,$quiz['third_option']);
                array_push($quizOption,$quiz['fourth_option']);
                unset($quiz['first_option']);
                unset($quiz['second_option']);
                unset($quiz['third_option']);
                unset($quiz['fourth_option']);
                $quiz->options=$quizOption;
                $quiz->correctIndex=$quiz['correct']-1;
                unset($quiz['correct']);
            }
        }
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
