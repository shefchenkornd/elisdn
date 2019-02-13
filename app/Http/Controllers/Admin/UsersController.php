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

    public function index(Request $request)
    {

        $query = User::orderByDesc('id');

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

        $users = $query->paginate(20);

        $statuses = [
            User::STATUS_WAIT => 'Waiting',
            User::STATUS_ACTIVE => 'Active',
        ];

        $roles = [
            User::ROLE_USER => 'User',
            User::ROLE_ADMIN => 'Admin',
        ];

        return view('admin.users.index', compact('users', 'statuses', 'roles'));
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
