<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Cost;
use App\Models\BalanceHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
Use App\User;
use App\Http\Controllers\Controller;
class ManagerDepositController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::get();
        $user = User::where('role', 2)->get();
        $deposit = BalanceHistory::where('user_id', Auth::user()->id);
        $search_key = $request->search;
        $type_key = $request->category_type;
        $month_key = isset($request->month)? $request->month : date('m');
        $year_key = isset($request->year)? $request->year : date('Y');
        $user_key = $request->user_type;
        $month = $request->month;
        $year = $request->year;
        $date_key = $request->date;

        return view('admin.deposit.index', compact('deposit','user','categories', 'search_key', 'type_key', 'month', 'year', 'month_key', 'year_key', 'user_key', 'date_key'));
    }

    public function searchDepositPage(Request $request){

        $deposit = BalanceHistory::with(['user','category'])->where('user_id', Auth::user()->id)
            ->where(function ($q) use($request){
                if($request->category_type){
                    $q->where('category_id', '=', $request->category_type);
                }

                if($request->month){
                    $q->whereMonth('deposit_date', '=',$request->month);
                }
                if($request->year){
                    $q->whereYear('deposit_date', '=',$request->year);
                }

                if($request->date){
                    $q->whereDate('deposit_date', '=',$request->date);
                }

                if($request->date){
                    $q->whereDate('deposit_date', '=',$request->date);
                }
            });

        $data= $deposit->get();

        $total = 0;
        foreach ($data as $deposit) {
            $total += $deposit->amount;
        }

        return response()->json(['status'=>'success', 'data' => $data, 'total' => $total]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['categories'] = Category::get();
        if($data){
            return response()->json(['status'=>'success', 'data'=>$data]);
        }
        return response()->json(['status'=>'fail']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $owner_id = 1;
        $user_id = Auth::user()->id;
        $amount =$request->amount;
        $category_id = $request->category_id;
        $deposit_date =$request->deposit_date;
        $data = User::where('id',Auth::user()->id)->increment('balance',$amount);
        if($data) {
            $history = [
                'owner_id' => $owner_id,
                'user_id' => $user_id,
                'amount' => $amount,
                'category_id' => $category_id,
                'deposit_date' => $deposit_date,
            ];
            $insert = BalanceHistory::create($history);
        }

        return response()->json(['status'=>'success']);

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
         $categories = Category::all();
         $data = BalanceHistory::with(['user','category'])->find($id);

        if($data){
            return response()->json(['status'=>'success', 'data'=>$data, 'categories' => $categories]);
        }
        return response()->json(['status'=>'fail']);
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
        $deposit = BalanceHistory::findOrFail($id);
        $dbAmount = User::find($deposit->user_id);
        $dbAmount->balance = $dbAmount->balance - $deposit->amount;
        $deposit->owner_id = 1;
        $deposit->user_id = Auth::user()->id;
        $deposit->amount =$request->amount;
        $deposit->category_id = $request->category_id;
        $deposit->deposit_date =$request->deposit_date;
        $deposit->save();

        $dbAmount->balance = $dbAmount->balance + $deposit->amount;
        $dbAmount ->save();

        if($deposit->update()){
            return response()->json(['status'=>'success']);
        }
        return response()->json(['status'=>'fail']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deposit = BalanceHistory::findOrFail($id);
        $dbAmount = User::find($deposit->user_id);
        $dbAmount->balance = $dbAmount->balance - $deposit->amount;
        $dbAmount->save();
        if ($deposit->delete() == 1) {
            $success = true;
            $message = "User deleted successfully";
        } else {
            $success = false;
            $message = "User not found";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}