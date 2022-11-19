<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        return Profile::query()
            ->where('id', '=', $request->input('id'))
            ->first();
    }

    public function store(ProfileRequest $request)
    {
        $newProfile = new Profile();
        $newProfile->fill($request->all());

        if ($newProfile->save()) {
            return response()->json(['id' => $newProfile->id], 201);
        }

        return response()->json(['error' => 'Unable to create profile'], 400);
    }

    public function update(ProfileRequest $request)
    {
        $profile = Profile::query()->where('id', '=', $request->input('id'))->first();

        if (!$profile) {
            return response()->json(['error' => 'Invalid profile'], 304);
        }

        $profile->fill($request->all())->save();

        return response()->json($profile);
    }
}
