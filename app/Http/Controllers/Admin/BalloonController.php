<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bank;
use App\Models\Balloon;
use App\Models\Balloon_installment;
use App\Models\Transaction_history;

class BalloonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $balloon = Balloon::with('user')->get();
        return view('admin.balloon_loan.index',compact('balloon'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $user = User::whereHas('roles', function ($q) {
            $q->where('title', 'User');
        })->get();
        $banks = Bank::all();
        return view('admin.balloon_loan.create', compact('user','banks'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $loan = new Balloon;
        $loan->user_id = $request->user_id;
        $loan->amount = $request->amount;
        $loan->downpayment = $request->downpayment;
        $loan->percentage = $request->percentage;
        $loan->balloon_period = $request->balloon_terms;
        $loan->loan_terms = $request->loan_terms;
        $loan->starttime = $request->start_date;
        $loan->save();
        $balloon_id = $loan->id;

        // Add downpayment in the select bank
        $bank = Bank::where('id', $request->receiver)->first();
        $bank->id = $request->receiver;
        $new_balance = $bank->total_balance +  $request->downpayment;
        $bank->total_balance = $new_balance;
        $bank->save();

        // Add Transaction History of Receiver in bank
        $history = new Transaction_history();
        $history->bank_id = $request->receiver;
        $customer = User::where('id',$request->user_id)->first();
        $history->from = $customer->name;
        $history->amount = $request->downpayment;
        $history->date = $request->start_date;
        $history->status = 'Received';
        $history->purpose = 'Downpayment';
        $history->save();

        $amount = $request->amount - $request->downpayment ;

        $interest = $request->percentage;
        $interest = (int) filter_var($interest, FILTER_SANITIZE_NUMBER_INT);

        $year = $request->loan_terms;
        $strtdate = $request->start_date;

        $term = 12;

        //creating period
        $period = $term * $year;
        $balloon_term = $request->balloon_terms*12;
        $monthlyinterest = ($interest / 100) / $term;
        // return gettype($monthlyinterest);

        // making percentage in $interest
        //Creating the Denominator
        $deno = 1 - 1 / pow((1 + $monthlyinterest), $period);

        $j = $amount;
        $array = [];
        $i = 1;
        $x = 1;
        while ($x < $balloon_term) {
            //Payment for a period
            $payment = ($amount * $monthlyinterest) / $deno;
            $Monthly_payment = number_format($payment, 2, '.', '');

            //Interest for a Period
            $periodInterest = $j * $monthlyinterest;
            $periodInterest = number_format($periodInterest, 2, '.', '');

            //Principal for a Period
            $principal = $Monthly_payment - $periodInterest;
            $principal = number_format($principal, 2, '.', '');

            //Getting the Balance
            $j = $j - $principal;
            $j = number_format($j, 2, '.', '');

                $array[] = [
                    'install_id'=>$i,
                    'payment' => $Monthly_payment,
                    'Interest' => $periodInterest,
                    'principal' => $principal,
                    'balance' => $j
                ];

            $i++;
            $x++;
        }
//   dd($array);


  foreach ($array as $data) {
      $installment = new Balloon_installment;
      $installment->balloon_id = $balloon_id;
      $installment->status = 0;
      $installment->install_id =$data['install_id'];
      $installment->payment = $data['payment'];
      $installment->interest = $data['Interest'];
      $installment->principal = $data['principal'];
      $installment->balance = $data['balance'];
    $installment->save();
  }


    $last =  Balloon_installment::orderBy('id', 'DESC')->limit(1)->first();
    $installment = new Balloon_installment;
    $installment->balloon_id = $last->balloon_id;
    $installment->status = 0;
    $installment->install_id = $last->install_id+1;
    $Interest = $monthlyinterest * $last->balance;
    $Interest = number_format($Interest, 2, '.', '');

    $installment->interest = $Interest;
    $installment->principal = $last->balance;
    $installment->payment = $last->balance + $Interest;
    $installment->balance = '0';
    // return$Interest;

    $installment->save();

        return redirect()->route('admin.balloon_index');

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
        $balloon = Balloon::find($id);
        $balloon->delete();
        return redirect()->route('admin.balloon_index');
    }
}
