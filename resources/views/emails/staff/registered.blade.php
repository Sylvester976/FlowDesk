@component('mail::message')
    # Welcome {{ $first_name }}

    You have been registered in the system. Here are your credentials:

    **Email:** {{ $email }}
    **Password:** {{ $password }}

    @component('mail::button', ['url' => url('/login')])
        Login Now
    @endcomponent

    Thanks,<br>
    Flowdesk
@endcomponent
