<?php

namespace App\Http\Controllers;

use App\Models\StudentInformation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeesController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('access_employee');

        if ($request->ajax()) {
            $search = $request->get('s');

            $employees = User::whereHas('roles', function ($query) {
                return $query->where('name', '=', 'employee');
            })->when($search, function ($querySearch, $search) {
                $querySearch->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%'.$search.'%');
                });
            })->get();

            return \Yajra\DataTables\DataTables::of($employees)
                ->addColumn(
                    'name',
                    function (User $user) {
                        return '<a href="/dashboard/employees/'.$user->id.'" class="btn btn-link">'.$user->name.'</a>';
                    })
                ->addColumn(
                    'orders_count',
                    function (User $user) {
                        return $user->orders ? $user->orders->count() : 0;
                    })
                ->addColumn(
                    'action',
                    function (User $user) {
                        return '<a href="/dashboard/employees/'.$user->id.'/edit" class="btn btn-primary">تعديل </a>
                                <button type="button" onClick="deleteProduct('.$user->id.')" class="btn btn-danger">
                                حذف
                                </button>';
                    })
                ->rawColumns(['name','orders_count','action'])->make(true);
        } else {
            return view('dashboard.employees.index');
        }

    }

    public function create()
    {
        $this->authorize('create_employee');
        return view('dashboard.employees.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create_employee');
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        $employee = new User();
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->password = Hash::make($request->password);
        $employee->save();

        $employee->assignRole('employee');

        return redirect()->route('employees.index');
    }

    public function show(User $employee)
    {
        $this->authorize('access_employee');
        return view('dashboard.employees.show', [
            'employee' => $employee,
            'orders_count' => $employee->orders ? $employee->orders->count() : 0
        ]);
    }

    public function edit(User $employee)
    {
        $this->authorize('update_employee');
        return view('dashboard.employees.edit', [
            'employee' => $employee
        ]);
    }

    public function update(Request $request, User $employee)
    {
        $this->authorize('update_employee');
        $request->validate([
            'name' => 'required',
        ]);

        $employee->name = $request->name;
        if($request->password) {
            $employee->password = Hash::make($request->password);
        }

        $employee->update();

        return redirect()->route('employees.index');
    }

    public function destroy(User $employee)
    {
        $this->authorize('delete_employee');
        $employee->delete();

        return redirect()->route('employees.index');
    }
}
