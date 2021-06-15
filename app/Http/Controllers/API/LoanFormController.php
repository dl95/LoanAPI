<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Loan;
use App\Models\LoanRepayment;

class LoanFormController extends Controller
{

    public function loanApprove($id)
    {
        $data = [];
        date_default_timezone_set('Asia/Kolkata');
        $loan = auth()->user()->loans()->find($id);
        $loan->status = "approved";
        $loan->approved_date = date('Y-m-d', time()); 
        if (!$loan) {
            return response()->json([
                'success' => false,
                'message' => 'loan not found'
            ], 400);
        }
 
        $updated = $loan->fill($data)->save();
 
        if ($updated)
            return response()->json([
                'success' => true,
                'message' => 'loan successfully approved'
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'loan can not be updated'
            ], 500);
        
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    //    $loans = Loan::all();
    //    if (count($loans)!=0) {
    //        return response()->json([
    //            'success' => true,
    //            'data' => $loans
    //        ]);
    //    } else {
    //     return response()->json([
    //         'success' => true,
    //         'message' => "loans list not found"
    //     ]);
    //    }
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
        $this->validate($request, [
            'amount' => 'required',
            'term' => 'required'
        ]);
 
        $loan = new Loan();
        $loan->amount = $request->amount;
        $loan->term = $request->term;
        if (auth()->user()->loans()->save($loan))
            return response()->json([
                'success' => true,
                'data' => $loan->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Loans not created'
            ], 500);
        
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
