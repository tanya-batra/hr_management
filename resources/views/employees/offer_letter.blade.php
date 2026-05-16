<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Offer Letter</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.5; }
        .header { text-align: center; margin-bottom: 30px; }
        h2 { color: #007bff; }
        .content { margin: 20px; }
        .signature { margin-top: 50px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Company Name</h2>
        <p>Offer Letter</p>
    </div>

    <div class="content">
        <p>Date: {{ \Carbon\Carbon::now()->format('d M, Y') }}</p>
        <p>To,</p>
        <p><strong>{{ $employee->first_name }} {{ $employee->last_name }}</strong></p>
        <p>{{ $employee->address }}, {{ $employee->city }}, {{ $employee->state }}, {{ $employee->pincode }}</p>

        <p>Dear {{ $employee->first_name }},</p>

        <p>We are pleased to offer you the position of <strong>{{ $employee->position }}</strong> in our 
        <strong>{{ $employee->department->name ?? '' }}</strong> department. Your joining date will be 
        <strong>{{ \Carbon\Carbon::parse($employee->join_date)->format('d M, Y') }}</strong> with a salary of 
        <strong>${{ number_format($employee->salary, 2) }}</strong>.</p>

        <p>We look forward to working with you and are confident you will make a significant contribution to our team.</p>

        <div class="signature">
            <p>Sincerely,</p>
            <p><strong>HR Manager</strong></p>
        </div>
    </div>
</body>
</html>