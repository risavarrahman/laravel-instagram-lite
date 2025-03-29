@props(['messages'])


@if ($messages)
    <div
        {{ $attributes->merge([
            'class' => 'p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400',
            'role' => 'alert',
        ]) }}>
        @foreach ((array) $messages as $message)
            {{ $message }}
        @endforeach
    </div>
@endif
