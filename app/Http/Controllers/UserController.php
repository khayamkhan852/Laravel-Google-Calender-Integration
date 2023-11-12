<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $users = User::with('user:id,name', 'media')->latest('id')->get();
        return view('settings.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('settings.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserStoreRequest $request
     * @return RedirectResponse
     */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        $output = false;
        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'user_id' => auth()->id(),
                'password' => Hash::make($request->input('password')),
            ]);

            if ($request->hasFile('user_avatar')) {
                $user->addMediaFromRequest('user_avatar')->toMediaCollection('users');
            }

            DB::commit();
            $output = true;
        } catch (\Exception|\error $error) {
            DB::rollBack();
        }

        if ($output) {
            alert()->success('success', 'User added!');
            return redirect()->route('settings.users.index');
        }
        alert()->error('failed', 'Something Went Wrong! Try again');
        return redirect()->route('settings.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return View
     */
    public function show(User $user): View
    {
        $user->load('user:id,name');
        return view('settings.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        return view('settings.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($user->id)
            ],
            'user_avatar' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
        ]);
        $output = false;
        try {
            DB::beginTransaction();

            $user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
            ]);

            if ($request->hasFile('user_avatar')) {
                $user->clearMediaCollection('users');
                $user->addMediaFromRequest('user_avatar')->toMediaCollection('users');
            }

            DB::commit();
            $output = true;
        } catch (\Exception|\error $error) {
            DB::rollBack();
        }

        if ($output) {
            alert()->success('success', 'User Updated!');
            return redirect()->route('settings.users.index');
        }
        alert()->error('failed', 'Something Went Wrong! Try again');
        return redirect()->route('settings.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        $output = false;
        try {
            DB::beginTransaction();
            $user->delete();
            DB::commit();
            $output = true;
        } catch (\Exception|\error $error) {
            DB::rollBack();
        }

        if ($output) {
            alert()->success('success', 'User deleted!');
            return redirect()->route('settings.users.index');
        }
        alert()->error('failed', 'Something Went Wrong! Try again');
        return redirect()->route('settings.users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return View
     */
    public function resetPassword(User $user): View
    {
        return view('settings.users.reset-password', compact('user'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function postResetPassword(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()]
        ]);
        if (!Hash::check($request->input('current_password'), $user->password)) {
            alert()->warning('failed', 'Current Password did not matched!!');
            return redirect()->back();
        }
        $output = false;
        try {
            DB::beginTransaction();
            $user->update([
                'password' => Hash::make($request->input('password'))
            ]);
            DB::commit();
            $output = true;
        } catch (\Exception|\error $error) {
            DB::rollBack();
        }

        if ($output) {
            alert()->success('success', 'User password updated');
            return redirect()->route('settings.users.index');
        }
        alert()->error('failed', 'Something Went Wrong! Try again');
        return redirect()->route('settings.users.index');
    }
}
