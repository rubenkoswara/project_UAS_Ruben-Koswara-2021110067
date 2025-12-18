<div {{ $attributes }}>
    @if (config('app.logo_url'))
        <img src="{{ config('app.logo_url') }}" alt="{{ config('app.name', 'Laravel') }}" class="block h-9 w-auto" />
    @else
        <x-application-mark class="block h-9 w-auto" />
    @endif
</div>