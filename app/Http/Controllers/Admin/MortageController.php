<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMortageRequest;
use App\Http\Requests\StoreMortageRequest;
use App\Http\Requests\UpdateMortageRequest;
use App\Models\Mortage;
use App\Models\installment;
use App\Models\Payment;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MortageController extends Controller
{

    public function index()
    {
        abort_if(Gate::denies('mortage_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $mortages = Mortage::with(['user'])->get();
        return view('admin.mortages.index', compact('mortages'));
    }

    public function create()
    {
        abort_if(Gate::denies('mortage_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.mortages.create', compact('users'));
    }

    public function store(Request $request)
    {
    //    return  $request;
        $mortage = new Mortage;
        $mortage->loandamoutn = $request->loandamoutn;
        $mortage->downpayment = $request->downpayment;
        $mortage->percentage = $request->percentage;
        $mortage->loan_terms = $request->loan_terms;
        $mortage->start_date = $request->start_date;
        $mortage->user_id  = $request->user_id;
        $mortage->save();
        $mortId = $mortage->id;

        //GETTING DATA FROM DB
        //GETTING USER INPUTS AND ASSIGNING THEM TO VARIABLES

        $amount = $request->loandamoutn - $request->downpayment ;

        $interest = $request->percentage;
        $interest = (int) filter_var($interest, FILTER_SANITIZE_NUMBER_INT);

        $year = $request->loan_terms;
        $strtdate = $request->start_date;

        $term = 12;

        //creating period
        $period = $term * $year;
        $monthlyinterest = ($interest / 100) / $term;

        // making percentage in $interest
        //Creating the Denominator
        $deno = 1 - 1 / pow((1 + $monthlyinterest), $period);

        $j = $amount;
        $array = [];
        $i = 1;
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
            //  $j -= (int)$principal;
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
        foreach ($array as $data) {
            $installment = new installment;
            $installment->mortage_id = $mortId;
            $installment->status = 0;
            $installment->install_id =$data['install_id'];
            $installment->payment_dues = $data['payment'];
            $installment->interest_dues = $data['Interest'];
            $installment->principal_dues = $data['principal'];
            $installment->balance = $data['balance'];
            $installment->save();
        }


        return redirect()->route('admin.mortages.index');
    }

    public function edit(Mortage $mortage)
    {
        abort_if(Gate::denies('mortage_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $mortage->load('user');
        return view('admin.mortages.edit', compact('mortage', 'users'));
    }

    public function update(Request $request, Mortage $mortage)
    {
        $mortage->update($request->all());


          // GETTING USER INPUTS AND ASSIGNING THEM TO VARIABLES
          $amount = $request->loandamoutn;
          $year = $request->loan_terms;
        //   $strtdate = $request->start_date;

          $interest = $request->percentage;
          $interest = (int) filter_var($interest, FILTER_SANITIZE_NUMBER_INT);
  
          //creating period
          $term = 12;
          $period = $term * $year;
        
          $monthlyinterest = ($interest / 100) / $term;
  
          // making percentage in $interest
          //Creating the Denominator
          $deno = 1 - 1 / pow((1 + $monthlyinterest), $period);
  
          $j = $amount;
          $array = [];
  
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
                      'payment' => $payment,
                      'Interest' => $periodInterest,
                      'principal' => $principal,
                      'balance' => $j
                  ];
              }
          }
          $installment = installment::where('mortage_id',$request->id)->get();
          foreach($installment as $data)
          {
              $data->delete();
          }

          foreach ($array as $data) {
            $installment = new installment;
              $installment->mortage_id = $request->id;
              $installment->payment_dues = $data['payment'];
              $installment->interest_dues = $data['Interest'];
              $installment->principal_dues = $data['principal'];
              $installment->balance = $data['balance'];
              $installment->save();
          }
        return redirect()->route('admin.mortages.index');
    }

    public function show(Mortage $mortage)
    {
        abort_if(Gate::denies('mortage_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $mortage->load('user');

        return view('admin.mortages.show', compact('mortage'));
    }

    public function destroy(Mortage $mortage)
    {

        abort_if(Gate::denies('mortage_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
         $mortage->delete();
        $payment = Payment::where('mortage_id',$mortage->id)->get();
        foreach($payment as $data)
        {
            $data->delete();
        }
        $installment = installment::where('mortage_id',$mortage->id)->get();
        foreach($installment as $data)
        {
            $data->delete();
        }

        return back();
    }

    public function massDestroy(MassDestroyMortageRequest $request)
    {
        Mortage::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
