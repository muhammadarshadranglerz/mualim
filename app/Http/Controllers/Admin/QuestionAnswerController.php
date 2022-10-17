<?php

namespace App\Http\Controllers\Admin;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\QuestionOption;

class QuestionAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $chapters = Chapter::all();
        $questions = Question::all();
        return view('admin.question-answer.index', compact('questions','chapters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $chapters = Chapter::all();

        return view("admin.question-answer.create", compact('chapters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
       
        Question::create(
            $request->only('question', 'details', 'chapter_id', 'first_option', 'second_option', 'third_option', 'fourth_option', 'correct')
        );
        return redirect()->back()->with('success', "Question Added");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $question=Question::findOrFail($id);
        return view('admin.question-answer.single',compact('question'));
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
        $question = Question::findOrFail($id);
        $chapters = Chapter::all();

        return view("admin.question-answer.edit", ['chapters' => $chapters, 'question' => $question]);
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
       
        Question::find($id)
            ->update(
                $request->only('question', 'details', 'first_option', 'second_option', 'third_option', 'fourth_option', 'correct')
            );
        return redirect()->route("admin.question-answer.index")->with('success', "Question Updated");
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
        Question::destroy($id);
        // QuestionOption::where('question_id', $id)->first()->delete();
        return redirect()->route("admin.question-answer.index")->with('success', "Question Deleted");
    }
}
