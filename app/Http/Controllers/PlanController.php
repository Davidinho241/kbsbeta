<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\Plan;
use Illuminate\Support\Str;

class PlanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $plans = Plan::with('product')->paginate(20);
        return view('tenant.plan.index', compact('plans'));
    }

    public function save($data)
    {
        return Plan::create($data);
    }

    public function store($data)
    {
        try {

            $validator = Validator::make($data, [
                'product_id' => 'required | exits:products,id',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->with('error', $validator->messages()->first());
            }

            // store plan information
            return $this->save($data);
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->with('error', $bug);
        }
    }
}
