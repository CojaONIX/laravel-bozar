<x-mail::message>
# Contact Form Message

The body of your message.

- Name: {{$name}}
- Email: {{$email}}
- Message: {{$message}}

<x-mail::panel>
This is the panel content.
</x-mail::panel>

<x-mail::table>
| Laravel       | Table         | Example  |
| ------------- |:-------------:| --------:|
| Col 2 is      | Centered      | $10      |
| Col 3 is      | Right-Aligned | $20      |
</x-mail::table>

<x-mail::button :url="''" color="success">
Success
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
