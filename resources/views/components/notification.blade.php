{{-- 
    Notification Component
    
    Parameters:
    - type: success, warning, error, info (required)
    - message: The notification message (required)
    - timeout: Auto-dismiss timeout in milliseconds (optional, default: 7000, 0 for no auto-dismiss)
    - id: Custom ID for the notification (optional)
    
    Usage examples:
    <x-notification type="success" message="Operation completed successfully" />
    <x-notification type="warning" :message="$warningMessage" :timeout="10000" />
    <x-notification type="error" message="Error occurred" :timeout="0" />
--}}

@props([
    'type' => 'info', 
    'message' => '', 
    'timeout' => 7000,
    'id' => null
])

@php
    // Determine colors based on notification type
    $colors = [
        'success' => [
            'bg' => 'bg-green-50',
            'border' => 'border-green-400',
            'text' => 'text-green-800',
            'icon' => 'text-green-500',
            'hover' => 'hover:bg-green-100',
            'ring' => 'focus:ring-green-600',
            'ring-offset' => 'focus:ring-offset-green-50'
        ],
        'warning' => [
            'bg' => 'bg-yellow-50',
            'border' => 'border-yellow-400',
            'text' => 'text-yellow-800',
            'icon' => 'text-yellow-500',
            'hover' => 'hover:bg-yellow-100',
            'ring' => 'focus:ring-yellow-600',
            'ring-offset' => 'focus:ring-offset-yellow-50'
        ],
        'error' => [
            'bg' => 'bg-red-50',
            'border' => 'border-red-400',
            'text' => 'text-red-800',
            'icon' => 'text-red-500',
            'hover' => 'hover:bg-red-100',
            'ring' => 'focus:ring-red-600',
            'ring-offset' => 'focus:ring-offset-red-50'
        ],
        'info' => [
            'bg' => 'bg-blue-50',
            'border' => 'border-blue-400',
            'text' => 'text-blue-800',
            'icon' => 'text-blue-500', // Added
            'hover' => 'hover:bg-blue-100', // Added
            'ring' => 'focus:ring-blue-600', // Added
            'ring-offset' => 'focus:ring-offset-blue-50'
        ],
    ];
    
    $color = $colors[$type] ?? $colors['info'];
    
    // Generate a unique ID if not provided
    $alertId = $id ?? 'alert-' . $type . '-' . uniqid();
@endphp

<div id="{{ $alertId }}" 
     class="hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 ease-in-out {{ $color['bg'] }} border {{ $color['border'] }} {{ $color['text'] }} px-4 py-3 rounded-lg relative mb-6 shadow-md flex items-start" 
     role="alert">
    <div class="flex-shrink-0">
        @if($type === 'success')
            <svg class="h-5 w-5 {{ $color['icon'] }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
        @elseif($type === 'warning')
            <svg class="h-5 w-5 {{ $color['icon'] }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.216 3.031-1.742 3.031H4.42c-1.526 0-2.492-1.697-1.742-3.031l5.58-9.92zM10 13a1 1 0 110-2 1 1 0 010 2zm-1-8a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
            </svg>
        @elseif($type === 'error')
            <svg class="h-5 w-5 {{ $color['icon'] }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
        @else {{-- info or default }}
            <svg class="h-5 w-5 {{ $color['icon'] ?? 'text-blue-500' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
            </svg>
        @endif
    </div>
    <div class="ml-3 flex-grow">
        @if (!empty($message))
            <p class="text-sm @if($type === 'error' || $type === 'warning') font-semibold @endif @if($slot->isNotEmpty()) mb-1 @endif">{!! $message !!}</p>
        @endif
        
        @if ($slot->isNotEmpty())
            <div @if(!empty($message)) class="mt-1 text-sm" @else class="text-sm" @endif>
                {{ $slot }}
            </div>
        @elseif (empty($message) && !$slot->isNotEmpty())
            {{-- Fallback generic message if both slot and message are empty --}}
            <p class="text-sm @if($type === 'error' || $type === 'warning') font-semibold @endif">
                @switch($type)
                    @case('success') Action completed successfully. @break
                    @case('warning') Please review the information. @break
                    @case('error') An error has occurred. @break
                    @default Notification.
                @endswitch
            </p>
        @endif
    </div>
    <div class="ml-auto pl-3">
        <div class="-mx-1.5 -my-1.5">
            <button type="button" 
                    class="inline-flex {{ $color['bg'] }} rounded-md p-1.5 {{ $color['text'] }} {{ $color['hover'] }} focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $color['ring'] }} {{ $color['ring-offset'] }}"
                    data-hs-remove-element="#{{ $alertId }}">
                <span class="sr-only">Dismiss</span>
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const alertElement = document.getElementById('{{ $alertId }}');
    const timeoutDuration = parseInt('{{ $timeout }}', 10);

    if (alertElement && timeoutDuration > 0) {
        setTimeout(() => {
            if (alertElement.parentNode) { // Check if the element still exists and has a parent
                alertElement.classList.add('hs-removing');
                
                alertElement.addEventListener('transitionend', () => {
                    if (alertElement.parentNode) {
                        alertElement.remove();
                    }
                }, { once: true });

                // Fallback: if transitionend doesn't fire (e.g. element becomes display:none or no transition defined)
                // This delay should be slightly longer than the CSS transition duration (300ms from class)
                setTimeout(() => {
                    if (alertElement.parentNode) {
                        alertElement.remove();
                    }
                }, 350); // transition duration is 300ms, 350ms provides a small buffer
            }
        }, timeoutDuration);
    }
    // The data-hs-remove-element attribute on the close button should be handled by Preline UI's JavaScript.
    // If Preline UI (e.g., from app.js or a global script) is initialized, it will manage the click-to-close behavior.
});
</script>
