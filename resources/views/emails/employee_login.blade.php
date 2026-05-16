<!DOCTYPE html>
<html>
<head>
    <title>Employee Login Details</title>
</head>
<body>

<h2>Welcome to Our Company</h2>

<p>Hello {{ $name }},</p>

<p>You have been successfully registered as an employee.</p>

<h3>Your Login Details:</h3>

<p><strong>Email:</strong> {{ $email }}</p>
<p><strong>Password:</strong> {{ $password }}</p>

<p>Please login using the link below:</p>

<p>
<a href="{{ url('/') }}">
Click Here To Login
</a>
</p>

<p>After login, please change your password.</p>

<p>Regards,<br>
HR Team</p>

</body>
</html>