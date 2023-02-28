<x-mail::message>
# Hello {{$data['name']}},

The ${{$data['prize_money']}} prize pool has been sent to {{$data['to']}} for {{$data['contest_name']}} contest. Check Out!

{{--<x-mail::button :url="''">--}}
{{--Button Text--}}
{{--</x-mail::button>--}}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
