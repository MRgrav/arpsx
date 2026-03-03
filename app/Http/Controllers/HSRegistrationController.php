<?php

namespace App\Http\Controllers;

use App\Models\HSRegistration;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HSRegistrationController extends Controller
{
    public function index()
    {
        return inertia::render('HSRegistration/index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'last_school_name' => 'required|string|max:255',
            'pre_board_percentage' => 'required|string|max:255',
            'stream' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'reason_of_interest' => 'required|string|max:255',
        ]);

        $hsRegistration = HSRegistration::create($validated);

        return redirect()
            ->back()
            ->with('data', [
                'message' => 'Registration for admission successful!',
                'id' => $hsRegistration->id,
            ]);

        // return redirect()->route('school-admin.hs-registration.show', $hsRegistration->id);
    }

    public function schoolAdminIndex()
    {
        $hsRegistrations = HSRegistration::all();

        return inertia::render('school-admin/HSRegistration/Index', [
            'hsRegistrations' => $hsRegistrations,
        ]);
    }

    public function schoolAdminShow(string $id)
    {
        $hsRegistration = HSRegistration::findOrFail($id);
        return inertia::render('school-admin/HSRegistration/Show', [
            'hsRegistration' => $hsRegistration,
        ]);
    }
}
