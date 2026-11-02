@props(['type' => 'info', 'message'])

@php
    $bgColor = match($type) {
        'success' => '#d1e7dd',
        'error' => '#f8d7da',
        default => '#cff4fc'
    };
    $textColor = match($type) {
        'success' => '#0f5132',
        'error' => '#842029',
        default => '#055160'
    };
@endphp

<div style="padding: 12px 15px; background-color: {{ $bgColor }}; color: {{ $textColor }}; border-radius: 5px; margin-bottom: 20px;">
    <strong>{{ ucfirst($type) }}:</strong> {{ $message }}
</div>