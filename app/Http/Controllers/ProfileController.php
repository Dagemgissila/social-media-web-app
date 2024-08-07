<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\UserResource;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function index(User $user){
        return Inertia::render('Profile/View', [
            'mustVerifyEmail' => $user instanceof MustVerifyEmail,
            'status' => session('status'),
            "success"=>session('success'),
            'user' => new UserResource($user),

        ]);
    }

    public function updateImages (Request $request){
       $data= $request->validate([
          'cover'=>['nullable','image'],
          'avatar'=>['nullable','image']
        ]);

        $user=$request->user();

        $avatar=$data["avatar"] ?? null ;
        $cover=$data["cover"] ?? null ;

        if($cover){

            if($user->cover_path){
                Storage::disk("public")->delete($user->cover_path);
            }

            $path=$cover->store("user-".$user->id,"public");
            $user->update(["cover_path"=>$path]);
            $success='your cover image updated';
        }


        if($avatar){

            if($user->avatar_path){
                Storage::disk("public")->delete($user->avatar_path);
            }

            $path=$avatar->store("avatar-".$user->id,"public");
            $user->update(["avatar_path"=>$path]);
            $success='your avatar image updated';

        }
     
        return back()->with("success",$success);


    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return to_route("profile",$request->user())->with("success","Your Profile Detail updated");


    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
