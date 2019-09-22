<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\UseCases\Auth\RegisterService;
use Faker;

class RegionsController extends Controller
{

    private $service;

    public function __construct(RegisterService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $regions = Region::where('parent_id', null)->orderBy('name')->get();

        return view('admin.regions.index', compact('regions'));
    }

    public function create(Request $request)
    {
        $parent = null;

        if ($request->get('parent')) {
            $parent = Region::findOfFail($request->get('parent'));
        }

        return view('admin.regions.create', compact('parent'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
           'name' => 'required|string|max:255|unique:regions,name,NULL,id,parent_id,' . ($request['name'] ?: 'NULL' ),
           'slug' => 'required|string|max:255|unique:regions,slug,NULL,id,parent_id,' . ($request['slug'] ?: 'NULL' ),
           'parent' => 'nullable|exists:regions,id',
        ]);

        $region = Region::create([
            'name' => $request['name'],
            'slug' => $request['slug'],
            'parent_id' => $request['parent'],
        ]);

        return redirect()->route('admin.regions.show', $region);
    }


    public function show(Region $region)
    {
        $regions = Region::where('parent_id', $region->id)->orderBy('name')->get();

        return view('admin.regions.show', compact('region', 'regions'));
    }


    public function edit(Region $region)
    {
        return view('admin.regions.edit', compact('region'));
    }


    public function update(Request $request, Region $region)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255|unique:regions,name,' . $region->id . ',id,parent_id,' . $region->parent_id ?? null,
            'slug' => 'required|string|max:255|unique:regions,slug,' . $region->id . ',id,parent_id,' . $region->parent_id ?? null,
        ]);

        $region->update([
            'name' => $request['name'],
            'slug' => $request['slug'],
            'parent_id' => $request['parent'],
        ]);

        return redirect()->route('admin.regions.show', $region);
    }


    public function destroy(Region $region)
    {
        $region->delete();

        return redirect()->route('admin.regions.index');
    }
}
