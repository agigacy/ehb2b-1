<p>Dear {{ ucfirst($booking->user->name) }},</p>
{{-- <p>Dear {{ $booking->user->name }},</p> --}}

<p>Good day, this is a kind reminder for the confirmation payment on your tour booking. </p>

<p>Here are the details of your booking:</p>

<p>Tour ID - {{ $booking->id }}: <b>{{ $booking->tour->package_name }}</b></p>
{{-- <p>Total Amount: {{ $booking->total }}</p> --}}
<p>Total Amount: RM {{ number_format($booking->total, 2, '.', ',') }}</p>

<p>Your payment is required to secured the booking.</p>

<p>Best regards,<br> Your Tour Booking Team</p>
<p><b>Esplanad Holiday</b></p>

{{-- @component('mail::subcopy')
If you have any questions, please don't hesitate to contact us.
@endcomponent

@component('mail::button', ['url' => 'https://localhost:8000/paynow'])
Pay Now
@endcomponent --}}

