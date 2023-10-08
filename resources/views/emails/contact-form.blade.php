<x-mail::message>
# Contact Form Message

The body of your message.

- Name: {{$name}}
- Email: {{$email}}
- Message: {{$message}}

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
