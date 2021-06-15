<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\LoanRepayment;
use App\Models\Loan;

class LoanRepaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        //
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
        date_default_timezone_set('Asia/Kolkata');
        $now = Carbon::now();
        $date = Carbon::now()->format('Y-m-d');
        $validator = Validator::make($request->all(), [ 
            'amount' => 'required',
            'loan_id' => 'required'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        } else{
            $loan = Loan::select("amount")->where('user_id', \Auth::user()->id)->where('id', $request->loan_id)->first();
            $repayment = LoanRepayment::where('user_id', \Auth::user()->id)->where('loan_id', $request->loan_id)->orderBy('created_at')->first();
            if ($loan) {
                if ($repayment) {
                    if ($loan->amount <= $repayment->remaining_amount) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Loan amount is already paid'
                        ], 403);
                    }
                    $repaymentDate = $repayment->date;
                    $weekStartDate = $now->startOfWeek()->format('Y-m-d');
                    $weekEndDate = $now->endOfWeek()->format('Y-m-d');
                    if ($date >= $weekStartDate && $date <= $weekEndDate) {
                        $repayment = new LoanRepayment();
                        $repayment->amount = $request->amount;
                        $repayment->loan_id = $request->loan_id;
                        $repayment->remaining_amount = $repayment->remaining_amount-$request->amount;
                        $repayment->date = $date;
                        if (auth()->user()->loans()->save($repayment))
                            return response()->json([
                                'success' => true,
                                'data' => $repayment->toArray()
                            ]);
                        else
                            return response()->json([
                                'success' => false,
                                'message' => 'Loans repayment not done'
                            ], 500);
                    } else {
                        return response()->json([
                            'success' => true,
                            'message' => 'Payment already made of this week'
                        ], 403);
                    }
                } else {
                    $repayment = new LoanRepayment();
                    $repayment->amount = $request->amount;
                    $repayment->date = $date;
                    $repayment->remaining_amount = $loan->amount-$request->amount;
                    $repayment->loan_id = $request->loan_id;
                    if (auth()->user()->loans()->save($repayment))
                        return response()->json([
                            'success' => true,
                            'data' => $repayment->toArray()
                        ]);
                    else
                        return response()->json([
                            'success' => false,
                            'message' => 'Loans not created'
                        ], 500);
                }  
                return $repayment;
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Loan not found'
                ], 404);
            }
        }
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
