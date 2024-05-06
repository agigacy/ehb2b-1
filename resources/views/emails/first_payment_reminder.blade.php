<p>Dear {{ $booking->user->name }},</p>

<p>Good day, this is a kind reminder for the confirmation payment on your tour booking. </p>

<p>Here are the details of your booking details:</p>

<p>Booking ID: {{ $booking->id }}</p>
<p>Total Amount: {{ $booking->total }}</p>

<p>Your payment required to secured the booking.</p>

<p>Best regards,<br> Your Tour Booking Team</p>
<p><b>Esplanad Holiday</b></p>