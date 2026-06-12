<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Orbitron:wght@700;900&display=swap"
        rel="stylesheet">
    <title>GameStack</title>
    <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%233b82f6'%3E%3Cpath d='M19 6H5c-2.76 0-5 2.24-5 5v3c0 2.76 2.24 5 5 5h14c2.76 0 5-2.24 5-5v-3c0-2.76-2.24-5-5-5zM9 13H7v2H6v-2H4v-1h2v-2h1v2h2v1zm7.5 1.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm3-3c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z'/%3E%3C/svg%3E">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['Orbitron', 'sans-serif'],
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>

<body class=" bg-[#0b0f19]">
    <div id="layout" class="w-full flex flex-col gap-5 justify-between items-center min-h-screen p-2">

        <nav
            class="w-full bg-slate-950/80 backdrop-blur-md border-b border-slate-900 px-6 py-4 flex flex-col gap-5 lg:grid lg:grid-cols-3 lg:items-center">
            <div class="flex justify-center lg:justify-start">
                <a href="{{ route('juegos.index') }}"
                    class="flex items-center gap-3 text-3xl md:text-4xl font-extrabold tracking-wider select-none group">
                    <i
                        class="fa-solid fa-gamepad text-blue-500 transition-transform duration-300 group-hover:rotate-12 group-hover:scale-110"></i>
                    <div class="flex font-display">
                        <span class="text-blue-500">Game</span><span class="text-white">Stack</span>
                    </div>
                </a>
            </div>

            <div class="flex items-center justify-center gap-3 flex-wrap font-sans">
                <a href="{{ route('juegos.index', array_merge(request()->query(), ['platforms' => null, 'search' => null, 'page' => 1])) }}"
                    class="whitespace-nowrap px-4 py-1 text-xs font-semibold rounded-md transition-all duration-300 {{ request('platforms') == null ? 'bg-purple-500/10 text-purple-400 border border-purple-400 shadow-[0_0_10px_rgba(168,85,247,0.2)]' : 'bg-transparent text-slate-400 border border-slate-700/80 hover:border-purple-500/60 hover:text-purple-400' }}">
                    Todas las consolas
                </a>
                @foreach ($plataformas as $plataforma)
                    @if (in_array($plataforma['id'], [1, 2, 3, 7]))
                        <a href="{{ route('juegos.index', array_merge(request()->query(), ['platforms' => $plataforma['id'], 'search' => null, 'page' => 1])) }}"
                            class="whitespace-nowrap px-4 py-1 text-xs font-semibold rounded-md transition-all duration-300 {{ request('platforms') == $plataforma['id'] ? 'bg-purple-500/10 text-purple-400 border border-purple-400 shadow-[0_0_10px_rgba(168,85,247,0.2)]' : 'bg-transparent text-slate-400 border border-slate-700/80 hover:border-purple-500/60 hover:text-purple-400' }}">
                            {{ $plataforma['name'] }}
                        </a>
                    @endif
                @endforeach
            </div>

            <div class="flex justify-center lg:justify-end w-full">
                <form action="{{ route('juegos.index') }}" method="GET" class="relative w-full max-w-xs lg:w-64">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar juegos..."
                        class="w-full cursor-pointer bg-slate-900/90 text-sm text-slate-200 placeholder-slate-500 pl-10 pr-4 py-2 rounded-lg border border-cyan-500 focus:outline-none focus:shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300">
                    <button class="absolute flex justify-center items-center left-3 top-2.5 text-slate-500"
                        type="submit">
                        <i class="fa-solid fa-magnifying-glass text-xs cursor-pointer pointer-events-none"></i>
                    </button>
                </form>
            </div>
        </nav>

        <div
            class="flex items-center justify-center gap-3 text-xs lg:text-2xl md:text-3xl font-extrabold uppercase tracking-wider select-none font-sans">
            <span class="text-cyan-400">★</span>
            <h1
                class="bg-gradient-to-r from-cyan-400 via-indigo-400 to-purple-400 bg-clip-text text-transparent drop-shadow-[0_0_15px_rgba(34,211,238,0.3)]">
                Descubre tu próxima aventura
            </h1>
            <span class="text-purple-400">★</span>
        </div>

        <div class="w-full flex flex-col items-center justify-center text-center select-none px-4">
            <p
                class="text-xs sm:text-sm md:text-base text-slate-300 font-medium tracking-wide max-w-2xl mb-6 font-sans">
                La biblioteca definitiva de los mejores títulos del gaming actual.
            </p>
            <div
                class="flex items-center justify-start md:justify-center gap-3 w-full overflow-x-auto py-2 px-1 font-sans scroll-smooth [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                <a href="{{ route('juegos.index', array_merge(request()->query(), ['genres' => null, 'search' => null, 'page' => 1])) }}"
                    class="whitespace-nowrap px-5 py-1.5 text-xs md:text-sm font-semibold rounded-full transition-all duration-300 {{ !request('genres') ? 'bg-cyan-500/10 text-cyan-400 border border-cyan-400 shadow-[0_0_12px_rgba(34,211,238,0.25)]' : 'bg-transparent text-slate-400 border border-slate-700/80 hover:border-cyan-500/60 hover:text-cyan-400 hover:bg-cyan-500/5' }}">
                    Todo
                </a>
                @foreach ($generos as $genero)
                    <a href="{{ route('juegos.index', array_merge(request()->query(), ['genres' => $genero['slug'], 'search' => null, 'page' => 1])) }}"
                        class="whitespace-nowrap px-5 py-1.5 text-xs md:text-sm font-semibold rounded-full transition-all duration-300 {{ request('genres') == $genero['slug'] ? 'bg-cyan-500/10 text-cyan-400 border border-cyan-400 shadow-[0_0_12px_rgba(34,211,238,0.25)]' : 'bg-transparent text-slate-400 border border-slate-700/80 hover:border-cyan-500/60 hover:text-cyan-400 hover:bg-cyan-500/5' }}">
                        {{ $genero['name'] }}
                    </a>
                @endforeach
            </div>
        </div>

        <section id="games" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 px-4 w-full max-w-7xl">
            @foreach ($results as $juego)
                <article
                    class="w-full max-w-sm mx-auto group relative border rounded-xl border-slate-800 backdrop-blur-md hover:-translate-y-2 transition-all duration-300 ease-out hover:border-cyan-500 hover:shadow-[0_0_25px_rgba(6,182,212,0.45)] cursor-pointer">
                    <div class="w-full h-48 overflow-hidden rounded-t-xl">
                        <img class="w-full h-full object-cover rounded-t-xl transition-transform duration-500 ease-out group-hover:scale-105"
                            src="{{ $juego['background_image'] ?? 'https://via.placeholder.com/400x200' }}"
                            alt="{{ $juego['slug'] }}">
                    </div>
                    <div class="w-full mt-4 text-left p-4">
                        <p
                            class="text-lg font-bold text-slate-100 tracking-wide transition-colors duration-300 group-hover:text-cyan-400 line-clamp-1">
                            {{ $juego['name'] }}
                        </p>
                        <div class="flex items-center justify-between mt-4 pt-3 border-t border-slate-800/60">
                            <span class="text-yellow-400 text-sm font-semibold flex items-center gap-1">
                                ⭐ {{ $juego['rating'] ?? '4.5' }}
                            </span>
                            <a href="{{ route('juegos.show', $juego['slug']) }}"
                                class="text-xs font-bold uppercase tracking-wider text-cyan-400 bg-cyan-950/40 border border-cyan-800/50 px-3 py-1.5 rounded-md transition-all duration-300 group-hover:bg-cyan-500 group-hover:text-black group-hover:shadow-[0_0_10px_rgba(6,182,212,0.4)]">
                                Ver más
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </section>

        <div class="w-full p-6 flex justify-center gap-5 mt-4">
            @if ($paginaActual > 1)
                <a class="bg-gradient-to-r from-violet-600 to-cyan-500 text-white font-bold py-3 px-8 rounded-lg transition-all duration-300 hover:scale-105 hover:shadow-[0_0_25px_rgba(6,182,212,0.7)]"
                    href="{{ route('juegos.index', array_merge(request()->query(), ['page' => $paginaActual - 1])) }}">
                    Anterior
                </a>
            @endif
            <a class="bg-gradient-to-r from-violet-600 to-cyan-500 text-white font-bold py-3 px-8 rounded-lg transition-all duration-300 hover:scale-105 hover:shadow-[0_0_25px_rgba(6,182,212,0.7)]"
                href="{{ route('juegos.index', array_merge(request()->query(), ['page' => $paginaActual + 1])) }}">
                Siguiente
            </a>
        </div>

    </div>
</body>

</html>
