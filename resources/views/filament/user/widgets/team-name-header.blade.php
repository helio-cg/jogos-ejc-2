@php
    $user = auth()->user();
@endphp

<div class="flex items-center gap-2 rounded-xl bg-primary-500/10 px-4 py-3 text-sm font-semibold text-primary-700 dark:text-primary-300">
    <x-heroicon-o-users class="h-5 w-5" />
    Seu time: {{ $user->team_name }}
</div>
