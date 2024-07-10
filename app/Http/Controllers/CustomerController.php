<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    //
    public function all_customers()
    {
        $customers = Customer::orderBy('id', 'DESC')->get();
        return response()->json([
            'customers' => $customers
        ], 200);
    }

    public function search_customer(Request $request)
    {
        $search = $request->get('s');
        if ($search != null){
            $customers = Customer::where('full_name', 'LIKE', "%$search%")->get();
            return response()->json([
                'customers' => $customers
            ], 200);
        }else{
            return $this->all_customers();
        }
    }

    public function create_customer()
    {
        $formData = [
            'fl_name' => null,
            'full_name' => null,
            'phone' => null,
            'address' => null,
            'inn' => null,
            'kpp' => null,
            'ogrn' => null
        ];
        return response()->json($formData);
    }

    public function add_customer(Request $request)
    {
        $customerdata['fl_name'] = $request->input("fl_name");
        $customerdata['full_name'] = $request->input("full_name");
        $customerdata['phone'] = $request->input("phone");
        $customerdata['address'] = $request->input("address");
        $customerdata['inn'] = $request->input("inn");
        $customerdata['kpp'] = $request->input("kpp");
        $customerdata['ogrn'] = $request->input("ogrn");
        
        $customer = Customer::create($customerdata);

    }
    
    public function show_customer($id) {
        $customer = Customer::find($id);
        return response()->json([
            'customer' => $customer
        ], 200);
    }

    public function edit_customer($id) {

        $customer = Customer::find($id);
        return response()->json([
            'customer' => $customer
        ], 200);
    }

    public function update_customer(Request $request, $id) {
        $customer = Customer::where('id', $id)->first();

        $customer->fl_name = $request->fl_name;
        $customer->full_name = $request->full_name;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->inn = $request->inn;
        $customer->kpp = $request->kpp;
        $customer->ogrn = $request->ogrn;

        $customer->update($request->all());
    }

    public function delete_customer($id) {
        $customer = Customer::findOrFail($id);
        $customer->delete();
    }

}
