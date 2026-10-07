<!DOCTYPE html>
<html>
<head>
    <title>Reply to your Inquiry</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <p>Dear {{ $inquiry->name }},</p>
    
    <div style="white-space: pre-wrap; margin-bottom: 20px;">{{ $replyMessage }}</div>
    
    <p>Best Regards,</p>
    <p><strong>Dignity Traders Ltd</strong></p>

    <hr style="border: 0; border-top: 1px solid #eee; margin: 30px 0;">
    <p style="font-size: 0.9em; color: #777;">
        <strong>Your original inquiry:</strong><br>
        <em>{{ $inquiry->message }}</em>
    </p>
</body>
</html>
