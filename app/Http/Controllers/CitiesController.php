<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\City;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CitiesController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('access_city');
        if ($request->ajax()) {
            $search = $request->get('s');

            $cities = City::when($search, function ($querySearch, $search) {
                return $querySearch->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%');
                });
            })->get();

            return \Yajra\DataTables\DataTables::of($cities)
                ->addColumn(
                    'areas_count',
                    function (City $city) {
                        return $city->areas ? $city->areas->count() : 0;
                    })
                ->addColumn(
                    'action',
                    function (City $city) {
                        return '<button type="button" class="btn btn-primary edit-item" data-toggle="modal" data-target="#edit-city"
                                    data-id="' . $city->id . '" data-name="' . $city->name . '">
                                تعديل
                                </button>
                                <button type="button" onClick="deleteItem(' . $city->id . ')" class="btn btn-danger">
                                حذف
                                </button>';
                    })
                ->rawColumns(['name','areas_count', 'action'])->make(true);
        } else {
            return view('dashboard.shipping.cities.index');
        }
    }

    public function store(Request $request)
    {
        $this->authorize('create_city');
        $request->validate([
            'name' => 'required'
        ]);

        $city = new City();
        $city->name = $request->name;
        $city->save();

        return redirect()->route('cities.index');
    }

    public function show(Request $request, City $city)
    {
        $search = $request->q;
        $createCompany = $request->hasCompany && !$request->companyId;
        $editCompany = $request->hasCompany && $request->companyId;

        $companyId = $request->companyId;

        $areas = Area::when($search, function ($q) use ($search) {
                return $q->where('name', 'like', '%' . $search . '%');
            })

            ->when($createCompany, function ($q) {
                return $q->whereDoesntHave('company');
            })


            ->when($editCompany, function ($q) use ($companyId) {
                return $q->where(function ($q1) use ($companyId) {
                    return $q1->whereHas('company', function ($q2) use ($companyId) {
                        $q2->where('id', $companyId);
                    });
                })->orWhere(function ($q2) {
                    return $q2->whereDoesntHave('company');
                });
            })

            ->where('city_id', '=', $city->id)
            ->select(['id', 'name'])
            ->paginate(10);

        return response()->json($areas);
    }

    public function areas(Request $request, City $city)
    {
        $search = $request->q;
        $areas = Area::where('city_id', '=', $city->id)
            ->whereDoesntHave('company')
            ->when($search, function ($q) use ($search) {
                return $q->where('name', 'like', '%' . $search . '%');
            })
            ->select(['id', 'name'])
            ->paginate(10);

        return response()->json($areas);
    }


    public function update(Request $request, City $city)
    {
        $this->authorize('update_city');
        $request->validate([
            'name' => 'required'
        ]);

        $city->name = $request->name;
        $city->update();
        return redirect()->route('cities.index');
    }

    public function destroy(City $city)
    {
        $this->authorize('delete_city');
        $city->delete();
        return redirect()->route('cities.index');
    }
}
