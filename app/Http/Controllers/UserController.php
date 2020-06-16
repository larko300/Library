<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified','role:admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $request->validate([
            'sort' => 'in:email_asc,id_desc,name_asc,0',
            'filter' => 'in:verified,not_verified,0',
            'search' => 'string|nullable'
        ]);
        $search = false;
        if ($request->has('search') && $request['search'] != '') {
            $search = true;
        }
        $sortRules = [];
        if ($request->has('sort') && $request['sort'] !== '0') {
            $result = explode('_', $request['sort']);
            $sortRules['sort'] = $result[0];
            $sortRules['option'] = $result[1];
        }
        $users = User::query()
            ->when(count($sortRules) > 0, function ($query) use ($sortRules) {
                $query->orderBy($sortRules['sort'], $sortRules['option']);
            })
            ->when($request['filter'] === 'verified', function ($query) {
                $query->whereNotNull('email_verified_at');
            })
            ->when($request['filter'] === 'not_verified', function ($query) {
                $query->whereNull('email_verified_at');
            })
            ->when($search, function ($query) use ($request) {
                $query->where('name', 'like', "%{$request['search']}%")
                    ->orWhere('email', 'like', "%{$request['search']}%");
            })
            ->paginate(10);
        $users->appends($request->all())->links();
        return view('user/index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('user/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'])
        ]);
        event(new Registered($user));
        return redirect()->route('user.index')->with(['success' => 'User created!']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('user/edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'required|min:6',
            'new_password' => 'nullable|confirmed|min:6'
        ]);
        if (Hash::check($request['password'], $user->password)) {
            $user->name = $request['name'];
            $user->email = $request['email'];
            $request['new_password'] ? $user->password = Hash::make($request['new_password']) : '';
            $user->save();
            return redirect()->route('user.index')->with(['success' => 'User updated!']);
        }
        return back()->with(['error' => 'Password does not match']);
    }
}
