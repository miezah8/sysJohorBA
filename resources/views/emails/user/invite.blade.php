@component('mail::message')
# You're Invited!

An administrator has invited you to register. Click the button below to complete your registration:

@component('mail::button', ['url' => $inviteUrl])
Accept Invitation
@endcomponent

If you did not expect this invitation, simply ignore this email.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
