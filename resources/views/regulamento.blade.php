<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Regulamento - {{ config('app.name', 'III EJC Jogos') }}</title>
    @fonts
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="bg-white text-gray-900 font-sans antialiased min-h-screen">

    {{-- Background accents --}}
    <div class="fixed inset-0 -z-10 pointer-events-none overflow-hidden">
        <div class="absolute -top-40 -left-40 w-[500px] h-[500px] bg-gradient-to-br from-emerald-200/20 via-emerald-100/10 to-transparent rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 w-[500px] h-[500px] bg-gradient-to-br from-sky-200/20 via-sky-100/10 to-transparent rounded-full blur-3xl"></div>
    </div>

    {{-- Navbar --}}
    <nav class="sticky top-0 inset-x-0 z-50 bg-white/70 backdrop-blur-lg border-b border-gray-100">
        <div class="max-w-5xl mx-auto px-6 lg:px-8 flex items-center justify-between h-16">
            <a href="{{ url('/') }}" class="text-lg font-bold tracking-tight">
                <span class="text-emerald-600">EJC</span>
            </a>
            <div class="flex items-center gap-4">
                <a href="{{ route('regulamento') }}" class="text-sm text-emerald-600 font-semibold border-b-2 border-emerald-500 pb-0.5">Regulamento</a>
                <a href="{{ route('filament.user.auth.login') }}" class="text-sm text-gray-500 hover:text-emerald-600 transition-colors font-medium">Entrar</a>
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="pt-24 pb-16 px-6 lg:px-8 text-center">
        <div class="max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-semibold mb-8">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                23 de Agosto de 2026
            </div>
            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight leading-[1.1] mb-4">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-sky-500">
                    Regulamento
                </span>
            </h1>
            <p class="text-xl text-gray-500 max-w-2xl mx-auto">III Jogos EJC &mdash; Par&oacute;quia de Nossa Senhora do Perp&eacute;tuo Socorro &mdash; Iguatu-CE</p>
            <p class="text-emerald-600 font-bold mt-2">Leiam o regulamento completo!</p>
        </div>
    </section>

    {{-- Content --}}
    <div class="max-w-4xl mx-auto px-6 lg:px-8 pb-20">

        <div class="space-y-12">

            {{-- INSCRIÇÃO --}}
            <section class="bg-white rounded-3xl border border-gray-100 p-8 sm:p-10 shadow-sm hover:shadow-lg hover:shadow-emerald-100/30 transition-all duration-500">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-emerald-700 tracking-tight mb-8 flex items-center gap-3">
                    <span class="w-1.5 h-8 bg-emerald-500 rounded-full"></span>
                    INSCRI&Ccedil;&Atilde;O DOS JOGADORES
                </h2>
                <div class="space-y-5 text-gray-700 leading-relaxed">
                    <p><strong class="text-gray-900">Art.01</strong> &mdash; Cada jovem ou tio no ato da inscri&ccedil;&atilde;o do torneio dever&aacute; pagar R$10,00 reais.</p>
                    <p>&bull; O prazo para inscri&ccedil;&atilde;o das equipes vai at&eacute; o dia: <strong class="text-gray-900">06/08/26</strong></p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Os jovens e tios devem estar ativos no EJC ou ECC.</li>
                        <li>Os jovens devem jogar pela <strong>SUA PARÓQUIA</strong>, n&atilde;o sendo permitido formar times com jovens de outras par&oacute;quias.</li>
                        <li>Jovens que vivem vida marital (Casado ou morando junto como se fosse casado(a)) e n&atilde;o fazem parte do ECC <strong class="text-red-600">NÃO PODEM JOGAR O TORNEIO</strong>, caso mesmo assim algum jovem que se encontra em situa&ccedil;&atilde;o irregular se inscreva ignorando essa regra, o mesmo ser&aacute; desclassificado do torneio sem reembolso.</li>
                        <li>As vagas s&atilde;o limitadas a <strong>02 (dois) times por par&oacute;quia</strong> nas respectivas modalidades:
                            <div class="flex flex-wrap gap-3 mt-3">
                                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-emerald-100 text-emerald-700 text-sm font-semibold">Futsal</span>
                                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-sky-100 text-sky-700 text-sm font-semibold">Voleibol</span>
                                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-orange-100 text-orange-700 text-sm font-semibold">Queimada</span>
                            </div>
                            Portanto os interessados devem organizar para garantir sua vaga no torneio.
                        </li>
                    </ul>

                    <p><strong class="text-gray-900">Art.02</strong> &mdash; Os jogos ser&atilde;o realizados apenas com os jovens do EJC e tios do ECC da par&oacute;quia do Prado e de outras par&oacute;quias convidadas.</p>

                    <p><strong class="text-gray-900">Art.03</strong> &mdash; O jovem ou tio uma vez inscrito poder&aacute; participar de todas as modalidades caso assim deseje e desde que tamb&eacute;m possua alguma equipe.</p>

                    <p><strong class="text-gray-900">Art.04</strong> &mdash; Futsal, voleibol e queimada (carimba): Cada equipe dever&aacute; possuir um l&iacute;der seja ele um jovem ou um tio, o mesmo ficar&aacute; respons&aacute;vel de realizar a inscri&ccedil;&atilde;o dos seus jogadores.</p>
                    <ul class="list-disc pl-6 space-y-1">
                        <li>Os tios podem jogar no mesmo time que os jovens e vice-versa.</li>
                        <li>No ato da inscri&ccedil;&atilde;o dever&aacute; ser pago o valor referente ao n&uacute;mero de jogadores inscritos.</li>
                        <li>No dia do evento s&oacute; poder&atilde;o jogar os jovens que tiverem quites com a sua inscri&ccedil;&atilde;o.</li>
                        <li>O formato dos torneios ser&aacute; anunciado no dia do evento.</li>
                    </ul>

                    <p><strong class="text-gray-900">Art.05</strong> &mdash; Todas as pessoas devidamente registradas no Torneio s&atilde;o pass&iacute;veis de puni&ccedil;&atilde;o, estando ou n&atilde;o dentro de quadra, podendo estar em qualquer parte do ambiente em quest&atilde;o para se tornar pass&iacute;vel de puni&ccedil;&atilde;o a qualquer momento.</p>

                    <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r-xl">
                        <p><strong class="text-gray-900">Art.06</strong> &mdash; Praticar viol&ecirc;ncia ou vias de fato contra os Oficiais de Arbitragem, Coordena&ccedil;&atilde;o do Torneio, Companheiros de Equipe, Componentes de Equipe advers&aacute;ria ou qualquer outra pessoa.</p>
                        <p class="mt-1 text-red-700 font-semibold">Puni&ccedil;&atilde;o: Elimina&ccedil;&atilde;o do Torneio e outras medidas cab&iacute;veis, com perda de pontos a crit&eacute;rio da Comiss&atilde;o Organizadora.</p>
                    </div>

                    <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r-xl">
                        <p><strong class="text-gray-900">Art.07</strong> &mdash; Invadir a quadra, com prop&oacute;sito de ofender, discutir, tirar satisfa&ccedil;&atilde;o com os Oficiais de Arbitragem, Atletas, Dirigentes ou qualquer outra Pessoa.</p>
                        <p class="mt-1 text-red-700 font-semibold">Puni&ccedil;&atilde;o: Elimina&ccedil;&atilde;o do Torneio e outras medidas cab&iacute;veis, com perdas de pontos &aacute; crit&eacute;rio da Comiss&atilde;o Organizadora.</p>
                    </div>

                    <div class="bg-amber-50 border-l-4 border-amber-400 p-4 rounded-r-xl">
                        <p><strong class="text-gray-900">Art.08</strong> &mdash; A Equipe que realizar a partida sem que o atleta esteja devidamente inscrito.</p>
                        <p class="mt-1 text-amber-700 font-semibold">Puni&ccedil;&atilde;o: Derrota autom&aacute;tica.</p>
                    </div>

                    <div class="bg-amber-50 border-l-4 border-amber-400 p-4 rounded-r-xl">
                        <p><strong class="text-gray-900">Art.09</strong> &mdash; Caso seja descoberto que algum jogador n&atilde;o &eacute; um jovem EJC ou tio do ECC o mesmo n&atilde;o poder&aacute; mais jogar e a equipe sofrer&aacute; puni&ccedil;&otilde;es como: Perder a partida corrente automaticamente, perda de pontos, perder a pr&oacute;xima partida automaticamente.</p>
                    </div>
                </div>
            </section>

            {{-- OUTRAS CONSIDERAÇÕES --}}
            <section class="bg-white rounded-3xl border border-gray-100 p-8 sm:p-10 shadow-sm hover:shadow-lg hover:shadow-emerald-100/30 transition-all duration-500">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-800 tracking-tight mb-8 flex items-center gap-3">
                    <span class="w-1.5 h-8 bg-gray-400 rounded-full"></span>
                    OUTRAS CONSIDERA&Ccedil;&Otilde;ES
                </h2>
                <div class="space-y-4 text-gray-700 leading-relaxed">
                    <p><strong class="text-gray-900">Art.01</strong> &mdash; Jovens e tios de outras par&oacute;quias podem ir assistir o evento normalmente.</p>
                    <p><strong class="text-gray-900">Art.02</strong> &mdash; No dia do evento ser&aacute; vendido pela equipe dirigente lanche, bebidas (N&atilde;o alco&oacute;licas) e almo&ccedil;o.</p>
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r-xl">
                        <p><strong class="text-gray-900">Art.03</strong> &mdash; N&atilde;o ser&aacute; permitido o consumo de bebidas alco&oacute;licas durante o evento, em caso de desrespeito perante essa regra o jovem ser&aacute; removido do ambiente e sua equipe sofrer&aacute; puni&ccedil;&otilde;es como: Desclassifica&ccedil;&atilde;o e perca de pontos.</p>
                    </div>
                </div>
            </section>

            {{-- VOLEIBOL --}}
            <section class="bg-white rounded-3xl border border-sky-200 p-8 sm:p-10 shadow-sm hover:shadow-lg hover:shadow-sky-100/40 transition-all duration-500">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-sky-700 tracking-tight mb-8 flex items-center gap-3">
                    <span class="w-1.5 h-8 bg-sky-500 rounded-full"></span>
                    REGULAMENTO VOLEIBOL MISTO
                </h2>
                <div class="space-y-5 text-gray-700 leading-relaxed">
                    <p><strong class="text-gray-900">Art.01</strong> &mdash; Cada equipe poder&aacute; inscrever no m&iacute;nimo 06 (seis) e no m&aacute;ximo 12 (doze) atletas. Dever&atilde;o estar inscritos 03 (tr&ecirc;s) meninas no m&iacute;nimo em cada equipe.</p>

                    <h3 class="font-bold text-gray-900 mt-6 text-lg">DA COMPETI&Ccedil;&Atilde;O</h3>

                    <p><strong class="text-gray-900">Art.02</strong> &mdash; Os Jogos ser&atilde;o disputados em local e hor&aacute;rio a serem divulgados em breve, que ser&atilde;o enviados nos grupos das par&oacute;quias.</p>

                    <p><strong class="text-gray-900">Art.03</strong> &mdash; As Equipes dever&atilde;o estar no local de jogo 10 minutos antes do hor&aacute;rio previsto para sua realiza&ccedil;&atilde;o. Estarem com cal&ccedil;ado apropriado.</p>

                    <p><strong class="text-gray-900">Art.04</strong> &mdash; O jogo s&oacute; poder&aacute; ser iniciado com 06 (seis) atletas em quadra. Sendo no m&iacute;nimo duas meninas em quadra. Se uma equipe n&atilde;o estiver representada com 6 jogadores, ser&aacute; penalizada com a perda da partida por W. O. Cada equipe poder&aacute; inscrever, para cada partida, o m&aacute;ximo de 12 (doze) atletas.</p>

                    <p><strong class="text-gray-900">Art.05</strong> &mdash; A competi&ccedil;&atilde;o de Voleibol ser&aacute; realizada de acordo com as Regras Internacionais adotadas pela Confedera&ccedil;&atilde;o Brasileira de Voleibol, este Regulamento e as normas adotadas pela Comiss&atilde;o Geral Organizadora.</p>

                    <p><strong class="text-gray-900">Art.06</strong> &mdash; O n&uacute;mero de sets disputados ser&aacute; de 02 (dois) sets vencedores (melhor de tr&ecirc;s). Cada set &eacute; disputado utilizando o sistema &quot;ponto por rally&quot; (conforme regra), sem vantagem, at&eacute; um dos dois times atingir 15 pontos. Havendo necessidade do 3&ordm; set, este ser&aacute; disputado em 10 pontos. Em cada set &eacute; necess&aacute;rio uma diferen&ccedil;a m&iacute;nima de 02 (dois) pontos para uma equipe ser vencedora.</p>

                    <p><strong class="text-gray-900">Art.07</strong> &mdash; A pontua&ccedil;&atilde;o para a classifica&ccedil;&atilde;o geral ser&aacute; a seguinte:</p>
                    <ul class="list-disc pl-8 space-y-1">
                        <li>Vit&oacute;ria = 03 pontos</li>
                        <li>Derrota = 00 ponto</li>
                        <li>Derrota por desist&ecirc;ncia = -1 ponto</li>
                    </ul>

                    <p><strong class="text-gray-900">Art.08</strong> &mdash; Em caso de empate na classifica&ccedil;&atilde;o entre 02 (duas) ou mais equipes, ser&atilde;o observados os seguintes crit&eacute;rios para desempate:</p>
                    <ul class="list-disc pl-8 space-y-1">
                        <li>a) entre 02 (duas) equipes: confronto direto.</li>
                        <li>b) entre mais de 02 (duas) equipes:
                            <ul class="list-circle pl-6 space-y-1 mt-1">
                                <li>saldo de sets na fase;</li>
                                <li>saldo de pontos na fase;</li>
                                <li>Maior coeficiente de pontos average em todas as partidas realizadas pelos empatados na fase (rela&ccedil;&atilde;o entre o n&uacute;mero de pontos pr&oacute; pelos n&uacute;mero de pontos contra);</li>
                                <li>sorteio.</li>
                            </ul>
                        </li>
                    </ul>

                    <p><strong class="text-gray-900">Art.09</strong> &mdash; No caso de aus&ecirc;ncia (W x O), o placar final ser&aacute; de 02 x 00 (12 x 00 e 12 x 00) para a equipe vencedora.</p>

                    <div class="bg-amber-50 border-l-4 border-amber-400 p-4 rounded-r-xl">
                        <p><strong class="text-gray-900">Art.10</strong> &mdash; Os times dever&atilde;o permanecer durante toda a partida com pelo menos 2 jogadores do sexo oposto (pelo menos duas mulheres ou pelo menos dois homens). No caso de n&atilde;o observ&acirc;ncia desta cl&aacute;usula, o time ser&aacute; penalizado com a perda da partida.</p>
                    </div>

                    <p><strong class="text-gray-900">Art.11</strong> &mdash; As etapas do torneio, f&oacute;rmula de disputa e a tabela ser&atilde;o divulgados ap&oacute;s o per&iacute;odo de inscri&ccedil;&otilde;es.</p>
                </div>
            </section>

            {{-- FUTSAL --}}
            <section class="bg-white rounded-3xl border border-emerald-200 p-8 sm:p-10 shadow-sm hover:shadow-lg hover:shadow-emerald-100/40 transition-all duration-500">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-emerald-700 tracking-tight mb-8 flex items-center gap-3">
                    <span class="w-1.5 h-8 bg-emerald-500 rounded-full"></span>
                    REGULAMENTO FUTSAL MASCULINO
                </h2>
                <div class="space-y-5 text-gray-700 leading-relaxed">
                    <p><strong class="text-gray-900">Art. 1</strong> &mdash; O torneio de futsal, masculino, ser&aacute; realizado de acordo com as regras estabelecidas pela Federa&ccedil;&atilde;o Internacional de Futebol Association (FIFA), adotadas pela Confedera&ccedil;&atilde;o Brasileira de Futebol de Sal&atilde;o (CBFS), e pelo que dispuser este Regulamento.</p>

                    <p><strong class="text-gray-900">Art. 2</strong> &mdash; As partidas ter&atilde;o a dura&ccedil;&atilde;o de 20 minutos, divididos em dois per&iacute;odos de 10 minutos cada um. (Podendo haver uma redu&ccedil;&atilde;o para 16 minutos totais, dividido em dois per&iacute;odos de 8 minutos, cada um de acordo com a quantidade inscritos e cronograma do evento).</p>

                    <div class="bg-amber-50 border-l-4 border-amber-400 p-4 rounded-r-xl">
                        <p><strong class="text-gray-900">Art. 3</strong> &mdash; O jogo n&atilde;o iniciar&aacute; se uma das equipes n&atilde;o estiver em quadra, com 5 jogadores prontos para jogar. Ap&oacute;s 03 minutos da hora prevista para o in&iacute;cio, a equipe faltosa perder&aacute; o jogo por 1x0.</p>
                    </div>

                    <p><strong class="text-gray-900">Art. 4</strong> &mdash; Se durante uma partida o n&uacute;mero de jogadores de uma equipe for inferior a 3, a partida ser&aacute; encerrada e a equipe faltosa perder&aacute; o jogo.</p>

                    <p><strong class="text-gray-900">Art. 5</strong> &mdash; Se a equipe considerada vencedora estiver com vantagem no momento do encerramento da partida de que trata o artigo anterior, a contagem, nesta ocasi&atilde;o, ser&aacute; mantida. Por&eacute;m, em caso contr&aacute;rio, a equipe infratora perder&aacute; o jogo por 1x0.</p>

                    <p><strong class="text-gray-900">Art. 6</strong> &mdash; Todo atleta expulso de uma partida cumprir&aacute; suspens&atilde;o pelo resto do jogo e no pr&oacute;ximo tamb&eacute;m.</p>

                    <p><strong class="text-gray-900">Art. 7</strong> &mdash; Durante o transcurso de uma partida, n&atilde;o haver&aacute; limites de substitui&ccedil;&otilde;es, podendo o atleta substitu&iacute;do retornar ao jogo a qualquer tempo.</p>

                    <p><strong class="text-gray-900">Art. 8</strong> &mdash; Havendo empate em n&uacute;mero de pontos ganhos entre os participantes na fase classificat&oacute;ria, ser&aacute; declarada vencedora a equipe que obtiver, nesta ordem:</p>
                    <ol class="list-decimal pl-8 space-y-1">
                        <li>Maior n&uacute;mero de vit&oacute;rias;</li>
                        <li>Maior saldo de gols;</li>
                        <li>Confronto direto;</li>
                        <li>Gols pr&oacute;;</li>
                        <li>Menor n&uacute;mero de cart&otilde;es (vermelhos e amarelos);</li>
                        <li>Sorteio.</li>
                    </ol>
                    <p class="text-sm text-gray-500">&sect; 1&ordm; Havendo empate entre mais de duas equipes, o item &quot;C&quot; n&atilde;o ser&aacute; considerado.</p>
                    <p class="text-sm text-gray-500">&sect; 2&ordm; Para efeito do crit&eacute;rio de desempate do item &quot;e&quot; ser&aacute; respeitada a seguinte tabela: 1 cart&atilde;o vermelho equivale a 3 cart&otilde;es amarelos.</p>

                    <p><strong class="text-gray-900">Art. 10</strong> &mdash; Em se tratando de disputa de jogos eliminat&oacute;rios, em caso de empate no tempo normal, haver&aacute; prorroga&ccedil;&atilde;o de 10 minutos, dividida em 2 per&iacute;odos de 5 minutos cada um, sem intervalo para descanso. Persistindo o empate, a decis&atilde;o ser&aacute; por p&ecirc;naltis, cobrando-se uma s&eacute;rie de 5 (cinco) p&ecirc;naltis, alternadamente, por atletas diferentes, e persistindo o empate ser&atilde;o batidos, alternadamente, tantos p&ecirc;naltis quantos forem necess&aacute;rios para indicar o vencedor.</p>

                    <p><strong class="text-gray-900">Art. 11</strong> &mdash; Os atletas s&oacute; poder&atilde;o utilizar, para as disputas das partidas, t&ecirc;nis de solado liso.</p>

                    <p><strong class="text-gray-900">Art. 12</strong> &mdash; Cada equipe poder&aacute; inscrever at&eacute; 10 (dez) atletas.</p>

                    <p><strong class="text-gray-900">Art. 13</strong> &mdash; As dimens&otilde;es das quadras de jogos ser&atilde;o definidas de acordo com as possibilidades do local dos jogos.</p>

                    <p><strong class="text-gray-900">Art. 14</strong> &mdash; A forma de disputa do torneio ser&aacute; definida de acordo com sorteio efetuado pela comiss&atilde;o dos Jogos.</p>
                </div>
            </section>

            {{-- QUEIMADA --}}
            <section class="bg-white rounded-3xl border border-orange-200 p-8 sm:p-10 shadow-sm hover:shadow-lg hover:shadow-orange-100/40 transition-all duration-500">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-orange-700 tracking-tight mb-8 flex items-center gap-3">
                    <span class="w-1.5 h-8 bg-orange-500 rounded-full"></span>
                    QUEIMADA
                </h2>
                <div class="space-y-5 text-gray-700 leading-relaxed">

                    <p><strong class="text-gray-900">Art. 1&ordm;</strong> &mdash; Os jogos de Queimada ser&atilde;o regidos pelas disposi&ccedil;&otilde;es deste Regulamento.</p>

                    <p><strong class="text-gray-900">Art. 2&ordm;</strong> &mdash; A equipe ser&aacute; composta por um m&iacute;nimo de 08 (oito) jovens at&eacute; o n&uacute;mero total de 10 (dez) jovens.</p>
                    <ul class="list-disc pl-8 space-y-1">
                        <li>Cada equipe dever&aacute; ter pelo menos 03 (tr&ecirc;s) meninas inscritas.</li>
                    </ul>
                    <p class="text-sm text-gray-500">&sect; 1&ordm; &mdash; Para o in&iacute;cio de uma partida, as equipes dever&atilde;o estar com, no m&iacute;nimo, 06 (seis) jogadores na quadra. Em caso de in&iacute;cio com um n&uacute;mero menor de atletas, a equipe advers&aacute;ria iniciar&aacute; a partida com a pontua&ccedil;&atilde;o referente ao n&uacute;mero de atletas ausentes da outra equipe.</p>
                    <p class="text-sm text-gray-500">&sect; 2&ordm; &mdash; Caso algum atleta se apresente para a partida ap&oacute;s o seu in&iacute;cio, poder&aacute; entrar no decorrer do jogo. Por&eacute;m, a pontua&ccedil;&atilde;o para a equipe advers&aacute;ria, referente ao in&iacute;cio da partida com menos de quinze jogadores, ser&aacute; mantida.</p>
                    <p class="text-sm text-gray-500">&sect; 3&ordm; &mdash; Caso algum atleta tenha que se retirar da quadra (em casos extremos de for&ccedil;a maior), poder&aacute; ser substitu&iacute;do por outro que j&aacute; tenha sido &quot;queimado&quot;. Em caso de n&atilde;o haver nenhum atleta &quot;queimado&quot;, a sa&iacute;da de um atleta resultar&aacute; em ponto para a equipe advers&aacute;ria.</p>

                    <div class="bg-amber-50 border-l-4 border-amber-400 p-4 rounded-r-xl">
                        <p><strong class="text-gray-900">Art. 3&ordm;</strong> &mdash; A equipe que n&atilde;o comparecer ao local da competi&ccedil;&atilde;o na hora marcada ser&aacute; considerada perdedora por W x O, e o placar ser&aacute; considerado 10 x 00 (dez x zero). No caso de derrota por desist&ecirc;ncia, o placar tamb&eacute;m ser&aacute; de 10 x 00 (dez x zero) para a equipe advers&aacute;ria.</p>
                    </div>

                    <p><strong class="text-gray-900">Art. 4&ordm;</strong> &mdash; A dura&ccedil;&atilde;o de cada partida ser&aacute; de 16 (dezesseis) minutos corridos, divididos em 2 per&iacute;odos 08 (oito) minutos cada, com intervalo de 03 (tr&ecirc;s) minutos entre o primeiro e segundo per&iacute;odos.</p>
                    <p class="text-sm text-gray-500">Par&aacute;grafo &Uacute;nico &mdash; Cada equipe poder&aacute; solicitar um tempo t&eacute;cnico de 30 (trinta) segundos por per&iacute;odo.</p>

                    <p><strong class="text-gray-900">Art. 5&ordm;</strong> &mdash; O espa&ccedil;o a ser utilizado ser&aacute; a quadra de voleibol para o limite de fundo e a quadra de futsal para os limites laterais. Os atletas &quot;queimados&quot; dever&atilde;o ficar entre o limite de fundo da quadra de voleibol e o limite de fundo da quadra de futsal. Esse espa&ccedil;o ser&aacute; denominado &Aacute;rea do Cruza.</p>
                    <ul class="list-disc pl-8 space-y-1">
                        <li>&sect; 1&ordm; &mdash; As equipes dever&atilde;o come&ccedil;ar com um de seus jogadores na &Aacute;rea do Cruza. Esse jogador se dirigir&aacute; &agrave; quadra de jogo de sua equipe assim que algu&eacute;m do seu time for &quot;queimado&quot;. O jogador que come&ccedil;ar na &Aacute;rea do Cruza poder&aacute; &quot;queimar&quot; os jogadores da equipe advers&aacute;ria.</li>
                        <li>&sect; 2&ordm; &mdash; O atleta que pisar ou passar o p&eacute; pelas linhas demarcat&oacute;rias do espa&ccedil;o de jogo, em qualquer momento, perder&aacute; a posse da bola.</li>
                        <li>&sect; 3&ordm; &mdash; Quando a bola passar para fora da quadra de jogo, a posse dela ser&aacute; da equipe cujo espa&ccedil;o de jogo esteja em seu prolongamento.</li>
                    </ul>

                    <p><strong class="text-gray-900">Art. 6&ordm;</strong> &mdash; Ser&atilde;o utilizadas as bolas de voleibol ou handball.</p>

                    <p><strong class="text-gray-900">Art. 7&ordm;</strong> &mdash; Ser&aacute; considerado &quot;queimado&quot; o atleta que tiver a bola tocada em seu corpo e, posteriormente, no ch&atilde;o. A bola dever&aacute; ter sido arremessada por um jogador da equipe advers&aacute;ria.</p>
                    <ul class="list-disc pl-8 space-y-1">
                        <li>&sect; 1&ordm; &mdash; Todo arremesso na tentativa de &quot;queimar&quot; o advers&aacute;rio dever&aacute; ser efetuado de dentro da quadra de jogo.</li>
                        <li>&sect; 2&ordm; &mdash; O atleta que fizer um arremesso (em suspens&atilde;o ou n&atilde;o) e invadir a quadra advers&aacute;ria, pisando a linha demarcat&oacute;ria ou al&eacute;m dela (mesmo que a invas&atilde;o aconte&ccedil;a ap&oacute;s o jogador n&atilde;o estar mais em contato com a bola), ter&aacute; seu arremesso invalidado e a equipe perder&aacute; a posse da bola.</li>
                        <li>&sect; 3&ordm; &mdash; Ser&aacute; considerada invas&atilde;o e, consequentemente, haver&aacute; a perda da posse da bola, caso o atleta que det&eacute;m a posse da bola pise a linha divis&oacute;ria central, bem como a linha demarcat&oacute;ria da &Aacute;rea do Cruza. O arremesso, feito de seu campo e em que apenas o bra&ccedil;o do atleta ultrapassar o espa&ccedil;o a&eacute;reo da quadra advers&aacute;ria, ser&aacute; v&aacute;lido.</li>
                        <li>&sect; 4&ordm; &mdash; O atleta que sair da quadra de jogo intencionalmente para fugir de uma bola arremessada em sua dire&ccedil;&atilde;o ser&aacute; considerado &quot;queimado&quot;, mesmo que a bola n&atilde;o toque em seu corpo. Par&aacute;grafo &Uacute;nico &mdash; o atleta n&atilde;o leva a bola para o cruza quando for considerado &quot;queimado&quot; por penaliza&ccedil;&atilde;o.</li>
                        <li>&sect; 5&ordm; &mdash; Em caso de a bola tocar em dois jogadores e cair no ch&atilde;o, ser&aacute; considerado &quot;queimado&quot; o jogador no qual a bola tocou primeiro.</li>
                        <li>&sect; 6&ordm; &mdash; O jogo passivo (Ser&aacute; limitado a 5 toques passivos) e o uso de for&ccedil;a excessiva para &quot;queimar&quot; o advers&aacute;rio dever&atilde;o ser coibidos pela arbitragem, em primeira inst&acirc;ncia, com advert&ecirc;ncia verbal e, posteriormente, com a perda da posse da bola para o jogo passivo e a anula&ccedil;&atilde;o do ponto no caso de uso abusivo da for&ccedil;a na tentativa de &quot;queimar&quot; um advers&aacute;rio.</li>
                        <li>&sect; 7&ordm; &mdash; O atleta que dominar a bola dever&aacute; executar o arremesso na tentativa de &quot;queimar&quot; algum advers&aacute;rio. Ele n&atilde;o poder&aacute; passar a bola para outro jogador de sua equipe arremess&aacute;-la. Em caso de n&atilde;o cumprimento, o &aacute;rbitro dever&aacute;, em primeira inst&acirc;ncia, fazer uma advert&ecirc;ncia verbal e solicitar que a bola seja devolvida ao jogador que a tiver dominado. No caso de reincid&ecirc;ncia, o atleta que fornecer indevidamente a bola dever&aacute; ser considerado &quot;queimado&quot;.</li>
                    </ul>

                    <p><strong class="text-gray-900">Art. 8&ordm;</strong> &mdash; Vencer&aacute; a partida a equipe que &quot;queimar&quot; o maior n&uacute;mero de jogadores da equipe advers&aacute;ria no per&iacute;odo de dura&ccedil;&atilde;o da partida.</p>
                    <p class="text-sm text-gray-500">Par&aacute;grafo &Uacute;nico &mdash; Em caso de empate ap&oacute;s o aviso do &aacute;rbitro sobre o fim do tempo regulamentar, a partida ter&aacute; sequ&ecirc;ncia at&eacute; que uma das equipes &quot;queime&quot; algum jogador da equipe advers&aacute;ria.</p>
                </div>
            </section>

        </div>

        {{-- CTA --}}
        <div class="text-center mt-16 pt-10 border-t border-gray-100">
            <a href="{{ route('filament.user.auth.register') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-emerald-400 hover:from-emerald-400 hover:to-emerald-300 text-white font-bold px-10 py-4 rounded-full text-lg transition-all hover:shadow-xl hover:shadow-emerald-200/50 hover:-translate-y-0.5">
                Garantir vaga
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <p class="mt-4 text-sm text-gray-400">
                <a href="{{ url('/') }}" class="hover:text-emerald-600 transition-colors font-medium">Voltar para p&aacute;gina inicial</a>
            </p>
        </div>

    </div>

    {{-- Footer --}}
    <footer class="border-t border-gray-100 bg-white py-10">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-gray-400">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'III EJC Jogos') }} &mdash; Prado Iguatu. Todos os direitos reservados.</p>
            <div class="flex items-center gap-6">
                <a href="{{ url('/') }}" class="hover:text-emerald-600 transition-colors font-medium">In&iacute;cio</a>
                <a href="{{ route('filament.user.auth.login') }}" class="hover:text-emerald-600 transition-colors font-medium">Login</a>
            </div>
        </div>
    </footer>

</body>
</html>
