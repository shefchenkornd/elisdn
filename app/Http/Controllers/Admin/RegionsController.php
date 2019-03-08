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

    public function index(Request $request)
    {

        $query = Region::orderByDesc('id');

        if (!empty($value = $request->get('id'))) {
            $query->where('id', $value);
        }

        if (!empty($value = $request->get('name'))) {
            $query->where('name', 'like', '%' . $value . '%');
        }

        if (!empty($value = $request->get('email'))) {
            $query->where('email', 'like', '%' . $value . '%');
        }

        if (!empty($value = $request->get('status'))) {
            $query->where('status', $value);
        }

        if (!empty($value = $request->get('role'))) {
            $query->where('role', $value);
        }

        $regions = $query->paginate(20);

        return view('admin.regions.index', compact('regions'));
    }


    public function create()
    {
        return view('admin.regions.create');
    }


    public function store(CreateRequest $request)
    {
        $region = Region::create( $request->only(['name', 'email']) );

        redirect()->route('admin.regions.show', $region);
    }


    public function show(Region $region)
    {
        return view('admin.regions.show', compact('region'));
    }


    public function edit(Region $region)
    {
        return view('admin.regions.edit', compact('region'));
    }


    public function update(UpdateRequest $request, Region $region)
    {
        $region->update($request->only(['name', 'email', 'status ']));

        return view('admin.regions.show', compact('region'));
    }


    public function destroy(Region $region)
    {
        $region->delete();

        return redirect()->route('admin.regions.index');
    }

    public function verify(Region $region)
    {
        $this->service->verify($region->id);

        return redirect()->route('admin.regions.show', $region);
    }
}
