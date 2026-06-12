<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Orbitron:wght@700;900&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <title>{{ $juego['name'] }}</title>

    @if (!empty($juego['background_image']))
        <link rel="icon" type="image/jpeg" href="{{ $juego['background_image'] }}">
    @endif
</head>

<body>

    <div class="relative min-h-screen bg-slate-950 text-slate-100 font-sans overflow-x-hidden">

        <div class="absolute top-0 left-0 w-full h-[60vh] md:h-[80vh] z-0 overflow-hidden">
            <img src="{{ $juego['background_image'] ?? 'https://via.placeholder.com/1920x1080' }}"
                alt="{{ $juego['slug'] }}" class="w-full h-full object-cover object-top opacity-35 blur-[2px]">
            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-slate-950/60 to-slate-950"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 pt-32 pb-16 md:px-8">

            <div class="mb-6">
                <a href="{{ route('juegos.index') }}"
                    class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400 hover:text-cyan-400 transition-colors duration-300">
                    <i class="fa-solid fa-arrow-left"></i> Volver al catálogo
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 md:gap-12">

                <div class="lg:col-span-2 flex flex-col gap-8">

                    <h1
                        class="text-3xl md:text-5xl lg:text-6xl font-extrabold tracking-tight font-display bg-gradient-to-r from-white via-slate-200 to-slate-400 bg-clip-text text-transparent drop-shadow">
                        {{ $juego['name'] }}
                    </h1>

                    <div class="flex flex-col gap-3">
                        <div
                            class="w-full aspect-video rounded-2xl overflow-hidden border border-slate-800 shadow-2xl shadow-cyan-500/5">
                            <img id="main-gallery-img"
                                src="{{ $juego['background_image'] ?? 'https://via.placeholder.com/800x450' }}"
                                alt="{{ $juego['name'] }}" class="w-full h-full object-cover">
                        </div>

                        @if (count($capturas) > 0)
                            <div
                                class="flex gap-3 overflow-x-auto pb-2 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                                @foreach ($capturas as $captura)
                                    <img onclick="changeImage(this.src, event)" src="{{ $captura['image'] }}"
                                        class="w-24 md:w-32 aspect-video object-cover rounded-lg border-2 {{ $loop->first ? 'border-cyan-500' : 'border-slate-800' }} cursor-pointer hover:opacity-80 transition thumbnail">
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="bg-slate-900/60 backdrop-blur-md border border-slate-900 p-6 md:p-8 rounded-2xl">
                        <h2 class="text-xl md:text-2xl font-bold font-display text-cyan-400 mb-4">Acerca del juego</h2>
                        <div class="text-sm md:text-base text-slate-300 leading-relaxed space-y-4">
                            {!! nl2br(e($juego['description_raw'] ?? 'No hay descripción disponible para este título.')) !!}
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-6 lg:h-fit lg:sticky lg:top-24">
                    <div class="bg-slate-900/80 backdrop-blur-md border border-slate-800/60 p-6 rounded-2xl shadow-xl">

                        <div class="mb-6">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3 font-display">
                                Disponible en</h3>
                            <div class="flex flex-wrap gap-2">
                                @if (isset($juego['platforms']) && is_array($juego['platforms']))
                                    @foreach ($juego['platforms'] as $plataforma)
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-md bg-slate-800 text-slate-200 border border-slate-700">
                                            {{ $plataforma['platform']['name'] }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="text-xs text-slate-500 italic">No especificadas</span>
                                @endif
                            </div>
                        </div>

                        @if (!empty($juego['website']))
                            <hr class="border-slate-800/80 my-4">
                            <div class="mb-6">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2 font-display">
                                    Sitio Web Oficial</h3>
                                <a href="{{ $juego['website'] }}" target="_blank" rel="noopener noreferrer"
                                    class="inline-flex items-center gap-2 text-sm text-cyan-400 hover:text-cyan-300 transition group break-all">
                                    {{ $juego['website'] }}
                                    <i
                                        class="fa-solid fa-arrow-up-right-from-square text-xs transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5"></i>
                                </a>
                            </div>
                        @endif

                        <hr class="border-slate-800/80 my-4">
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3 font-display">
                                Adquirir en</h3>
                            <div class="flex flex-col gap-2.5">
                                @if (count($infoTienda) > 0)
                                    @foreach ($infoTienda as $tienda)
                                        <a href="{{ $tienda['url'] }}" target="_blank" rel="noopener noreferrer"
                                            class="flex items-center justify-between px-4 py-2.5 bg-slate-950 border border-slate-800 hover:border-cyan-500/50 rounded-xl transition group text-sm font-medium">
                                            <span class="flex items-center gap-2 text-slate-300 group-hover:text-white">
                                                {{ $tienda['name'] }}
                                            </span>
                                            <i
                                                class="fa-solid fa-chevron-right text-xs text-slate-600 group-hover:text-cyan-400 transition-transform group-hover:translate-x-0.5"></i>
                                        </a>
                                    @endforeach
                                @else
                                    <p class="text-xs text-slate-500 italic py-2">No hay enlaces de tiendas disponibles.
                                    </p>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function changeImage(src, event) {
            const mainImg = document.getElementById('main-gallery-img');
            mainImg.src = src;

            // Limpia bordes de todas las miniaturas y enciende la clickeada
            const thumbnails = document.querySelectorAll('.thumbnail');
            thumbnails.forEach(thumb => {
                thumb.classList.remove('border-cyan-500');
                thumb.classList.add('border-slate-800');
            });

            event.currentTarget.classList.remove('border-slate-800');
            event.currentTarget.classList.add('border-cyan-500');
        }
    </script>
</body>

</html>
