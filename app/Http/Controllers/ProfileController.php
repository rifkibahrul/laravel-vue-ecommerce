<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function view(Request $request)
    {
        $provRes = Http::withHeaders([
            'key' => '31337e39e2bbaab3787991167b9d91e7',
        ])->get('https://api.rajaongkir.com/starter/province');

        if ($provRes->failed()) {
            return abort(404);
        }

        $provData = $provRes->json();
        $listProvince = $provData['rajaongkir']['results'];

        return view('profile.edit', [
            'user' => $request->user(),
            'listProvince' => $listProvince
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $request->user()->fill([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'province_id' => $validatedData['province_id'],
            'city_id' => $validatedData['city_id'],
        ]);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function get_cities(Request $request)
    {
        $province_id = $request->input('province_id');
        $listCity = Http::withHeaders([
            'key' => '31337e39e2bbaab3787991167b9d91e7',
        ])->get('https://api.rajaongkir.com/starter/city', [
            'province' => $province_id
        ]);

        if ($listCity->failed()) {
            return response('Failed', 404);
        }

        $data = $listCity->json();

        // dd($listCity = $data['rajaongkir']['result']);
        $listCity = $data['rajaongkir']['results'];

        return response()->json($listCity);
    }
}
