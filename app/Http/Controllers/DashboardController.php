<?php

namespace App\Http\Controllers;
use App\Models\Company;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            'orders_count' => Order::count(),
            'employees_count' => User::whereHas('roles', function ($query) {
                return $query->where('name', '=', 'employee');
            })->count(),
            'companies_count' => Company::count(),
        ]);
    }
}
