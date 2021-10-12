<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\Tenant;
use Illuminate\Support\Str;

class TenantController extends Controller
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
        return view('tenant.tenants');
    }

    public function create()
    {
        return view('tenant.create-tenant');
    }

    public function save($data)
    {
        return Tenant::create($data);
    }

    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'api_key' => 'required | string',
                'api_secret' => 'required | string ',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->with('error', $validator->messages()->first());
            }

            $user = $request->user();

            // store user information
            $data = $request->only((new Tenant())->getFillable());
            $data['uuid'] = Str::uuid()->toString();
            $data['created_by'] = $user->name;
            $tenant = $this->save($data);

            if ($tenant) {
                return redirect('tenants')->with('success', 'New tenant created!');
            } else {
                return redirect('tenants')->with('error', 'Failed to create new tenant! Try again.');
            }
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->with('error', $bug);
        }
    }

    public function getTenantList(Request $request)
    {
        $data = Tenant::orderBy('api_key', 'ASC')->get();

        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                if ($data->name == 'Super Admin') {
                    return '';
                }
                if (Auth::user()->can('manage_user')) {
                    return '<div class="table-actions">
                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Setting">
                                    <a href="'.url('tenant/settings/'.$data->uuid).'"  ><i class="ik ik-settings f-16 mr-15 text-blue"></i></a>
                                </span>
                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Edit">
                                    <a href="'.url('tenant/'.$data->uuid).'" ><i class="ik ik-edit-2 f-16 mr-15 text-green"></i></a>
                                </span>
                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Delete">
                                    <a href="'.url('tenant/delete/'.$data->uuid).'"><i class="ik ik-trash-2 f-16 text-yellow"></i></a>
                                </span>
                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Remove">
                                    <a href="'.url('tenant/destroy/'.$data->uuid).'"><i class="ik ik-trash f-16 text-red"></i></a>
                                </span>
                            </div>';
                } else {
                    return '';
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function edit($uuid)
    {
        try {
            $tenant = Tenant::where('uuid', $uuid)->first();

            if ($tenant) {
                return view('tenant.tenant-edit', compact('tenant'));
            } else {
                return redirect('404');
            }
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->with('error', $bug);
        }
    }

    public function settings($uuid)
    {
        try {
            $tenant = Tenant::where('uuid', $uuid)->with('customers')->with('services')->first();

            if ($tenant) {
                return view('tenant.tenant-settings', compact('tenant'));
            } else {
                return redirect('404');
            }
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->with('error', $bug);
        }
    }

    public function update(Request $request)
    {
        // update tenant info
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'api_key' => 'required | string ',
            'api_secret' => 'required | string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }

        try {
            $user = $request->user();
            $tenant = Tenant::find($request->id);

            $data = $request->only((new Tenant())->getFillable());
            $data['updated_by'] = $user->name;

            $update = $tenant->update($data);

            if ($update) {
                return redirect()->back()->with('success', 'Tenant information updated successfully !');
            } else {
                return redirect('tenants')->with('error', 'Failed to update the tenant! Try again.');
            }
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->with('error', $bug);
        }
    }

    public function destroy($uuid)
    {
        $tenant = Tenant::withTrashed()->where('uuid', $uuid)->first();
        if ($tenant) {
            $tenant->forceDelete();
            return redirect('tenants')->with('success', 'Tenant removed!');
        } else {
            return redirect('tenants')->with('error', 'Tenant not found');
        }
    }

    public function delete($uuid)
    {
        $tenant = Tenant::where('uuid', $uuid)->first();
        if ($tenant) {
            $tenant->delete();

            return redirect('tenants')->with('success', 'Tenant removed!');
        } else {
            return redirect('tenants')->with('error', 'Tenant not found');
        }
    }

    public function getTenantTrashedList()
    {
        $data = Tenant::onlyTrashed()->get();

        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                if ($data->name == 'Super Admin') {
                    return '';
                }
                if (Auth::user()->can('manage_user')) {
                    return '<div class="table-actions">
                                <a href="'.url('tenant/'.$data->uuid).'" ><i class="ik ik-edit-2 f-16 mr-15 text-green"></i></a>
                                <a href="'.url('tenant/destroy/'.$data->uuid).'"><i class="ik ik-trash f-16 text-red"></i></a>
                            </div>';
                } else {
                    return '';
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
