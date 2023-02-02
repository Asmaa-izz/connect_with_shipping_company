<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('access_order');

        if ($request->ajax()) {
            $search = $request->get('s');

            $orders = Order::with('employee')
                ->when($search, function ($querySearch, $search) {
                    return $querySearch
                        ->Where(function ($q) use ($search) {
                            $q->where('customer_name', 'LIKE', '%' . $search . '%')
                                ->where('number', 'LIKE', '%' . $search . '%');
                        })->orWhere(function ($q) use ($search) {
                            $q->whereHas('employee', function ($q2) use ($search) {
                                return $q2->where('name', 'LIKE', '%' . $search . '%');
                            });
                        });
                })->get();

            return \Yajra\DataTables\DataTables::of($orders)
                ->addColumn(
                    'number',
                    function (Order $order) {
                        return '<a href="/dashboard/orders/' . $order->id . '" class="btn btn-link">' . $order->number . '</a>';
                    })
                ->addColumn(
                    'employee',
                    function (Order $order) {
                        $employee = $order->employee;
                        return '<a href="/dashboard/employees/' . $employee->id . '" class="btn btn-link">' . $employee->name . '</a>';
                    })
                ->addColumn(
                    'status',
                    function (Order $order) {
                        return $order->status;
                    })
                ->addColumn(
                    'action',
                    function (Order $order) {
                        return '<a href="/dashboard/orders/' . $order->id . '/edit" class="btn btn-primary">تعديل </a>
                                <button type="button" onClick="deleteProduct(' . $order->id . ')" class="btn btn-danger">
                                حذف
                                </button>';
                    })
                ->rawColumns(['number', 'customer_name', 'employee', 'status', 'action'])->make(true);
        } else {
            return view('dashboard.orders.index');
        }

    }

    public function create()
    {
        $this->authorize('create_order');
        return view('dashboard.orders.create', [
            'number' => $this->generateBarcodeNumber(),
            'cities' => City::all(),
        ]);
    }

    function generateBarcodeNumber() {
        $number = mt_rand(1000000000, 9999999999);
        if (Order::where('number', '=', $number)->exists()) {
            return $this->generateBarcodeNumber();
        }
        return $number;
    }


    public function store(Request $request)
    {
        $this->authorize('create_order');
        $request->validate([
            'number' => 'required',
            'customer_name' => 'required',
            'customer_phone' => 'required',
            'city_id' => 'required',
            'area_id' => 'required',
            'neighborhood_id' => 'required',
            'amount' => 'required',
            'product_details' => 'required',
        ]);

        $order = new Order();
        $order->employee_id = Auth::id();
        $order->status ='جديد';
        $order->number = $request->number;
        $order->customer_name = $request->customer_name;
        $order->customer_phone = $request->customer_phone;
        $order->customer_phone_other = $request->customer_phone_other;
        $order->city_id = $request->city_id;
        $order->area_id = $request->area_id;
        $order->neighborhood_id = $request->neighborhood_id;
        $order->amount = $request->amount;
        $order->product_details = $request->product_details;
        $order->save();

        return redirect()->route('orders.index');
    }

    public function show(Order $order)
    {

        $this->authorize('access_order');
        return view('dashboard.orders.show', [
            'order' => $order,

        ]);
    }

    public function edit(Order $order)
    {
        $this->authorize('update_order');
        return view('dashboard.orders.edit', [
            'order' => $order->load('area', 'neighborhood'),
            'cities' => City::all(),
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $this->authorize('update_order');
        $request->validate([
            'number' => 'required',
            'customer_name' => 'required',
            'customer_phone' => 'required',
            'city_id' => 'required',
            'area_id' => 'required',
            'neighborhood_id' => 'required',
            'amount' => 'required',
            'product_details' => 'required',
        ]);

        $order->number = $request->number;
        $order->customer_name = $request->customer_name;
        $order->customer_phone = $request->customer_phone;
        $order->customer_phone_other = $request->customer_phone_other;
        $order->city_id = $request->city_id;
        $order->area_id = $request->area_id;
        $order->neighborhood_id = $request->neighborhood_id;
        $order->amount = $request->amount;
        $order->product_details = $request->product_details;
        $order->save();

        return redirect()->route('orders.index');
    }

    public function destroy(Order $order)
    {
        $this->authorize('delete_order');
        $order->delete();

        return redirect()->route('orders.index');
    }
}
