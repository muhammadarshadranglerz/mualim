<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction_history;
use Illuminate\Http\Request;
use App\Models\Mortage;
use App\Models\installment;
use App\Models\Payment;
use Carbon\Carbon;
use App\Models\Bank;


class customerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mortages = Mortage::with('payments')->get();


        return view('admin.customer.index', compact('mortages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        $payment = new Payment;
        $payment->mortage_id = $request->mortage_id;
        $payment->install_id = $request->install_id;
        $payment->date = $request->date;
        $payment->payment = $request->payment;
        $payment->late_fee = $request->late_fee;
        $payment->principal = $request->principal;
        $payment->save();

        $pay_payments =  $request->payment +  $request->late_fee;

        $bank = Bank::where('id', $request->receiver)->first();
        $bank->id = $request->receiver;
        $new_balance = $bank->total_balance +  $pay_payments;
        $bank->total_balance = $new_balance;
        $bank->save();

        // Add Transaction History of Receiver in bank
        $history = new Transaction_history();
        $history->bank_id = $request->receiver;
        $history->from = $request->name;
        $history->amount = $pay_payments;
        $history->date = $request->date;
        $history->status = 'Received';
        $history->save();


        // //update current installment in summary
        $id = $request->install_id;
        $installment = installment::where('install_id', $id)->where('mortage_id', $request->mortage_id)->first();
        $interest = $installment->interest_dues;
        if ($id == 1)
         {
            $installment = installment::where('install_id', $id)->where('mortage_id', $request->mortage_id)->first();
            $balance = $installment->balance +  $installment->principal_dues;
        }
        else
         {
            $installment = installment::where('install_id', $id - 1)->where('mortage_id', $request->mortage_id)->first();
            $balance = $installment->balance;
        }
        $interest = $interest;
        $principal =  $request->payment -  $interest;
        $principal = number_format($principal, 2, '.', '');
        $end_balan = $balance - $principal;

        $installment = installment::where('install_id', $id)->where('mortage_id', $request->mortage_id)->first();
        $installment->payment_dues  = $request->payment;
        $installment->late_fee  = $request->late_fee;
        $installment->interest_dues = $interest;
        $installment->principal_dues = $principal;
        $installment->status = 1;
        $installment->balance =  $end_balan;
        $installment->save();
        //----------------------------------------------------------------------------------------------------
        //get data from Mortage of that user
        $mortage = Mortage::where('id', $request->mortage_id)->get();
        $amount = $mortage[0]->loandamoutn;
        $t_month = $mortage[0]->loan_terms * 12;
        $r_month = $t_month - $id;
        $interest = $mortage[0]->percentage;
        $interest = (int) filter_var($interest, FILTER_SANITIZE_NUMBER_INT);

        //creating monthly interest
        $monthlyinterest = ($interest / 100) / 12;

        //Creating the Denominator
        $deno = 1 - 1 / pow((1 + $monthlyinterest), $t_month);

        $j =$end_balan;
        $array = [];
        $i = $id+1;
        while ($j > 0) {
            //Payment for a period
            $payment = ($amount * $monthlyinterest) / $deno;
            $payment = number_format($payment, 2, '.', '');

            //Interest for a Period
            $periodInterest = $j * $monthlyinterest;
            $periodInterest = number_format($periodInterest, 2, '.', '');

            //Principal for a Period
            $principal = $payment - $periodInterest;
            $principal = number_format($principal, 2, '.', '');

            //Getting the Balance
            $j = $j - $principal;
            $j = number_format($j, 2, '.', '');
            if ($j >= 0) {
                $array[] = [
                    'install_id'=>$i,
                    'payment' => $payment,
                    'Interest' => $periodInterest,
                    'principal' => $principal,
                    'balance' => $j
                ];
            }
            $i++;
        }
        // return $array;

        $id = $request->install_id;
        $id = (int)$id;
        $R_installment = installment::where('install_id', '>', $id)->where('mortage_id', $request->mortage_id)->get();
        foreach ($R_installment as $data) {
            $data->delete();
        }

        //update remainig installment in summary
        foreach ($array as $data) {
            $installment = new installment;
            $installment->mortage_id = $request->mortage_id;;
            $installment->status = 0;
            $installment->install_id = $data['install_id'];
            $installment->payment_dues = $data['payment'];
            $installment->interest_dues = $data['Interest'];
            $installment->principal_dues = $data['principal'];
            $installment->balance = $data['balance'];
            $installment->save();
        }

        return back();
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
    }
}
