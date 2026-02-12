@component('mail::message')
# Dear {{ $supplierName }},

You have a new expediting form to complete. Please use the secure link below to access your form. This link is valid for 48 hours or until you submit the form.

@component('mail::button', ['url' => $formLink])
Access Expediting Form
@endcomponent

If you have any questions, please contact your expeditor.

Thank you,
{{ config('app.name') }} Team
@endcomponent
