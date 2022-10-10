@props([
    'type' => 'success',
])

<div {{ $attributes->merge([
    'class' => ([
            'info' => 'text-blue-700 bg-blue-100 dark:bg-blue-200 dark:text-blue-800',
            'red' => 'text-red-700 bg-red-100 dark:bg-red-200 dark:text-red-800',
            'success' => 'text-green-700 bg-green-100 dark:bg-green-200 dark:text-green-800',
            'warning' => 'text-yellow-700 bg-yellow-100 dark:bg-yellow-200 dark:text-yellow-800',
            'dark' => 'bg-gray-100 dark:bg-gray-700 dark:text-gray-300',
        ][$type]).' p-4 mb-4 text-sm rounded-lg',
    'role' => 'alert',
]) }}>
    {{ $slot }}
</div>
