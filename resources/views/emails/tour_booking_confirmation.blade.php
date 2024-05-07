<p>Dear {{ ucfirst($booking->user->name) }},</p>

<p>Thank you for booking the tour. Here are the details of your booking:</p>

<p>Tour ID - {{ $booking->id }}:  <b>{{ $booking->tour->package_name }}</b></p>
<p>Total Amount: RM {{ number_format($booking->total, 2, '.', ',') }}</p>

<p>We look forward to seeing you on the tour!</p>

<p>Best regards,<br> Your Tour Booking Team</p>
<p><b>Esplanad Holiday</b></p>

{{-- <p>Thank you for booking the tour. Here are the details of your booking:</p>

<p>We look forward to seeing you on the tour!</p>

<p>Best regards,<br> Your Tour Booking Team</p>
<p><b>Esplanad Holiday</b></p> --}}