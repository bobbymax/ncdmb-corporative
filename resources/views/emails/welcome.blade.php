@component('mail::message')
# NCDMB Staff Multipurpose Cooperative Society Portal

Dear {{ $user->firstname }},

Welcome to the newly redesigned NCDMB Staff Multipurpose Cooperative Society Portal. This portal has been redesigned to enable you manage and be up to date on your transactions with the cooperative. Training videos have been made available online via a link below and from the portal to help members easily navigate and work with the portal. Please find your login credentials below:

@component('mail::panel')
Username: {{ $user->membership_no }} <br/>
Password: {{ strtolower($user->firstname) . "." . strtolower($user->surname) }}
@endcomponent

@component('mail::panel')
Note: You will be required to change your passwords at the very first login.
For support and further inquiries, kindly send a mail to ncdmbcop@yahoo.com
@endcomponent

@component('mail::button', ['url' => 'https://dashboard.ncdmbcoop.com'])
Login
@endcomponent

Regards,<br>
NCDMB Staff Multipurpose Cooperative Society Ltd
@endcomponent
