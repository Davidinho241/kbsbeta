<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Auth;
use DataTables;

class ServiceController extends Controller
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
        return view('tenant.tenant-settings');
    }

    public function save($data)
    {
        return Service::create($data);
    }

    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required | string',
                'type' => 'required | string ',
                'tenant_id' => 'required ',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->with('error', $validator->messages()->first());
            }

            $user = $request->user();
            $tenant = Tenant::find($request->tenant_id);

            // store user information
            $data = $request->only((new Service())->getFillable());
            $data['uuid'] = Str::uuid()->toString();
            $data['created_by'] = $user->name;
            $service = $this->save($data);

            if ($service) {
                return (new TenantController())->settings($tenant->uuid);
            } else {
                return redirect('tenants')->with('error', 'Failed to create new service! Try again.');
            }
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->with('error', $bug);
        }
    }


    public function getServiceList(Request $request, $tenant_uuid)
    {
        $tenant = Tenant::where('uuid', $tenant_uuid)->first();
        $data = Service::orderBy('name', 'ASC')->where('tenant_id', $tenant->id)->get();

        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                if ($data->name == 'Super Admin') {
                    return '';
                }
                if (Auth::user()->can('manage_user')) {
                    return '<div class="table-actions">
                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Setting">
                                    <a href="'.url('tenant/service/'.$data->uuid).'" ><i class="ik ik-settings f-16 mr-15 text-blue"></i></a>
                                </span>
                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Edit">
                                    <a href="#" data-toggle="modal" data-target="#editServiceModal" data-id="'.$data->id.'" data-name="'.$data->name.'" data-type="'.$data->type.'" data-event="'.$data->event.'"><i class="ik ik-edit-2 f-16 mr-15 text-green"></i></a>
                                </span>
                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Delete">
                                    <a href="'.url('tenant/service/delete/'.$data->uuid).'"><i class="ik ik-trash-2 f-16 text-yellow"></i></a>
                                </span>
                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Remove">
                                    <a href="'.url('tenant/service/destroy/'.$data->uuid).'"><i class="ik ik-trash f-16 text-red"></i></a>
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
        $service = Service::withTrashed()->where('uuid', $uuid)->first();
        $tenant = Tenant::find($service->tenant_id);
        if ($service) {
            $service->forceDelete();
            return (new TenantController())->settings($tenant->uuid);
            //return redirect('tenants')->with('success', 'Tenant removed!');
        } else {
            return redirect("tenant/settings/".$tenant->uuid)->with('error', 'Service not found');
        }
    }

    public function delete($uuid)
    {
        $service = Service::where('uuid', $uuid)->first();
        $tenant = Tenant::find($service->tenant_id);
        if ($service) {
            $service->delete();
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
            'tenant_id' => 'required',
            'name' => 'required | string',
            'type' => 'required | string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }

        try {
            $service = Service::find($request->id);

            $data = $request->only((new Service())->getFillable());

            $update = $service->update($data);

            if ($update) {
                return redirect()->back()->with('success', 'Service information updated successfully !');
            } else {
                return redirect('tenants')->with('error', 'Failed to update the service! Try again.');
            }
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->with('error', $bug);
        }
    }

}
