<x-mail::message>
# Parabéns!

Parabéns pelo {{$data['index']}} lugar no concurso {{$data['contest_name']}} contest em {{$data['end']}}.

<x-mail::panel>
    Você receberá o pagamento em breve.
</x-mail::panel>
{{--<x-mail::button :url="''">--}}
{{--Button Text--}}
{{--</x-mail::button>--}}

Atenciosamente,<br>
{{ config('app.name') }}
</x-mail::message>
