<?php

namespace App\Http\Controllers\Admin;

use App\Entity\User;
use App\Http\Requests\Admin\Users\UpdateRequest;
use App\Http\Requests\Admin\Users\CreateRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\UseCases\Auth\RegisterService;
use Faker;

class UsersController extends Controller
{

    private $service;

    public function __construct(RegisterService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(20);

        return view('admin.users.index', compact('users'));
    }


    public function create()
    {
        return view('admin.users.create');
    }


    public function store(CreateRequest $request)
    {
        $user = User::create($request->only(['name', 'email']) + [
            'password' => bcrypt(Str::random()),
            'status' => User::STATUS_ACTIVE
        ]);

        redirect()->route('admin.users.show', $user);
    }


    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }


    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }


    public function update(UpdateRequest $request, User $user)
    {
        $user->update($request->only(['name', 'email', 'status ']));

        return view('admin.users.show', compact('user'));
    }


    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index');
    }

    public function verify(User $user)
    {
        $this->service->verify($user->id);

        return redirect()->route('admin.users.show', $user);
    }
}
