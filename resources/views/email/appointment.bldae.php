@component('mail::message')
<p>Hello <b>{{ $appointment->name ?? ''}}</b> booked an appointment of your bridal suite, Please Contact him via email
    or phone. Here are the details:</p>
<p>Email: <b>{{ $appointment->email ?? ''}}</b>,</p>
<p>Contact: <b>{{ $appointment->phone ?? ''}}</b>,</p>
<p>Prefferable Date: <b>{{ $appointment->date ?? ''}}</b>,</p>
<p>Prefferable Time: <b>{{ $appointment->time ?? ''}}</b>,</p>
@endcomponent