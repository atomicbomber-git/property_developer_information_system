<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index()
    {
        if (request()->ajax())
            return User::select('id', 'name')->get();

        $users = User::query()
            ->select('id', 'name', 'privilege', 'username')
            ->withCount(['invoices_received'])
            ->get();

        return view('user.index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        return view('user.create');
    }

    public function processCreate()
    {
        $data = $this->validate(request(), [
            'name' => 'required|string|unique:users',
            'username' => 'required|alpha_dash',
            'privilege' => ['required', Rule::in(User::privileges)],
            'password' => 'required|string|confirmed'
        ]);

        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return redirect()
            ->route('user.index')
            ->with('message.success', __('messages.create.success'));
    }

    public function update(User $user)
    {
        return view('user.update', [
            'user' => $user
        ]);
    }

    public function processUpdate(User $user)
    {
        $validator = Validator::make(request()->all(), [
            'name' => ['required', 'string', Rule::unique('users')->ignore($user->id)],
            'username' => 'required|alpha_dash',
            'privilege' => ['required', Rule::in(User::privileges)],
        ]);

        $validator->sometimes('password', 'string|confirmed', function ($input) {
            return filled($input->password);
        });

        $data = $validator->validate();
        if (isset($data['password']))
            bcrypt($data['password']);
        
        $user->update($data);
        
        return redirect()
            ->route('user.index')
            ->with('message.success', __('messages.create.success'));
    }

    public function delete(User $user)
    {
        if ($user->invoices_created()->count() > 0 || $user->invoices_received()->count() > 0)
            abort(409);

        $user->delete();
        
        return back()
            ->with('message.success', __('messages.delete.success'));
    }
}
