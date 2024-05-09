<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileUpdateRequest;
use Exception;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit($user)
    {
        if (Auth::user()->hasRole('Super Admin')) {
            $users = User::find($user);
            return view('auth.profile', [
                'user' => $users
            ]);
        }
    }

    public function update(ProfileUpdateRequest $request)
    {
        if (Auth::user()->hasRole('Super Admin')) {
            try {
                $user = User::find($request->id);
                if ($user && $request->password) {
                    $user->update(['password' => Hash::make($request->password)]);
                }
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                ]);
                return redirect()->back()->with('success', 'Profile updated.');
            } catch (\Throwable $th) {
                throw new Exception("Erreur lors de la mise à jour du mot de passe");
            }
        }
    }
}
