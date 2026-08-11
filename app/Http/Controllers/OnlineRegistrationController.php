<?php

namespace App\Http\Controllers;

use App\Mail\OnlineRegistrationMail;
use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;
use App\Services\StorageServiceInterface;

class OnlineRegistrationController extends Controller
{
    private StorageServiceInterface $storageService;

    public function __construct(StorageServiceInterface $storageService)
    {
        $this->storageService = $storageService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $enabled = \App\Models\Setting::get('registration_enabled', '1') === '1';
        $message = \App\Models\Setting::get('registration_message', 'The application has been stopped for the current session!');
        $classes = json_decode(\App\Models\Setting::get('registration_classes', '[]'), true) ?: [];
        $categories = json_decode(\App\Models\Setting::get('registration_categories', '[]'), true) ?: [];
        $defenceCategories = json_decode(\App\Models\Setting::get('registration_defence_categories', '[]'), true) ?: [];
        
        return Inertia::render('OnlineRegistration', [
            'enabled' => $enabled,
            'registrationMessage' => $message,
            'availableClasses' => $classes,
            'availableCategories' => $categories,
            'availableDefenceCategories' => $defenceCategories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (\App\Models\Setting::get('registration_enabled', '1') !== '1') {
            return redirect()->back()->withErrors(['error' => 'Online registration is currently closed.']);
        }

        $validated = $request->validate([

            // Student’s Info
            "admission_for" => "required|in:Day Scholar,Boarding",
            "applicant_name" => "required|string|max:255",
            "dob" => "required|date|before:today",
            "gender" => "required|in:Male,Female,Others",
            "blood_group" => "nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-,",
            "only_child" => "required|in:Yes,No",
            "social_category" => "required|in:GENERAL,SC,ST,OBC-A,OBC-B",
            "nationality" => "required|in:INDIAN,OTHER",
            "bpl" => "required|in:Yes,No",
            "cwsn" => "required|in:Yes,No",
            "aadhaar_no" => "required|integer|digits:12",
            "udise_no" => "nullable|string",
            "pen_no" => "nullable|string",
            "email" => "required|email|max:255",
            "present_class" => "required|string|max:20",
            "present_school_name" => "required|string|max:255",
            "present_school_address" => "required|string|max:255",
            "admission_sought_for_class" => "required|in:Nursery,LKG,UKG,CLASS I,CLASS II,CLASS III,CLASS IV,CLASS V,CLASS VI,CLASS VII,CLASS VIII,CLASS IX,CLASS X,CLASS XI,CLASS XII",

            // ACADEMIC INFORMATION
            "total_subjects" => "sometimes",
            "total_marks_obtained" => "sometimes",
            "full_marks" => "sometimes",

            // PARENT’S INFORMATION in:CIVILIAN,DEFENCE,RETIRED DEFENCE
            "parents_category_b" => "required|string",
            // "parents_category" => "sometimes|string",     // jugad
            "father_name" => "required|string|max:255",
            "father_occupation" => "required|string|max:255",
            "father_phone" => "required|integer|digits:10",
            "mother_name" => "required|string|max:255",
            "mother_occupation" => "required|string|max:255",
            "mother_phone" => "required|integer|digits:10",
            "annual_income" => "required|integer|min:1",

            // CURRENT ADDRESS DETAILS
            "c_street_area_locality" => "required|string|max:255",
            "c_village_town" => "required|string|max:255",
            "c_post_office" => "required|string|max:255",
            "c_pin_code" => "required|integer|digits:6",
            "c_house_no" => "nullable|string|max:255",
            "c_state" => "required|string|max:255",
            "c_district" => "required|string|max:255",

            // PERMANENT ADDRESS DETAILS
            "p_street_area_locality" => "required|string|max:255",
            "p_village_town" => "required|string|max:255",
            "p_post_office" => "required|string|max:255",
            "p_pin_code" => "required|integer|digits:6",
            "p_house_no" => "nullable|string|max:255",
            "p_state" => "required|string|max:255",
            "p_district" => "required|string|max:255",

            // Files (PDFs/Images under 2MB)
            "payment_screenshot" => "required|file|mimes:pdf,jpg,jpeg,png|max:2048",
            "reference_number" => "required|string|max:200|unique:registrations,reference_number|unique:h_s_registrations,reference_number",
        ]);

        // Calculate percentage
        $validated["last_exam_percentage"] = 0;
        if (!$validated['total_subjects']) {
            $validated['total_subjects'] = 0;
        }

        if (!$validated['total_marks_obtained']) {
            $validated['total_marks_obtained'] = 0;
        }

        if (!$validated['full_marks']) {
            $validated['full_marks'] = 0;
        }

        // if ($validated['parents_category']) {
        //     $validated['parents_category_b'] = $validated['parents_category'];
        // }

        if ($validated['total_marks_obtained'] > 0 && $validated['full_marks'] > 0) {
            $validated["last_exam_percentage"] = round(
                ($validated['total_marks_obtained'] / $validated['full_marks']) * 100,
                2
            );
        }

        $fileFields = ['payment_screenshot'];
        $uuidFilenames = [];

        foreach ($fileFields as $field) {
            // if ($request->hasFile($field)) {
            //     $file = $request->file($field);
            //     $ext = $file->getClientOriginalExtension();
            //     $uuid = Str::uuid()->toString();
            //     $filename = $uuid . '.' . $ext;

            //     // Store file in storage/app/public/online-registration/uploads/
            //     $file->storeAs('online-registration/uploads', $filename, 'public');

            //     // Save only the filename in DB
            //     $uuidFilenames[$field] = $filename;
            // }
            $upload = $this->storageService->upload($request->file($field));
            $uuidFilenames[$field] = $upload['url'];
        }

        // Merge file names into the validated data
        $validated = array_merge($validated, $uuidFilenames);

        // Save to database
        $registration = Registration::create($validated);

        // Generate PDF using Browsershot
        $this->generatePdf($registration);

        $this->sendRegistrationMail($registration);

        // Reload the page with success flash data
        return redirect()
            ->back()
            ->with('data', [
                'message' => 'Registration successful!',
                'id' => $registration->id,
            ]);
    }

    /**
     * Display the specified registration details.
     *
     * @param  string  $id  The ID of the registration to retrieve.
     * @return \Inertia\Response  Inertia response that renders the RegistrationShow Vue component.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the registration is not found.
     */
    public function show(string $id)
    {
        $registration = Registration::findOrFail($id);

        return Inertia::render('school-admin/Registrations/RegistrationShow', [
            'registration' => $registration,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $registration = Registration::findOrFail($id);

        return Inertia::render('school-admin/Registrations/Edit', [
            'registration' => $registration,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $registration = Registration::findOrFail($id);

        $validated = $request->validate([
            // Student’s Info
            "admission_for" => "required|in:Day Scholar,Boarding",
            "applicant_name" => "required|string|max:255",
            "dob" => "required|date",
            "gender" => "required|in:Male,Female,Others",
            "blood_group" => "nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-,",
            "only_child" => "required|in:Yes,No",
            "social_category" => "required|in:GENERAL,SC,ST,OBC-A,OBC-B",
            "nationality" => "required|in:INDIAN,OTHER",
            "bpl" => "required|in:Yes,No",
            "cwsn" => "required|in:Yes,No",
            "aadhaar_no" => "required|integer|digits:12",
            "udise_no" => "nullable|string",
            "pen_no" => "nullable|string",
            "email" => "required|email|max:255",
            "present_class" => "required|string|max:20",
            "present_school_name" => "required|string|max:255",
            "present_school_address" => "required|string|max:255",
            "admission_sought_for_class" => "required|in:Nursery,LKG,UKG,CLASS I,CLASS II,CLASS III,CLASS IV,CLASS V,CLASS VI,CLASS VII,CLASS VIII,CLASS IX,CLASS X,CLASS XI,CLASS XII",

            // ACADEMIC INFORMATION
            "total_subjects" => "nullable|integer",
            "total_marks_obtained" => "nullable|integer",
            "full_marks" => "nullable|integer",

            // PARENT’S INFORMATION
            "parents_category_b" => "required|string",
            "father_name" => "required|string|max:255",
            "father_occupation" => "required|string|max:255",
            "father_phone" => "required|integer|digits:10",
            "mother_name" => "required|string|max:255",
            "mother_occupation" => "required|string|max:255",
            "mother_phone" => "required|integer|digits:10",
            "annual_income" => "required|integer|min:1",

            // CURRENT ADDRESS DETAILS
            "c_street_area_locality" => "required|string|max:255",
            "c_village_town" => "required|string|max:255",
            "c_post_office" => "required|string|max:255",
            "c_pin_code" => "required|integer|digits:6",
            "c_house_no" => "nullable|string|max:255",
            "c_state" => "required|string|max:255",
            "c_district" => "required|string|max:255",

            // PERMANENT ADDRESS DETAILS
            "p_street_area_locality" => "required|string|max:255",
            "p_village_town" => "required|string|max:255",
            "p_post_office" => "required|string|max:255",
            "p_pin_code" => "required|integer|digits:6",
            "p_house_no" => "nullable|string|max:255",
            "p_state" => "required|string|max:255",
            "p_district" => "required|string|max:255",

            "reference_number" => "required|string|max:200|unique:registrations,reference_number," . $id . "|unique:h_s_registrations,reference_number",
        ]);

        // Calculate percentage
        $validated["last_exam_percentage"] = 0;
        if (($validated['total_marks_obtained'] ?? 0) > 0 && ($validated['full_marks'] ?? 0) > 0) {
            $validated["last_exam_percentage"] = round(
                ($validated['total_marks_obtained'] / $validated['full_marks']) * 100,
                2
            );
        }

        $registration->update($validated);

        return redirect()
            ->route('school-admin.registration.detail', $registration->id)
            ->with('data', [
                'message' => 'Registration updated successfully!',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $registration = Registration::findOrFail($id);
        $registration->delete();
        return redirect()->back()->with('data', [
            'message' => 'Registration deleted successfully!',
        ]);
    }

    /**
     * school-admin Index
     */
    public function schoolAdminIndex(Request $request)
    {
        $registrations = Registration::latest()->get();
        $enabled = \App\Models\Setting::get('registration_enabled', '1') === '1';
        return Inertia::render('school-admin/Registrations', [
            'registrations' => $registrations,
            'enabled' => $enabled
        ]);
    }

    /**
     * Download all registrations as CSV.
     */
    public function downloadCsv()
    {
        $registrations = Registration::latest()->get();
        $filename = "registrations-" . date('Y-m-d') . ".csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = [
            'ID',
            'Admission For',
            'Applicant Name',
            'DOB',
            'Gender',
            'Blood Group',
            'Only Child',
            'Social Category',
            'Nationality',
            'BPL',
            'CWSN',
            'Aadhaar No',
            'Email',
            'Present Class',
            'Present School',
            'Admission Class',
            'Father Name',
            'Mother Name',
            'Phone',
            'Annual Income',
            'Created At'
        ];

        $callback = function () use ($registrations, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($registrations as $registration) {
                fputcsv($file, [
                    $registration->id,
                    $registration->admission_for,
                    $registration->applicant_name,
                    $registration->dob,
                    $registration->gender,
                    $registration->blood_group,
                    $registration->only_child,
                    $registration->social_category,
                    $registration->nationality,
                    $registration->bpl,
                    $registration->cwsn,
                    $registration->aadhaar_no,
                    $registration->email,
                    $registration->present_class,
                    $registration->present_school_name,
                    $registration->admission_sought_for_class,
                    $registration->father_name,
                    $registration->mother_name,
                    $registration->father_phone,
                    $registration->annual_income,
                    $registration->created_at,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Download or preview registration PDF using Browsershot.
     * 
     * @param string $id
     */
    public function downloadPdf(string $id)
    {
        $registration = Registration::findOrFail($id);

        // Generate the PDF (if not already)
        $this->generatePdf($registration);

        // Define the filename
        $filename = 'ARPS-' . $registration->id . '.pdf';
        // Define the file path
        $file = storage_path('app/private/online-registrations/' . $filename);

        return response()->download($file);
    }

    /**
     * Generate PDF using Spatie Browsershot.
     * Uses Blade views: pdfs.registrations.registration-form, _header, _footer
     *
     * @param Registration $registration
     */
    public function generatePdf(Registration $registration)
    {
        $pdf = Pdf::loadView('pdfs.registrations.registration-form', ['registration' => $registration]);
        $pdf->save(storage_path('app/private/online-registrations/ARPS-' . $registration->id . '.pdf'));

    }

    /**
     * Summary of sendRegistrationMail
     * @param mixed $registration
     * @return void
     */
    public function sendRegistrationMail($registration)
    {
        Mail::to(strtolower($registration->email))
            ->send(new OnlineRegistrationMail($registration));
    }

    /**
     * Test method to send registration mail 
     */
    public function test()
    {
        //query registration from database
        $registration = Registration::findOrFail(6);

        $pdf = Pdf::loadView('pdfs.registrations.registration-form', ['registration' => $registration]);
        $pdf->save(storage_path('app/private/online-registrations/ARPS-' . $registration->id . '.pdf'));

        // Send the registration mail
        $this->sendRegistrationMail($registration);

        return response()->json(['message' => 'Test mail sent successfully!']);
    }
}
