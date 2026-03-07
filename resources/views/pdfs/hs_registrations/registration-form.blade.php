<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registration Form - {{ $registration->applicant_name }}</title>
    <style>
        @page {
            size: A4;
        }

        body {
            font-family: Arial, sans-serif;
            margin-top: 120px;
            font-size: 13px;
            color: #111;
            counter-reset: page;
        }

        .special-characters {
            font-family: DejaVu Sans, sans-serif;
        }

        h3.section-title {
            background-color: #f5f5f5;
            padding: 8px;
            font-size: 16px;
            border-left: 5px solid #007BFF;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px 10px;
            border: 1px solid #ccc;
            text-align: left;
            vertical-align: top;
        }

        th {
            width: 40%;
            background-color: #fafafa;
        }

        .page-break {
            page-break-before: always;
            break-after: page;
        }

        header {
            position: fixed;
            top: 0px;
            left: 0px;
            right: 0px;
        }

        .page-no {
            position: fixed;
            bottom: 0px;
        }
    </style>
</head>

<body>

    <header style="border-bottom: 1px solid #ccc; padding-bottom: 5px;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="text-align: left; border: none; padding: 0;">
                    <h2 style="margin: 0; padding: 0;">ASSAM RIFLES PUBLIC SCHOOL</h2>
                    <h3 style="margin: 0; padding: 0;">NEFABARI, ROWRIAH, JORHAT-785621 (ASSAM)</h3>
                    <div style="margin: 0; padding: 0;">CBSE Affiliation No: 280010</div>
                    <div style="margin: 0; padding: 0;">Email: arpsjorhat@ymail.com</div>
                    <div style="margin: 0; padding: 0;">Phone No: +91 93956 42231 (O)</div>
                </td>
                <td style="text-align: right; width: 120px; border: none; padding: 0;">
                    <img src="{{ public_path('storage/logos/site-logo.png') }}" alt="Logo"
                        style="width: 100px; height: 100px; margin: 0; padding: 0;">
                </td>
            </tr>
        </table>
    </header>

    <footer>

    </footer>

    <main>
        <table style="width: 100%; border-collapse: collapse; margin: 0; vertical-align: middle;">
            <tr>
                <td style="text-align: left; border: none; padding: 0;">
                    <h2 style="margin: 0;">Online Registration Form</h2>
                    <p>For Class XI Admission</p>
                </td>
                <td style="text-align: right; border: none; padding: 0;">
                    <span>{{ $registration->created_at->format('d-m-Y H:i:s') }}</span>
                </td>
            </tr>
        </table>


        {{-- Student Info --}}
        <h3 class="section-title">Student’s Information</h3>
        <table>
            <tr>
                <th>Registration ID</th>
                <td>HS-{{ $registration->id ?? '' }}</td>
            </tr>
            @foreach ([
                    'Admission For' => 'Class XI',
                    'Applicant Name' => $registration->name,
                    'Stream' => $registration->stream,
                    'Date of Birth' => $registration->dob,
                    'Gender' => $registration->gender,
                    'PEN No' => $registration->pen_no,
                    'APAAR ID' => $registration->apaar_id,
                    'Email' => $registration->email,
                    'Contaact Number' => $registration->contact_number,
                    'Payment Reference Number' => $registration->payment_reference_number,
                ] as $label => $value)
                    <tr>
                        <th>{{ $label }}</th>
                        <td>{{ $value ?: '-' }}</td>
                </tr>
              @endforeach
    </table>

        <div class="page-no">Page 1 of 3</div>
        <div class="page-break"></div>

        {{-- Academic Info --}}
        <h3 class="section-title">Academic Information</h3>
        <table>
            @foreach ([
                    'Previous School Name' => $registration->last_school,
                    'Pre-Board Percentage' => $registration->pre_borad_percentage,
                ] as $label => $value)
                <tr>
                    <th>{{ $label }}</th>
                        <td>{{ $value ?: '-' }}</td>
                    </tr>
            @endforeach
        </table>

        {{-- Parent Info --}}
        <h3 class="section-title">Parent’s Information</h3>
        <table>
            @foreach ([
                    'Father\'s Name' => $registration->father_name,
                    'Mother\'s Name' => $registration->mother_name,
                    'Parent\'s Contact Number' => $registration->parents_contact_number,
                    'WhatsApp' => $registration->whatsapp,
                ] as $label => $value)
                    <tr>

                                   <th>{{ $label }}</th>
                        <td>{{ $value ?: '-' }}</td>
                    </tr>

               @endforeach
        </table>

        {{-- Current Address --}}
        <h3 class="section-title">Address</h3>
        <table>
            @foreach ([
                    'Address' => $registration->address,
                ] as $label => $value)
                    <tr>
                        <th>{{ $label }}</th>
                        <td>{{ $value ?: '-' }}</td>
                    </tr>
            @endforeach
        </table>

        <p style="margin-top: 60px;">
            <span class="special-characters">[ ✓ ]</span> I CERTIFY THAT THE INFORMATION GIVEN ABOVE IS TRUE TO THE BEST OF MY KNOWLEDGE.
            <br>
            I HAVE STUDIED THE PROSPECTUS OF THE SCHOOL AND HAVE UNDERSTOOD THE RULES AND REGULATIONS.
        </p>

        <p style="margin-top: 80px; text-align: right;">
            Signature : _________________________________________
        </p>

        <div class="page-no">Page 3 of 3</div>
    </main>
</body>

</html>