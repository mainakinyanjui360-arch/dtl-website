<!DOCTYPE html>
<html>
<head>
    <title>Quote Request Received</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <p>Dear {{ $quote->name }},</p>
    
    <p>Thank you for reaching out to Dignity Traders Ltd.</p>
    
    <p>We have successfully received your request for a quotation regarding <strong>{{ $quote->service ?: 'our services' }}</strong>. Our Enterprise Technology Desk is currently reviewing your requirements.</p>
    
    <p>One of our specialists will get back to you shortly with a comprehensive proposal tailored to your needs. If we require any further clarification to prepare your quote, we will contact you via email or the phone number you provided.</p>
    
    <p>If you have any immediate questions, feel free to reply directly to this email.</p>
    
    <br>
    <p>Best Regards,</p>
    <p><strong>Dignity Traders Ltd</strong><br>
    Enterprise Technology Desk</p>
</body>
</html>
