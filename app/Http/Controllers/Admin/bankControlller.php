<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\Transaction_history;


class bankControlller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $bank = Bank::all();
        return view('admin.bank.index', compact('bank'));
        // return view('admin.bank.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.bank.create');
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
        $bank = new Bank();
        $bank->name = $request->name;
        $bank->bank_name = $request->bank_name;
        $bank->total_balance = $request->total_balance;
        $bank->save();

        return redirect()->route('admin.bank_index');
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
        $bank = Bank::find($id);
        $bank->delete();
        return redirect()->route('admin.bank_index');
    }
    public function history($id)
    {
        //
        $id = $id;
        $history = Transaction_history::where('bank_id', $id)->get();
        // $bank = Bank::with('history')->where('id',$id)->get();
        return view('admin.bank.tansaction_history.index', compact('history', 'id'));
    }

    public function delhistory(Request $request)
    {

        $history = Transaction_history::where('bank_id', $request->bank_id)->get();
        // $bank = Bank::with('historys')->where('id',$request->bank_id)->get();

        foreach($history as $data) 
        {
            $data->delete();
        }
        return back();
    }
}
