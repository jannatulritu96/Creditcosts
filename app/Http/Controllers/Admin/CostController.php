<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Cost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
Use App\User;
class CostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['title'] = 'Cost Information';
        $categories = Category::get();
        $cost = Cost::get();
        $user = User::where('role', 2)->get();
        $cost = Cost::get();
        $search_key = $request->search;
        $type_key = $request->category_type;
        $month_key = isset($request->month)? $request->month : date('m');
        $year_key = isset($request->year)? $request->year : date('Y');
        $user_key = $request->user_type;
        $month = $request->month;
        $year = $request->year;
        $date_key = $request->date;

        return view('admin.cost.index', compact('data','cost','user','categories', 'search_key', 'type_key', 'month', 'year', 'month_key', 'year_key', 'user_key', 'date_key'));

    }
    public function searchCostPage(Request $request){

        $sql =  Cost::with(['relUser','relCategory']);
            if($request->category_type){
                $sql->where('category_id', '=', $request->category_type);
            }
            if($request->month){
                $sql->whereMonth('cost_date', '=',$request->month);
            }
            if($request->year){
                $sql->whereYear('cost_date', '=',$request->year);
            }

            if($request->date){
                $sql->whereDate('cost_date', '=',$request->date);
            }

            if(isset($request->user_type)){
                $sql->where('user_id', '=', $request->user_type);
            }
            if(Auth::user()->role == 2){
                $sql->where('user_id', Auth::user()->id);
            }
            if(isset($request->search)){
                $sql->where(function ($q) use($request){
                    $q->where('title', '=', $request->search);
                    $q->orWhereHas('relUser', function($qK) use($request){
                        $qK->where('name', '=', $request->search);
                    });                    
                });
            }

            if($request->month || $request->year || $request->date){
                $sql->orderBy('cost_date', 'ASC');
            } else {
                $sql->orderBy('cost_date', 'desc');
            }

            $data= $sql->get();

            $total = 0;
            foreach ($data as $cost) {
                $total += $cost->amount;
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
        $data['users'] = User::where('role',2)->get();
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
        $cost = new Cost();

        if(Auth::user()->role == 1){
            $cost->user_id= $request->user_id;
        }else{
            $cost->user_id= auth()->user()->id;
        }

        $cost->category_id = $request->category_id;
        $cost->title= $request->title;
        $cost->description=$request->description;
        $cost->amount=$request->amount;
        $cost->cost_date=$request->cost_date;

        $check = $cost->save();

        if(Auth::user()->role == 1){
            $Manager = User::find($request->user_id);
        }else{
            $Manager = User::find(auth()->user()->id);
        }
        $Manager->balance = $Manager->balance - $request->amount;
        $Manager ->save();

        if ($check) {
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'fail']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['cost'] = Cost::findOrFail($id);
        $data['title']= 'Edit Cost';
        $data['users'] = User::where('role',2)->get();
        $data['categories'] = Category::get();

        if($data){
            return response()->json(['status'=>'success', 'data'=>$data]);
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
        $cost = Cost::findOrFail($id);

        if(Auth::user()->role == 1){
            $dbAmount = User::find($request->user_id);
        }else{
            $dbAmount = User::find(auth()->user()->id);
        }

        $dbAmount->balance = $dbAmount->balance + $cost->amount;

        if(Auth::user()->role == 1){
            $cost->user_id= $request->user_id;
        }else{
            $cost->user_id= auth()->user()->id;
        }
        $cost->category_id = $request->category_id;
        $cost->title= $request->title;
        $cost->description=$request->description;
        $cost->amount=$request->amount;
        $cost->cost_date=$request->cost_date;
        $cost->save();

        $dbAmount->balance = $dbAmount->balance - $request->amount;
        $dbAmount ->save();

        if($cost->update()){
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

        $cost = Cost::findOrFail($id);
        $dbAmount = User::find($cost->user_id);
        $dbAmount->balance = $dbAmount->balance + $cost->amount;
        $dbAmount->save();
        if ($cost->delete() == 1) {
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
