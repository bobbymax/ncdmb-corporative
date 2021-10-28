@component('mail::message')
# NCDMB Staff Multipurpose Cooperative Society Portal

Dear Cooperator,

Welcome to the NCDMB Staff Multipurpose Cooperative Society Portal. This portal has been designed to help you manage and be up to date on your transactions with the cooperative. A training guide will be made available for you soon. Please find your login credentials below:

@component('mail::panel')
Username: {{ $user->membership_no }}, <br/>
Password: {{ strtolower($user->firstname) . "." . strtolower($user->surname) }}
@endcomponent

@component('mail::button', ['url' => 'https://portal.ncdmbcoop.com'])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
