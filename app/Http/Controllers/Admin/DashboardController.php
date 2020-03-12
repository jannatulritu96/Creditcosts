<?php

namespace App\Http\Controllers\Admin;

use App\Models\BalanceHistory;
use App\Models\Category;
use App\Models\Cost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\user;
use Illuminate\Support\Facades\Hash;
class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        //cost search
        $cost = Cost::where('user_id', Auth::user()->id)->get();
        $cost_month_key = $request->cost_month;
        $cost_year_key = $request->cost_year;
        $cost_date_key = $request->costs_date;

        //deposit search
        $deposit = BalanceHistory::where('user_id', Auth::user()->id)->get();
        $deposit_month_key = $request->depo_month;
        $deposit_year_key = $request->depo_year;
        $deposit_date_key = $request->depo_date;

        //total history
        $month_key = $request->month;
        $year_key = $request->year;
        $date_key = $request->date;
        $current_balance = Auth::user()->balance;
        $managerDeposit = BalanceHistory::where('user_id',Auth::user()->id)->sum('amount');
        $costs = Cost::where('user_id', Auth::user()->id)->sum('amount');

       //owner panel
        $total_manager= User::where('role',2)->count();
        $total_cost = Cost::sum('amount');
        $total_deposite = BalanceHistory::sum('amount');
        $total_balance = $total_deposite - $total_cost;
        $total_category = Category::count();

        return view('admin.dashboard',compact('total_manager', 'total_cost', 'total_deposite', 'total_balance', 'total_category', 'current_balance', 'managerDeposit', 'costs', 'deposit', 'cost', 'month_key', 'year_key', 'date_key','deposit_month_key','deposit_year_key','deposit_date_key', 'cost_month_key', 'cost_year_key', 'cost_date_key'));
    }

    public function managerSearchDeposit(Request $request){

                $deposit = BalanceHistory::where('user_id', Auth::user()->id);
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
         $deposit= $deposit->get();

        return response()->json(['status'=>'success', 'data' => $deposit]);
    }

    public function managerSearchCost(Request $request){

                $cost = Cost::where('user_id', Auth::user()->id);
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

                if($request->cost_month || $request->cost_year || $request->costs_date){
                    $cost->orderBy('cost_date', 'ASC');
                } else {
                    $cost->orderBy('cost_date', 'desc');
                }
    
         $cost= $cost->get();
        return response()->json(['status'=>'success', 'data' => $cost]);
    }

    public function managerSearchTotalHistory(Request $request){

                $cost = Cost::where('user_id', Auth::user()->id);
                $deposit = BalanceHistory::where('user_id', Auth::user()->id);

                // search for cost
                if($request->month){
                    $cost->whereMonth('cost_date', '=',$request->month);
                }
                if($request->year){
                    $cost->whereYear('cost_date', '=',$request->year);
                }
                if($request->date){
                    $cost->whereDate('cost_date', '=',$request->date);
                }

                // search for deposit
                if($request->month){
                    $deposit->whereMonth('deposit_date', '=',$request->month);
                }
                if($request->year){
                    $deposit->whereYear('deposit_date', '=',$request->year);
                }
                if($request->date){
                    $deposit->whereDate('deposit_date', '=',$request->date);
                }

                $datas['current_balance'] = Auth::user()->balance;
                $datas['managerDeposit'] =  $deposit->sum('amount');
                $datas['costs'] = $cost->sum('amount');
        return response()->json(['status'=>'success', 'data' => $datas]);
    }

    public function showResetForm()
    {
        return view('admin.change_password');
    }

    public function updatepassword(Request $request){
        $password=User::find(Auth::id())->password;
        $oldpass=$request->oldpass;

        if(Hash::check($oldpass,$password)){
            $user=User::find(Auth::id());
            $user->password=Hash::make($request->password);
            $user->save();
            Auth()->logout();
            return Redirect()->route('login')->with('success', 'Product save successfully!');
        }else{
            return Redirect()->back()->with('error', 'Product insert failed!');
        }

    }
}
