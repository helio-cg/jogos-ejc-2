@if(session('admin_id'))
    <div class="flex items-center gap-2 px-4 py-2 mx-4 mt-2 bg-warning-100 border border-warning-300 rounded-lg">
        <x-filament::icon alias="heroicon-o-exclamation-triangle" class="w-5 h-5 text-warning-600" />
        <span class="text-sm font-medium text-warning-800">Visualizando como usuário</span>
        <a href="{{ route('admin.switch.back') }}"
           class="ml-auto inline-flex items-center gap-1 px-3 py-1 text-sm font-medium text-white bg-warning-600 hover:bg-warning-700 rounded-md transition-colors">
            <x-filament::icon alias="heroicon-o-arrow-left-on-rectangle" class="w-4 h-4" />
            Voltar ao Admin
        </a>
    </div>
@endif
