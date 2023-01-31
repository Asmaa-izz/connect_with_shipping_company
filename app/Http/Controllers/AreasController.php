<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Area;
use App\Models\Neighborhood;
use Illuminate\Http\Request;

class AreasController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('access_area');
        if ($request->ajax()) {
            $search = $request->get('s');

            $areas = Area::with('city')->whereHas('city')
                ->when($search, function ($querySearch, $search) {
                    return $querySearch->where(function ($q) use ($search) {
                        $q->where('name', 'LIKE', '%' . $search . '%');
                    });
                })->get();

            return \Yajra\DataTables\DataTables::of($areas)
                ->addColumn('city', function (Area $area) {
                    return $area->city->name;
                })
                ->addColumn('company', function (Area $area) {
                    if ($area->company->first()) {
                        $company = $area->company->first();
                        return '<a href="/dashboard/companies/' . $company->id . '" class="btn btn-link">' . $company->name . '</a>';
                    } else {
                        return 'لا يوجد';
                    }
                })
                ->addColumn(
                    'action',
                    function (Area $area) {
                        return '<button type="button" class="btn btn-primary edit-item" data-toggle="modal" data-target="#edit-area"
                                    data-id="' . $area->id . '" data-name="' . $area->name . '" data-city="' . $area->city->id . '">
                                تعديل
                                </button>
                                <button type="button" onClick="deleteItem(' . $area->id . ')" class="btn btn-danger">
                                حذف
                                </button>';
                    })
                ->rawColumns(['name', 'city', 'company', 'action'])->make(true);
        } else {
            return view('dashboard.shipping.areas.index', [
                'cities' => City::all()
            ]);
        }
    }

    public function store(Request $request)
    {
        $this->authorize('create_area');
        $request->validate([
            'name' => 'required'
        ]);

        $area = new Area();
        $area->name = $request->name;
        $area->city_id = $request->city;
        $area->save();

        return redirect()->route('areas.index');
    }

    public function show(Request $request, Area $area)
    {
        $search = $request->q;
        $neighborhoods = Neighborhood::where('area_id', '=', $area->id)
            ->when($search, function ($q) use ($search) {
                return $q->where('name', 'like', '%' . $search . '%');
            })
            ->select(['id', 'name'])
            ->paginate(10);

        return response()->json($neighborhoods);
    }

    public function update(Request $request, Area $area)
    {
        $this->authorize('update_area');
        $request->validate([
            'name' => 'required'
        ]);

        $area->name = $request->name;
        $area->city_id = $request->city;
        $area->update();
        return redirect()->route('areas.index');
    }

    public function destroy(Area $area)
    {
        $this->authorize('delete_area');
        $area->delete();
        return redirect()->route('areas.index');
    }
}
