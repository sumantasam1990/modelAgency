<x-mail::message>
# Olá {{$data['name']}},

valor de R${{$data['prize_money']}} foi enviado para o seu {{$data['to']}} pelo {{$data['contest_name']}} contest. Confira!

{{--<x-mail::button :url="''">--}}
{{--Button Text--}}
{{--</x-mail::button>--}}

Atenciosamente,<br>
{{ config('app.name') }}
</x-mail::message>
