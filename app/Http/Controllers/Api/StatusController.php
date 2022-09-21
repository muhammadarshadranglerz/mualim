<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Score;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StatusController extends Controller
{

    public function status(Request $request)
    {
        $status = Status::where('teacher_id', Auth::id())->get();
        return response()->json([
            'satus' => $status,
        ], 200);
    }

    public function statusStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject_id' => 'required',
            'chapter_id' => 'required',
            'position' => 'required',
        ]);
        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors()->all(),
            ], 400);
        }

        $status = Status::create([
            'teacher_id' => Auth::id(),
            'subject_id' => $request->subject_id,
            'chapter_id' => $request->chapter_id,
            'position' => $request->position,
        ]);
        return response()->json([
            'satus' => 'updated successfully',
            'data' => $status,
        ], 200);
    }

    public function score(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject_id' => 'required',
            'chapter_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors()->all(),
            ], 400);
        }
        $score = Score::where([['teacher_id', Auth::id()], ['subject_id', $request->subject_id], ['chapter_id', $request->chapter_id]])->first();
        return response()->json([
            'data' => $score,
        ], 200);
    }

    public function scoreStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject_id' => 'required',
            'chapter_id' => 'required',
            'score' => 'required',
        ]);
        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors()->all(),
            ], 400);
        }

        $score = Score::create([
            'teacher_id' => Auth::id(),
            'subject_id' => $request->subject_id,
            'chapter_id' => $request->chapter_id,
            'score' => $request->score,
        ]);
        return response()->json([
            'satus' => 'updated successfully',
            'data' => $score,
        ], 200);
    }

}
