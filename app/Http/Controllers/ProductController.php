<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Plan;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Service;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Auth;
use DataTables;

class ProductController extends Controller
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
        return view('tenant.product.list');
    }

    public function save($data)
    {
        return Product::create($data);
    }

    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'label' => 'required | string',
                'description' => 'required | string ',
                'service_id' => 'required ',
                'categories' => 'required ',
                'duration_length' => 'required',
                'price' => 'required | string ',
                'type' => 'required',
                'billing_period' => 'required | string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->with('error', $validator->messages()->first());
            }

            $service = Service::find($request->service_id);
            $tenant = Tenant::find($service->tenant_id);

            $data = $request->only((new Product())->getFillable());
            $data['uuid'] = Str::uuid()->toString();
            $product = $this->save($data);

            foreach ($request->categories as $category){
                ProductCategory::create([
                    "product_id"=> $product->id,
                    "category_id"=> $category
                ]);
            }

            $plan = Plan::create([
                "product_id" => $product->id,
                "price" => json_encode(['XAF' => $request->price]),
                "duration" => json_encode([
                    $request->duration_phase != null ? $request->duration_phase :'DAYS' => $request->duration_length]),
                "type" => $request->type,
                "billing_period" => $request->billing_period
            ]);

            if ($product) {
                return (new TenantController())->settings($tenant->uuid);
            } else {
                return redirect()->back()->with('error', 'Failed to create new product ! Try again.');
            }
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->with('error', $bug);
        }
    }


    public function getProductList(Request $request, $service_uuid)
    {

        $service = Service::where('uuid', $service_uuid)->first();
        $tenant = Tenant::find($service->tenant_id);
        $data = Product::orderBy('label', 'ASC')->where('service_id', $service->id)->get();

        return Datatables::of($data)
            ->addColumn('action', function ($data) use ($tenant) {
                if ($data->name == 'Super Admin') {
                    return '';
                }
                if (Auth::user()->can('manage_user')) {
                    return '<div class="table-actions">
                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Edit">
                                    <a href="'.url('products/update', [$data->id, $tenant->uuid]).'"><i class="ik ik-edit-2 f-16 mr-15 text-green"></i></a>
                                </span>
                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Delete">
                                    <a href="'.url('products/delete/'.$data->uuid).'"><i class="ik ik-trash-2 f-16 text-yellow"></i></a>
                                </span>
                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Remove">
                                    <a href="'.url('products/destroy/'.$data->uuid).'"><i class="ik ik-trash f-16 text-red"></i></a>
                                </span>
                            </div>';
                } else {
                    return '';
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function destroy($uuid)
    {
        $product = Product::where('uuid', $uuid)->first();
        $service = Service::find($product->service_id);
        $tenant = Tenant::find($service->tenant_id);
        if ($product) {
            $product->forceDelete();
            return (new TenantController())->settings($tenant->uuid);
            //return redirect('tenants')->with('success', 'Tenant removed!');
        } else {
            return redirect("tenant/settings/".$tenant->uuid)->with('error', 'Service not found');
        }
    }

    public function delete($uuid)
    {
        $product = Product::where('uuid', $uuid)->first();
        $service = Service::find($product->service_id);
        $tenant = Tenant::find($service->tenant_id);
        if ($product) {
            $product->delete();
            return (new TenantController())->settings($tenant->uuid);
        } else {
            return redirect("tenant/settings/".$tenant->uuid)->with('error', 'Service not found');
        }
    }

    public function update(Request $request)
    {
        // update tenant info
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'service_id' => 'required',
            'label' => 'required | string',
            'description' => 'required | string',
            'categories' => 'required ',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }

        try {
            $product = Product::find($request->id);
            $data = $request->only((new Product())->getFillable());
            $update = $product->update($data);


            $productCategories = ProductCategory::where('product_id', $product->id)->get();

            foreach ($productCategories as $productCategory){
                $productCategory->forceDelete();
            }

            foreach ($request->categories as $category){
                ProductCategory::create([
                    "product_id"=> $product->id,
                    "category_id"=> $category
                ]);
            }

            if ($update) {
                return redirect('tenants')->with('success', 'Service information updated successfully !');
            } else {
                return redirect('tenants')->with('error', 'Failed to update the service! Try again.');
            }
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->with('error', $bug);
        }
    }

    public function create(Request $request, $uuid){

        $tenant = Tenant::where('uuid', $uuid)->first();

        $services = Service::where('tenant_id', $tenant->id)->get();
        $categories = Category::all();
        return view('tenant.product.create', compact(['services', 'categories']));
    }

    public function edit($id, $uuid){
        $product = Product::where('id', $id)->with('categories')->with('service')->first();
        $tenant = Tenant::where('uuid', $uuid)->first();
        $services = Service::where('tenant_id', $tenant->id)->get();
        $categories = Category::all();
        return view('tenant.product.edit', compact(['services', 'categories', 'product']));
    }

}
