<?php

namespace App\Http\Controllers;

use App\Models\HSRegistration;
use App\Services\AppwriteStorageService;
use Barryvdh\DomPDF\Facade\Pdf;
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
            'contact_number' => 'required|integer|digits:10',
            'email' => 'nullable|email|max:255',
            'last_school' => 'required|string|max:255',
            'pre_borad_percentage' => 'nullable|integer',
            'stream' => 'nullable|string|max:255',
            'pen_number' => 'nullable|string',
            'apaar_id' => 'nullable|string',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'parents_contact_number' => 'required|integer|digits:10',
            'whatsapp' => 'nullable|integer|digits:10',
            'address' => 'required|string|max:255',
            'reason_of_interest' => 'nullable|string|max:255',
            'reference_number' => 'required|string',
            // below 1mb
            'payment_screenshot' => "required|file|mimes:pdf,jpg,jpeg,png|max:1024",
        ]);

        $field = 'payment_screenshot';
        $storageService = app(AppwriteStorageService::class);
        $upload = $storageService->upload($request->file($field), env('APPWRITE_BUCKET_ID'));
        // change: file -> file path
        $validated[$field] = $upload['url'];

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
        $hsRegistrations = HSRegistration::orderBy('id', 'desc')->get();

        return inertia::render('school-admin/HSRegistration/Index', [
            'hsRegistrations' => $hsRegistrations,
        ]);
    }

    /**
     * Download all HS registrations as CSV.
     */
    public function downloadCsv()
    {
        $registrations = HSRegistration::latest()->get();
        $filename = "hs-registrations-" . date('Y-m-d') . ".csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = [
            'ID',
            'Name',
            'DOB',
            'Gender',
            'Phone',
            'Email',
            'Last School',
            'Percentage',
            'Stream',
            'Father Name',
            'Mother Name',
            'Parents Phone',
            'WhatsApp',
            'Address',
            'Created At'
        ];

        $callback = function () use ($registrations, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($registrations as $registration) {
                fputcsv($file, [
                    $registration->id,
                    $registration->name,
                    $registration->dob,
                    $registration->gender,
                    $registration->contact_number,
                    $registration->email,
                    $registration->last_school,
                    $registration->pre_borad_percentage,
                    $registration->stream,
                    $registration->father_name,
                    $registration->mother_name,
                    $registration->parents_contact_number,
                    $registration->whatsapp,
                    $registration->address,
                    $registration->created_at,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function schoolAdminShow(string $id)
    {
        $hsRegistration = HSRegistration::findOrFail($id);
        return inertia::render('school-admin/HSRegistration/Show', [
            'hsRegistration' => $hsRegistration,
        ]);
    }

    /**
     * Download or preview registration PDF using Browsershot.
     * 
     * @param string $id
     */
    public function downloadPdf(string $id)
    {
        $registration = HSRegistration::findOrFail($id);

        $filename = 'ARPS-HS-' . $registration->id . '.pdf';
        $file = storage_path('app/private/hs-registrations/' . $filename);

        // Generate the PDF (if not already)
        if (!file_exists($file)) {
            $this->generatePdf($registration);
        }

        return response()->download($file);
    }

    /**
     * Generate PDF using Spatie Browsershot.
     * Uses Blade views: pdfs.registrations.registration-form, _header, _footer
     *
     * @param HSRegistration $registration
     */
    public function generatePdf(HSRegistration $registration)
    {
        $directory = storage_path('app/private/hs-registrations');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $pdf = Pdf::loadView('pdfs.hs_registrations.registration-form', ['registration' => $registration]);
        $pdf->save(storage_path('app/private/hs-registrations/ARPS-HS-' . $registration->id . '.pdf'));

    }
}
