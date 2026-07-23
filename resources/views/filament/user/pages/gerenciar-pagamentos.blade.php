<x-filament::page>
    @if($isCompleted)
        <div class="bg-success-50 border border-success-200 rounded-xl p-6 mb-6 text-center">
            <x-filament::icon alias="heroicon-o-check-circle" class="w-16 h-16 text-success-600 mx-auto mb-4" />
            <h3 class="text-lg font-semibold text-success-800 mb-2">Pagamento Confirmado</h3>
            <p class="text-sm text-success-700 mb-4">
                Sua inscrição foi confirmada com sucesso. Não é mais possível cadastrar ou alterar participantes.
            </p>
            <a href="{{ $pdfUrl }}" target="_blank"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium transition-colors">
                <x-filament::icon alias="heroicon-o-document-arrow-down" class="w-5 h-5" />
                Baixar Comprovante PDF
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Pagamento via PIX</h3>
                <div class="flex flex-col items-center">
                    @if($pixKey)
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($pixKey) }}"
                             alt="QR Code PIX"
                             class="mb-4 rounded-lg"
                             style="width: 200px; height: 200px;">
                        <p class="text-sm text-gray-600 mb-2">Chave PIX:</p>
                        <p class="text-base font-mono font-bold text-gray-900 break-all text-center">{{ $pixKey }}</p>
                        <button onclick="navigator.clipboard.writeText('{{ $pixKey }}').then(() => { this.innerText = 'Copiado!'; setTimeout(() => this.innerText = 'Copiar Chave', 2000); })"
                                class="mt-3 inline-flex items-center gap-1 text-sm font-medium text-primary-600 hover:text-primary-500">
                            <x-filament::icon alias="heroicon-o-clipboard-document" class="w-4 h-4" />
                            Copiar Chave
                        </button>
                    @else
                        <p class="text-gray-500 text-sm">Chave PIX não configurada.</p>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Envio do Comprovante</h3>
                <div class="flex flex-col items-center text-center">
                    <x-filament::icon alias="heroicon-o-phone" class="w-12 h-12 text-gray-400 mb-3" />
                    <p class="text-gray-700 mb-2">
                        Após realizar o pagamento, envie o comprovante via WhatsApp para:
                    </p>
                    @if($whatsapp)
                        <p class="text-lg font-bold text-gray-900 mb-3">{{ $whatsapp }}</p>
                        <a href="{{ $whatsappLink }}" target="_blank"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg font-medium transition-colors">
                            <x-filament::icon alias="heroicon-o-chat-bubble-left-ellipsis" class="w-5 h-5" />
                            Falar no WhatsApp
                        </a>
                    @else
                        <p class="text-gray-500 text-sm">WhatsApp não configurado.</p>
                    @endif

                    <div class="mt-6 w-full border-t border-gray-200 pt-4">
                        <p class="text-sm font-medium text-gray-600 mb-1">Total pago</p>
                        <p class="text-3xl font-bold text-gray-900">R$ {{ number_format($valorTotal, 2, ',', '.') }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $totalPagos }} atleta(s) confirmado(s) x R$ 10,00</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-info-50 border border-info-200 rounded-xl p-4 mb-6">
            <div class="flex gap-3">
                <x-filament::icon alias="heroicon-o-information-circle" class="w-6 h-6 text-info-600 shrink-0 mt-0.5" />
                <div>
                    <p class="text-sm font-medium text-info-800">Atenção</p>
                    <p class="text-sm text-info-700 mt-1">
                        Somente os participantes com status <strong>"Pago"</strong> poderão participar das modalidades.
                        Certifique-se de que todos os participantes estejam com o pagamento confirmado antes do evento.
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <p class="text-sm font-medium text-gray-500">Meus Atletas</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalAtletas }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <p class="text-sm font-medium text-gray-500">Pagamentos Confirmados</p>
                <p class="text-2xl font-bold text-success-600">{{ $totalPagos }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <p class="text-sm font-medium text-gray-500">Pagamentos Pendentes</p>
                <p class="text-2xl font-bold text-danger-600">{{ $totalPendentes }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <p class="text-sm font-medium text-gray-500">Valor Total Pago</p>
                <p class="text-2xl font-bold text-success-600">R$ {{ number_format($valorTotal, 2, ',', '.') }}</p>
            </div>
        </div>
    @endif

    <div class="mb-2">
        <h4 class="text-base font-semibold text-gray-900">Participantes com Pagamento Confirmado</h4>
        <p class="text-sm text-gray-500">Lista dos participantes aptos a participar das modalidades.</p>
    </div>

    {{ $this->table }}
</x-filament::page>
