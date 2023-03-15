@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
{{--<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">--}}
    <h4 class="text-black-50 fw-bold fs-4 fst-italic">EUMODELO</h4>
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
