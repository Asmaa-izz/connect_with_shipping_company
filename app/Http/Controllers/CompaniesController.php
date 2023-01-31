<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompaniesController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('access_company');

        if ($request->ajax()) {
            $search = $request->get('s');

            $companies = Company::when($search, function ($querySearch, $search) {
                $querySearch->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%'.$search.'%');
                });
            })->get();

            return \Yajra\DataTables\DataTables::of($companies)
                ->addColumn(
                    'name',
                    function (Company $user) {
                        return '<a href="/dashboard/companies/'.$user->id.'" class="btn btn-link">'.$user->name.'</a>';
                    })
                ->addColumn(
                    'action',
                    function (Company $user) {
                        return '<a href="/dashboard/companies/'.$user->id.'/edit" class="btn btn-primary">تعديل </a>
                                <button type="button" onClick="deleteProduct('.$user->id.')" class="btn btn-danger">
                                حذف
                                </button>';
                    })
                ->rawColumns(['name','action'])->make(true);
        } else {
            return view('dashboard.companies.index');
        }

    }

    public function create()
    {
        $this->authorize('create_company');
        return view('dashboard.companies.create', [
            'cities' => City::all()
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create_company');
        $request->validate([
            'name' => 'required',
        ]);

        $company = new Company();
        $company->name = $request->name;
        $company->save();

        $areasIds = $request->areas;
        $company->areas()->attach($areasIds);

        return redirect()->route('companies.index');
    }

    public function show(Company $company)
    {
        $this->authorize('access_company');
        return view('dashboard.companies.show', [
            'company' => $company,
        ]);
    }

    public function edit(Company $company)
    {
        $this->authorize('update_company');
        return view('dashboard.companies.edit', [
            'company' => $company,
            'cities' => City::all()
        ]);
    }

    public function update(Request $request, Company $company)
    {
        $this->authorize('update_company');

        $request->validate([
            'name' => 'required',
        ]);

        $company->name = $request->name;
        $company->update();

        $company->areas()->detach();
        $areasIds = $request->areas;
        $company->areas()->attach($areasIds);



        return redirect()->route('companies.index');
    }

    public function destroy(Company $company)
    {
        $this->authorize('delete_company');
        $company->delete();

        return redirect()->route('companies.index');
    }
}
