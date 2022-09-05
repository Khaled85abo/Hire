<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    // Show All Profiles
    public function index()
    {
        return View('profiles.index', [
            'profiles' => Profile::latest()->filter(request(['tag', 'search']))->paginate(4)
        ]);
    }

    // Show Single Profile
    // that we send to the View comes from.
    public function show(Profile $profile)
    {
        // dd($profile);
        return View('profiles.show', [
            'profile' => $profile
        ]);
    }

    // Show Create Form
    public function create()
    {
        return View('profiles.create');
    }


    // Store profile data
    public function store(Request $request)
    {
        // dd($request->all());

        // $table->string('picture')->nullable();
        // $table->string('tags');
        // $table->string('location');
        // $table->string('email');
        // $table->string('website');
        // $table->longText('description');
        // $table->string('experience_years');
        // $table->string('current_job');
        // $table->string('github')->nullable();
        // $table->string('linkedIn')->nullable();
        $formFields = $request->validate([
            'location' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if ($request->hasFile('picture')) {
            $formFields['picture'] = $request->file('picture')->store('profiles', 'public');
        }

        $formFields['user_id'] = auth()->id();
        Profile::create($formFields);

        return redirect('/')->with('message', 'Profile created successfully!');
    }

    // Manage Profile
    public function manage()
    {
        // dd(auth()->user()->profile()->get());
        $profile = Profile::find(auth()->user()->profile()->get());
        if (count($profile) == 0) return View('profiles.create');
        return view('profiles.manage', ['profile' => auth()->user()->profiles()->get()]);
    }

    // Delete Profile
    public function destroy(Profile $profile)
    {
        if (auth()->id() != $profile->user_id) {
            abort(403, 'Unauthorized Action');
        }
        $profile->delete();
        return redirect('/')->with('message', 'Your profile deleted successfully!');
    }

    // Show Edit Form
    // ?? Question the route is /listings/{listing}/edit' which gives us just an id of the lisitng, so where $listing array
    // that we send to the View comes from.
    public function edit(Profile $profile)
    {
        return View('profiles.edit', ['profile' => $profile]);
    }

    // Update Profile
    public function update(Request $request, Profile $profile)
    {
        if (auth()->id() != $profile->user_id) {
            abort(403, 'Unauthorized Action');
        }
        $formFields = $request->validate([
            'location' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);
        if ($request->hasFile('picture')) {
            $formFields['picture'] = $request->file('picture')->store('profiles', 'public');
        }
        $profile->update($formFields);
        return back()->with('message', 'Profile updated successfully!');
    }
}
