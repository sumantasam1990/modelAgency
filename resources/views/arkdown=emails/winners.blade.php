<x-mail::message>
# Parabéns!

Parabéns pelo {{$data['index']}} lugar no {{$data['contest_name']}} em {{$data['end']}}.

<x-mail::panel>
    Você receberá o pagamento do prêmio em breve.
</x-mail::panel>
{{--<x-mail::button :url="''">--}}
{{--Button Text--}}
{{--</x-mail::button>--}}

Atenciosamente,<br>
{{ config('app.name') }}
</x-mail::message>
