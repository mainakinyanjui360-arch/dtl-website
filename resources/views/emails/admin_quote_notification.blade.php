<!DOCTYPE html>
<html>
<head>
    <title>New Quote Request</title>
</head>
<body>
    <h2>New Quote Request Received</h2>
    <p>A new quotation request has been submitted through the website.</p>
    <ul>
        <li><strong>Name:</strong> {{ $quote->name }}</li>
        <li><strong>Email:</strong> {{ $quote->email }}</li>
        <li><strong>Phone:</strong> {{ $quote->phone }}</li>
        <li><strong>Company:</strong> {{ $quote->company }}</li>
        <li><strong>Interested Service:</strong> {{ $quote->service }}</li>
    </ul>
    <h3>Message / Requirements:</h3>
    <p>{{ $quote->message }}</p>
    <br>
    <p>You can view and manage this request from the Admin Dashboard.</p>
</body>
</html>
