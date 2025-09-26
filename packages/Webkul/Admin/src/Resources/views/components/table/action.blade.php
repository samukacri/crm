@props([
    'type' => 'delete',
])

@php
    $classes = [
        'delete' => 'icon-delete text-2xl',
        'edit' => 'icon-edit text-2xl',
        'view' => 'icon-eye text-2xl',
    ];

    $class = $classes[$type] ?? 'icon-' . $type . ' text-2xl';
@endphp

<span class="{{ $class }}"></span>