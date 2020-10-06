<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Clinic;
use Illuminate\Http\Request;

class ProviderManagementController extends Controller
{
    public function index()
    {
        return view('admin.providerManagement.index');
    }

    public function createFirstPage()
    {
        return view('admin.providerManagement.createProviderFirstpage');
    }

    public function storeFirstPage()
    {
        $request = request()->all();
        $validator = \Validator::make(request()->all(), [
            'clinic_name' => 'required',
            'category' => 'required',
            'description' => 'required'
        ]);


        if ($validator->fails()) {
            return redirect('provider/create/1')
                    ->withErrors($validator)
                    ->withInput();
        }

        Clinic::create($request);
        return redirect('provider/create/2');
    }
}
