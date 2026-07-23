<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'III EJC Jogos') }}</title>
    @fonts
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="bg-white text-gray-900 font-sans antialiased">

   

    {{-- Hero --}}
    <section class="relative pt-36 pb-28 overflow-hidden">
        <div class="absolute inset-0 -z-10">
            <div class="absolute top-0 left-1/4 w-[600px] h-[600px] bg-gradient-to-br from-emerald-200/30 via-emerald-100/20 to-transparent rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-[500px] h-[500px] bg-gradient-to-br from-sky-200/30 via-sky-100/20 to-transparent rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-5xl mx-auto px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-semibold mb-10">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                23 de Agosto de 2026
            </div>

            <h1 class=" font-extrabold tracking-tight leading-[1.05] mb-8">
                <span class="text-6xl sm:text-7xl lg:text-8xl text-gray-900">III Jogos EJC</span>
                <br>
                <span class="text-2xl sm:text-3xl lg:text-4xl text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-sky-500 pt-4">
                    Paróquia N. Sra. do Perpetuo Socorro - Iguatu-CE
                </span>
            </h1>

            <p class="max-w-2xl mx-auto text-xl sm:text-xl text-gray-500 leading-relaxed mb-10">
                O maior evento esportivo da juventude est&aacute; na sua terceira edi&ccedil;&atilde;o!<br>
                Re&uacute;na sua equipe, escolha sua modalidade e venha competir com amizade e esp&iacute;rito esportivo.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('filament.user.auth.register') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-emerald-400 hover:from-emerald-400 hover:to-emerald-300 text-white font-bold px-10 py-4 rounded-full text-lg transition-all hover:shadow-xl hover:shadow-emerald-200/50 hover:-translate-y-0.5">
                    Garantir vaga
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                <a href="{{ route('filament.user.auth.login') }}" class="inline-flex items-center gap-2 border-2 border-gray-200 hover:border-emerald-300 text-gray-600 hover:text-emerald-700 font-semibold px-10 py-4 rounded-full text-lg transition-all hover:bg-emerald-50/50 hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    J&aacute; tenho conta
                </a>
            </div>

            <p class="mt-6 text-sm text-gray-400 max-w-2xl mx-auto">
                As inscri&ccedil;&otilde;es devem ser feitas por apenas um dos representantes da par&oacute;quia, que ser&aacute; respons&aacute;vel por cadastrar os demais membros da equipe e gerenciar suas inscri&ccedil;&otilde;es de cada modalidade.
            </p>
        </div>
    </section>

    {{-- Info bar --}}
    <section class="border-y border-gray-100 bg-gray-50/60">
        <div class="max-w-5xl mx-auto px-6 lg:px-8 py-10 grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">
            <div class="group">
                <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-emerald-100 to-emerald-50 text-emerald-600 flex items-center justify-center transition-all group-hover:scale-110 group-hover:shadow-lg group-hover:shadow-emerald-200/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Data</p>
                <p class="text-xl font-bold text-gray-900 mt-1">16 de Agosto de 2026</p>
            </div>
            <div class="group">
                <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-sky-100 to-sky-50 text-sky-600 flex items-center justify-center transition-all group-hover:scale-110 group-hover:shadow-lg group-hover:shadow-sky-200/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Local</p>
                <p class="text-xl font-bold text-gray-900 mt-1">Gin&aacute;sio A DEFINIR</p>
            </div>
            <div class="group">
                <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-amber-100 to-amber-50 text-amber-600 flex items-center justify-center transition-all group-hover:scale-110 group-hover:shadow-lg group-hover:shadow-amber-200/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Hor&aacute;rio</p>
                <p class="text-xl font-bold text-gray-900 mt-1">8h &agrave;s 18h</p>
            </div>
        </div>
    </section>

    {{-- Modalidades --}}
    <section class="py-28 px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <span class="text-emerald-600 text-sm font-bold uppercase tracking-[0.2em]">Modalidades</span>
                <h2 class="text-4xl sm:text-5xl font-extrabold text-gray-900 mt-4">Escolha seu esporte</h2>
                <p class="text-lg text-gray-500 mt-4 max-w-2xl mx-auto">Cada modalidade tem vagas limitadas. Monte sua equipe e inscreva-se j&aacute;!</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                {{-- Futsal --}}
                <div class="group bg-white rounded-3xl border border-gray-100 overflow-hidden hover:border-emerald-200 transition-all duration-500 hover:-translate-y-1 hover:shadow-xl hover:shadow-emerald-100/40">
                    <div class="p-8">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-100 to-emerald-50 text-emerald-600 flex items-center justify-center mb-6 transition-all duration-500 group-hover:scale-110 group-hover:shadow-lg group-hover:shadow-emerald-200/30">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Futsal</h3>
                        <p class="text-gray-500 leading-relaxed mb-6">O esporte mais amado do Brasil! Times de 10 jogadores, partidas eletrizantes e muita emo&ccedil;&atilde;o dentro de quadra.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-400 mb-6">
                            <span class="flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg> 10 jogadores</span>
                            <span class="flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg> 2 tempos de 10min</span>
                        </div>
                        <a href="{{ route('filament.user.auth.register') }}" class="inline-flex items-center gap-1 text-emerald-600 font-bold text-sm group/link">
                            Inscrever equipe
                            <svg class="w-4 h-4 transition-all group-hover/link:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Vôlei --}}
                <div class="group bg-white rounded-3xl border border-gray-100 overflow-hidden hover:border-sky-200 transition-all duration-500 hover:-translate-y-1 hover:shadow-xl hover:shadow-sky-100/40">
                    <div class="p-8">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-sky-100 to-sky-50 text-sky-600 flex items-center justify-center mb-6 transition-all duration-500 group-hover:scale-110 group-hover:shadow-lg group-hover:shadow-sky-200/30">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">V&ocirc;lei</h3>
                        <p class="text-gray-500 leading-relaxed mb-6">Times de 6 jogadores, saques potentes e cortadas precisas. O esp&iacute;rito de equipe elevado ao m&aacute;ximo!</p>
                        <div class="flex items-center gap-4 text-sm text-gray-400 mb-6">
                            <span class="flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg> 6 jogadores</span>
                            <span class="flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg> Melhor de 3 sets</span>
                        </div>
                        <a href="{{ route('filament.user.auth.register') }}" class="inline-flex items-center gap-1 text-sky-600 font-bold text-sm group/link">
                            Inscrever equipe
                            <svg class="w-4 h-4 transition-all group-hover/link:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Queimada --}}
                <div class="group bg-white rounded-3xl border border-gray-100 overflow-hidden hover:border-orange-200 transition-all duration-500 hover:-translate-y-1 hover:shadow-xl hover:shadow-orange-100/40">
                    <div class="p-8">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-orange-100 to-orange-50 text-orange-600 flex items-center justify-center mb-6 transition-all duration-500 group-hover:scale-110 group-hover:shadow-lg group-hover:shadow-orange-200/30">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Queimada</h3>
                        <p class="text-gray-500 leading-relaxed mb-6">A cl&aacute;ssica brincadeira virou competi&ccedil;&atilde;o! Agilidade, mira e trabalho em equipe para queimar todos os advers&aacute;rios.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-400 mb-6">
                            <span class="flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg> 10-15 jogadores</span>
                            <span class="flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg> Partidas r&aacute;pidas</span>
                        </div>
                        <a href="{{ route('filament.user.auth.register') }}" class="inline-flex items-center gap-1 text-orange-600 font-bold text-sm group/link">
                            Inscrever equipe
                            <svg class="w-4 h-4 transition-all group-hover/link:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Regulamento CTA --}}
    <section class="py-24 px-6 lg:px-8 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-4xl sm:text-5xl font-extrabold text-gray-900 mb-4">Confira o regulamento</h2>
            <p class="text-lg text-gray-500 mb-8 max-w-2xl mx-auto">Leia atentamente as regras de cada modalidade, crit&eacute;rios de pontua&ccedil;&atilde;o e normas de participa&ccedil;&atilde;o antes de se inscrever.</p>
            <a href="{{ route('regulamento') }}" class="inline-flex items-center gap-2 border-2 border-gray-200 hover:border-emerald-300 hover:bg-emerald-50 text-gray-600 hover:text-emerald-700 font-bold px-10 py-4 rounded-full text-lg transition-all hover:-translate-y-0.5 hover:shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Ler regulamento completo
            </a>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="border-t border-gray-100 bg-white py-10">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-gray-400">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'III EJC Jogos') }} &mdash; Prado Iguatu. Todos os direitos reservados.</p>
            <div class="flex items-center gap-6">
                <a href="{{ route('regulamento') }}" class="hover:text-emerald-600 transition-colors font-medium">Regulamento</a>
                <a href="{{ route('filament.user.auth.login') }}" class="hover:text-emerald-600 transition-colors font-medium">Login</a>
            </div>
        </div>
    </footer>

    <style>
        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .animate-fade-in-up { animation: fade-in-up 0.6s ease-out both; }
        .animate-fade-in { animation: fade-in 0.6s ease-out both; }
    </style>

</body>
</html>
