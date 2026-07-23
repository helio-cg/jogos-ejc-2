@php
    $user = \Illuminate\Support\Facades\Auth::user();
@endphp

<div class="mx-4 mb-4 rounded-xl border border-gray-200 bg-white p-3 shadow-sm">
    <div class="flex items-center gap-2">
        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-green-100">
            <x-heroicon-s-chat-bubble-left-ellipsis class="h-4 w-4 text-green-600" />
        </div>
        <div class="min-w-0">
            <p class="text-xs font-semibold text-gray-700">Dúvidas?</p>
            <a
                href="https://wa.me/5588981302303?text=Ol%C3%A1%2C%20tenho%20d%C3%BAvida%20sobre%20o%20sistema%20EJC"
                target="_blank"
                rel="noopener noreferrer"
                class="text-xs text-green-600 hover:text-green-700 hover:underline"
            >
                Chamar no WhatsApp
            </a>
            <p class="mt-0.5 text-[10px] text-gray-400">(88) 98130-2303</p>
        </div>
    </div>
</div>
