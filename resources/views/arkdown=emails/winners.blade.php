<x-mail::message>
# Congratulations!

Congratulations on the {{$data['index']}}nd place in the {{$data['contest_name']}} contest in {{$data['end']}}.

<x-mail::panel>
    You will receive your prize payment shortly.
</x-mail::panel>
{{--<x-mail::button :url="''">--}}
{{--Button Text--}}
{{--</x-mail::button>--}}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
