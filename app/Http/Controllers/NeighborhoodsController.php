<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Neighborhood;
use App\Models\Area;
use Illuminate\Http\Request;

class NeighborhoodsController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('access_neighborhood');
        if ($request->ajax()) {
            $search = $request->get('s');

            $neighborhoods = Neighborhood::with('area')->whereHas('area')->when($search, function ($querySearch, $search) {
                return $querySearch->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%');
                });
            })->get();

            return \Yajra\DataTables\DataTables::of($neighborhoods)
                ->addColumn('area', function (Neighborhood $neighborhood) {
                    return $neighborhood->area->name;
                })
                ->addColumn('city', function (Neighborhood $neighborhood) {
                    return $neighborhood->area->city->name;
                })
                ->addColumn(
                    'action',
                    function (Neighborhood $neighborhood) {
                        return '<button type="button" class="btn btn-primary edit-item" data-toggle="modal" data-target="#edit-neighborhood"
                                    data-id="' . $neighborhood->id . '"
                                    data-name="' . $neighborhood->name . '"
                                    data-city="'.$neighborhood->area->city->id.'"
                                    data-area="'.$neighborhood->area->id.'">
                                تعديل
                                </button>
                                <button type="button" onClick="deleteItem(' . $neighborhood->id . ')" class="btn btn-danger">
                                حذف
                                </button>';
                    })
                ->rawColumns(['name', 'area','city','action'])->make(true);
        } else {
            return view('dashboard.shipping.neighborhoods.index', [
                'cities' => City::all()
            ]);
        }
    }

    public function store(Request $request)
    {
        $this->authorize('create_neighborhood');
        $request->validate([
            'name' => 'required',
            'area' => 'required'
        ]);

        $neighborhood = new Neighborhood();
        $neighborhood->name = $request->name;
        $neighborhood->area_id = $request->area;
        $neighborhood->save();

        return redirect()->route('neighborhoods.index');
    }

    public function show(Neighborhood $neighborhood)
    {
        return $neighborhood;
    }

    public function update(Request $request, Neighborhood $neighborhood)
    {
        $this->authorize('update_neighborhood');
        $request->validate([
            'name_edit' => 'required',
            'area_edit' => 'required'
        ]);

        $neighborhood->name = $request->name;
        $neighborhood->area_id = $request->area;
        $neighborhood->update();
        return redirect()->route('neighborhoods.index');
    }

    public function destroy(Neighborhood $neighborhood)
    {
        $this->authorize('delete_neighborhood');
        $neighborhood->delete();
        return redirect()->route('neighborhoods.index');
    }
}
