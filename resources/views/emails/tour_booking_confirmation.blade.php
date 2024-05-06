<p>Dear {{ $booking->user->name }},</p>

<p>Thank you for booking the tour. Here are the details of your booking:</p>

<p>Booking ID: {{ $booking->id }}</p>
<p>Total Amount: {{ $booking->total }}</p>

<p>We look forward to seeing you on the tour!</p>

<p>Best regards,<br> Your Tour Booking Team</p>
<p><b>Esplanad Holiday</b></p>

{{-- <p>Thank you for booking the tour. Here are the details of your booking:</p>

<p>We look forward to seeing you on the tour!</p>

<p>Best regards,<br> Your Tour Booking Team</p>
<p><b>Esplanad Holiday</b></p> --}}