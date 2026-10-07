<!DOCTYPE html>
<html>
<head>
    <title>New Inquiry</title>
</head>
<body>
    <h2>New Inquiry Received</h2>
    <p>A new inquiry has been submitted through the contact page.</p>
    <ul>
        <li><strong>Name:</strong> {{ $inquiry->name }}</li>
        <li><strong>Email:</strong> {{ $inquiry->email }}</li>
        <li><strong>Subject:</strong> {{ $inquiry->subject }}</li>
    </ul>
    <h3>Message Details:</h3>
    <p style="white-space: pre-wrap;">{{ $inquiry->message }}</p>
    <br>
    <p>You can view and reply to this request from the Admin Dashboard.</p>
</body>
</html>
