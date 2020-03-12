<?php


namespace App\Http\Controllers\Admin;

Use App\Models\BalanceHistory;
Use App\Models\Cost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'Category List';
        $categories = Category::select('categories.*', \DB::raw('IFNULL(costs.costAmount, 0) AS costAmount'), \DB::raw('IFNULL(balance_histories.balanceAmount, 0) AS balanceAmount'))
        ->leftJoin(\DB::raw("(SELECT category_id, SUM(amount) as costAmount FROM costs GROUP BY category_id) AS costs"), 'categories.id', '=', 'costs.category_id')
        ->leftJoin(\DB::raw("(SELECT category_id, SUM(amount) as balanceAmount FROM balance_histories GROUP BY category_id) AS balance_histories"), 'categories.id', '=', 'balance_histories.category_id');
        $month_key = isset($request->month)? $request->month : date('m');
        $year_key = isset($request->year)? $request->year : date('Y');
        $month = $request->month;
        $year = $request->year;

        $render = [];

        $data['status'] = (isset($request->status)) ? $request->status : '';
        $categories = $categories->get();
        $data['categories'] = $categories;


        return view('admin.category.index', compact('data', 'month_key', 'year_key'));

    }

   

    public function searchCategoryPage(Request $request)
    {

        $costSql = '1';
        $depositSql = '1';
        if ($request->month) {
            $costSql .= ' AND MONTH(cost_date) ='.$request->month;
            $depositSql .= ' AND MONTH(deposit_date) ='.$request->month;
        }
        if ($request->year) {
            $costSql .= ' AND YEAR(cost_date) ='.$request->year;
            $depositSql .= ' AND YEAR(deposit_date) ='.$request->year;
        }

        $categories = Category::select('categories.*', \DB::raw('IFNULL(costs.costAmount, 0) AS costAmount'), \DB::raw('IFNULL(balance_histories.balanceAmount, 0) AS balanceAmount'))
        ->leftJoin(\DB::raw("(SELECT category_id, SUM(amount) as costAmount FROM costs WHERE $costSql GROUP BY category_id) AS costs"), 'categories.id', '=', 'costs.category_id')
        ->leftJoin(\DB::raw("(SELECT category_id, SUM(amount) as balanceAmount FROM balance_histories WHERE $depositSql GROUP BY category_id) AS balance_histories"), 'categories.id', '=', 'balance_histories.category_id');
            

        $categories = $categories->get();
        $data['categories'] = $categories;

        return response()->json(['status'=>'success', 'data' => $data]);
   
}

    public function create()
    {
        $data['title'] = 'Create category form';
        $data['categories'] = Category::get();

        if($data){
            return response()->json(['status'=>'success', 'data'=>$data]);
        }
        return response()->json(['status'=>'fail']);

    }
    public function store(Request $request)
    {
//         dd($request->all());
        $request->validate([
            'name'=>'required'
        ]);

        $check = Category::insert(['name'=> $request->name]);
        if ($check) {
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'fail']);
    }

    public function edit($id)
    {
        $data['category'] = Category::findOrFail($id);
        if($data){
            return response()->json(['status'=>'success', 'data'=>$data]);
        }
        return response()->json(['status'=>'fail']);

    }
    public function update(Request $request, $id)
    {

        $check = Category::where(['id'=> $id])->update([
            'name'=> $request->name
        ]);

        $arr = array('msg' => 'Something goes to wrong. Please try again later', 'status' => false);
        if($check){
            $arr = array('msg' => 'Successfully submit form using ajax', 'status' => true);
        }
        return Response()->json($arr);

    }
    public function destroy(Request $request)
    {
        $delete = Category::find($request->id)->delete();

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

}
