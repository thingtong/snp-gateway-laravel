<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\CustomerTaxAddress;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'phone_number' => 'required',
            'name' => 'sometimes|nullable|string',
            'first_name' => 'sometimes|nullable|string',
            'last_name' => 'sometimes|nullable|string',
            'password' => 'required',
            'title' => 'sometimes|nullable|string',
            'date_of_birth' => 'sometimes|nullable|string',
            'gender' => 'sometimes|nullable|string',
            'accepts_terms_and_conditions' => 'sometimes|nullable|boolean',
            'accepts_marketing_notifications' => 'sometimes|nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            $data['password'] = Hash::make($data['password']);
            $customer = Customer::create($data);
            DB::commit();

            return $this->ok($customer, 'Customer created successfully');
        } catch (\Exception $e) {
            return $this->rollBack($e, 'Failed to create customer');
        }
    }

    public function updateMe(Request $request)
    {
        $data = $request->validate([
            'email' => 'sometimes|email',
            'phone_number' => 'sometimes|nullable|string',
            'name' => 'sometimes|nullable|string',
            'first_name' => 'sometimes|nullable|string',
            'last_name' => 'sometimes|nullable|string',
            'password' => 'sometimes|nullable|string',
            'title' => 'sometimes|nullable|string',
            'date_of_birth' => 'sometimes|nullable|string',
            'gender' => 'sometimes|nullable|string',
            'accepts_terms_and_conditions' => 'sometimes|nullable|boolean',
            'accepts_marketing_notifications' => 'sometimes|nullable|boolean',
        ]);

        $user = Auth::user();
        $customer = Customer::findOrFail($user->id);

        try {
            DB::beginTransaction();
            if (! empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            $customer->forceFill($data);

            if (! $customer->save()) {
                throw new \Exception('Fail to update customer');
            }
            DB::commit();

            return $this->ok($customer, 'Customer updated successfully');
        } catch (\Exception $e) {
            return $this->rollBack($e, 'Failed to create customer');
        }
    }

    public function getMe(Request $request)
    {
        $user = Auth::user();
        $customer = Customer::with(['address'])->findOrFail($user->id);

        return $this->ok($customer);
    }

    public function getAddressMe(Request $request)
    {
        $user = Auth::user();
        $address = CustomerAddress::where('customer_id', $user->id)->get();

        return $this->ok($address);
    }

    public function getTaxAddress($brand, $customer)
    {
        $address = CustomerTaxAddress::where('customer_id', $customer)->get();

        return $this->ok($address);
    }

    public function createTaxAddress(Request $request, $brand, $customer)
    {
        $data = $request->validate([
            'customer_id' => 'sometimes|nullable|numeric',
            'tax_id' => 'required|string',
            'company_name' => 'required|string',
            'company_address' => 'sometimes|nullable|string',
            'company_district' => 'sometimes|nullable|string',
            'company_area' => 'sometimes|nullable|string',
            'company_province' => 'sometimes|nullable|string',
            'company_postcode' => 'sometimes|nullable|string',
            'company_phone' => 'sometimes|nullable|string',
            'is_headoffice' => 'sometimes|nullable|boolean',
            'branch_no' => 'sometimes|nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $data['customer_id'] = $customer;
            $taxAddress = CustomerTaxAddress::create($data);
            DB::commit();

            return $this->ok($taxAddress, 'Customer tax address created successfully');
        } catch (\Exception $e) {
            return $this->rollBack($e, 'Failed to create customer tax address');
        }
    }
}
