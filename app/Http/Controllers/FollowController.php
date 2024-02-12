<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    //
    public function store(User $user): RedirectResponse
    {
        Auth::user()->followings()->attach($user->id);
        return back();
    }

    public function destroy(User $user): RedirectResponse
    {
        /* detach 는 떼어내라는 뜻 */
        Auth::user()->followings()->detach($user->id);

        return back();
    }
}
