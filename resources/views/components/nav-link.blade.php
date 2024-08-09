@props(['active'])

@php
$classes = ($active ?? false)
            ? 'w-44 h-10 text-xl text-light-blue font-bold mx-auto pt-1 bg-lavender-blue bg-opacity-50 rounded-md'
            : 'w-44 h-10 text-xl text-black font-bold mx-auto pt-1';
@endphp

<a {{ $attributes }}>
    <div {{ $attributes->except('href')->merge(['class' => $classes]) }}>
        {{ $slot }}
    </div>
</a>
