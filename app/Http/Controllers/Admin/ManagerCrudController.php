<?php

namespace App\Http\Controllers\Admin;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
Use App\User;
Use App\Models\BalanceHistory;
Use App\Models\Cost;
class ManagerCrudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::get();
        $search_key = $request->search;

return view('admin.manager.index', compact('user','search_key'));

    }
    public function searchManager(Request $request){
        $sql = User::where('role','2')->orderBy('name', 'asc');
        if(isset($request->search)){
            $sql->where('name', 'LIKE', '%'.$request->search.'%');
            $sql->orWhere('email', 'LIKE', '%'.$request->search. '%');
        }

        $data= $sql->get();

        return response()->json(['status'=>'success', 'data' => $data]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = null;
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

        $user = User::where(['email' => $request->email])->count();
        if($user <= 0) {
            $check = User::create([
                'name' => $request->name,
                'role' => 2,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            if ($check) {
                return response()->json(['status' => 'success']);
            }
            return response()->json(['status' => 'fail']);

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $data = User::find($id);
        $cost = Cost::where('user_id', $id)->get();
        $deposit = BalanceHistory::where('user_id', $id)->get();
        $month_key = $request->month;
        $year_key = $request->year;
        $date_key = $request->date;
        $current_balance = $data->balance;
        $deposite = $deposit->sum('amount');
        $costs = $cost->sum('amount');

        $deposit_month_key = $request->depo_month;
        $deposit_year_key = $request->depo_year;
        $deposit_date_key = $request->depo_date;

        $cost_month_key = $request->cost_month;
        $cost_year_key = $request->cost_year;
        $cost_date_key = $request->costs_date;

        return view('admin.manager.show', compact('data', 'current_balance', 'deposite', 'costs', 'deposit', 'cost', 'month_key', 'year_key', 'date_key','deposit_month_key','deposit_year_key','deposit_date_key', 'cost_month_key', 'cost_year_key', 'cost_date_key'));

    }

    public function searchDeposit(Request $request){

        $deposit = BalanceHistory::where('user_id', $request->id)->with(['category']);

        $deposit_month_key = $request->depo_month;
        $deposit_year_key = $request->depo_year;
        $deposit_date_key = $request->depo_date;
        $category_id_key = $request->depo_category_id;

                // search for deposit
                if($request->depo_month){
                    $deposit->whereMonth('deposit_date', '=',$request->depo_month);
                }
                if($request->depo_year){
                    $deposit->whereYear('deposit_date', '=',$request->depo_year);
                }
                if($request->depo_date){
                    $deposit->whereDate('deposit_date', '=',$request->depo_date);
                }
                 if($request->depo_category_id){
                    $deposit->where('category_id', '=',$request->category_id);
                }
         $deposit= $deposit->get();

        return response()->json(['status'=>'success', 'data' => $deposit]);
    }

    public function searchCost(Request $request){

        $cost = Cost::where('user_id', $request->id);
        $cost_month_key = $request->cost_month;
        $cost_year_key = $request->cost_year;
        $cost_date_key = $request->costs_date;

                // search for cost
                if($request->cost_month){
                    $cost->whereMonth('cost_date', '=',$request->cost_month);
                }
                if($request->cost_year){
                    $cost->whereYear('cost_date', '=',$request->cost_year);
                }
                if($request->costs_date){
                    $cost->whereDate('cost_date', '=',$request->costs_date);
                }

         $cost= $cost->get();
        return response()->json(['status'=>'success', 'data' => $cost]);
    }

    public function searchTotalHistory(Request $request){

        $data = User::find($request->id);
        $cost = Cost::where('user_id', $request->id);
        $deposit = BalanceHistory::where('user_id', $request->id);

            // Search for cost
            if($request->month){
                $cost->whereMonth('cost_date', '=',$request->month);
            }
            if($request->year){
                $cost->whereYear('cost_date', '=',$request->year);
            }
            if($request->date){
                $cost->whereDate('cost_date', '=',$request->date);
            }

            // Search for deposit
            if($request->month){
                $deposit->whereMonth('deposit_date', '=',$request->month);
            }
            if($request->year){
                $deposit->whereYear('deposit_date', '=',$request->year);
            }
            if($request->date){
                $deposit->whereDate('deposit_date', '=',$request->date);
            }

            $datas['current_balance'] = $data->balance;
            $datas['deposite'] = $deposit->sum('amount');
            $datas['costs'] = $cost->sum('amount');

        return response()->json(['status'=>'success', 'data' => $datas]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = User::find($id);

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

        $data= User::where(['id'=> $id])->update([
            'name' => $request->name,
            'role' => 2,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);


        if($data){
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
        $delete = BalanceHistory::where('user_id', $id)->delete();
        $delete = Cost::where('user_id', $id)->delete();

        $delete = User::find($id)->delete();

        if ($delete == 1) {
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
    public function balance(){
        $data['categories'] = Category::get();
        if($data){
            return response()->json(['status'=>'success', 'data'=>$data]);
        }
        return response()->json(['status'=>'fail']);
    }

    public function addBalance(Request $request){


        $balance =$request->balance;
        $category_id = $request->category_id;
        $deposit_date =$request->deposit_date;
        $user_id =$request->user_id;
        $data = User::where('id',$user_id)->increment('balance',$balance);
        if($data){
            $history = [
                'owner_id' => Auth::user()->id,
                'user_id' => $user_id,
                'amount' => $balance,
                'category_id' => $category_id,
                'deposit_date' =>  $deposit_date,
            ];
            $insert = BalanceHistory::create($history);
        }

        return response()->json(['status'=>'success']);
    }

    public function managerEnable($id){
        $data = User::find($id);
        $data->status = 1;
        $data->save();
        if($data->update()){
            return response()->json(['status'=>'success']);
        }
        return response()->json(['status'=>'fail']);
    }

    public function managerDisable($id){
        $data = User::find($id);
        $data->status = 0;
        $data->save();
        if($data->update()){
            return response()->json(['status'=>'success']);
        }
        return response()->json(['status'=>'fail']);
    }

    public function depoDestroy($id)
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
