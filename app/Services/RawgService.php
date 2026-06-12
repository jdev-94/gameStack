<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RawgService
{
    protected $apiKey; //Protegemos nuestra apiKey
    protected $baseUrl = 'https://api.rawg.io/api'; //Protegemos la url a la que hacemos las peticiones

    //El constructor se trae la clave secreta del .env al nacer el servicio.
    public function __construct()
    {
        $this->apiKey = config('services.rawg.key');
    }

    //Método que se encarga de buscar, filtrar y poginar Juegos
    public function getGames($datos)
    {
        $termino = $datos['search'] ?? null;
        $generoSeleccionado = $datos['genres'] ?? null;
        $plataformaSeleccionada = $datos['platforms'] ?? null;
        $parametrosDeBusqueda = [];
        $paginaActual = $datos['page'] ?? 1;

        if (filled($termino)) {
            $parametrosDeBusqueda = [
                'key' => $this->apiKey,
                'search' => $termino,
                'ordering' => '-rating',
                'page_size' => 6,
                'page' => $paginaActual,
                'search_exact' => true,
            ];
        } else {
            $parametrosDeBusqueda = [
                'key' => $this->apiKey,
                'page_size' => 6,
                'page' => $paginaActual,
                'ordering' => '-rating'
            ];
        }

        if ($plataformaSeleccionada) {
            $parametrosDeBusqueda['parent_platforms'] = $plataformaSeleccionada;
        }

        if ($generoSeleccionado) {
            $parametrosDeBusqueda['genres'] = $generoSeleccionado;
        }

        $respuesta = Http::withHeaders([
            'User-Agent' => 'GameStack'
        ])->get("{$this->baseUrl}/games", $parametrosDeBusqueda);


        if ($respuesta->successful()) {
            return $respuesta->json()['results'];
        }

        return []; //Si falla devolvemos un array vacío
    }
    //Método para filtrar por plataformasPadre (XBOX, NINTENDO, PC, PS).
    public function getPlatforms()
    {
        $respuesta = Http::withHeaders([
            'User-Agent' => 'GameStack',
        ])->get("{$this->baseUrl}/platforms/lists/parents", ['key' => $this->apiKey]);

        if ($respuesta->successful()) {
            return $respuesta->json()['results'];
        }
        return [];
    }

    //Método para filtrar juegos por género en la API
    public function getGenres()
    {
        $respuesta = Http::withHeaders([
            'User-Agent' => 'GameStack'
        ])->get("{$this->baseUrl}/genres", ['key' => $this->apiKey]);

        if ($respuesta->successful()) {
            $generos = $respuesta->json()['results'];

            //Comparamos el games_count de cada género
            //Usamos ($b - $a) para ordenar de MAYOR a MENOR
            usort($generos, function ($a, $b) {
                return $b['games_count'] <=> $a['games_count'];
            });

            //Nos quedamos estrictamente con los 6 géneros que más juegos/usuarios tienen
            return array_slice($generos, 0, 6);
        }

        return [];
    }

    //Método que obtiene todos los detalles de un juego
    public function getGameDetails($slug)
    {
        $respuesta = Http::withHeaders([
            'User-Agent' => 'GameStack'
        ])->get("{$this->baseUrl}/games/{$slug}", [
            'key' => $this->apiKey,
            'lang' => 'es'
        ]);

        if ($respuesta->successful()) {

            return $respuesta->json(); //Devuelve un único Array con todos los detalles del juego
        }

        return null; //Si no lo encuentra o falla devolvemos null
    }

    /**
     * Método que extrae los screenShots (capturas de pantalla) de un juego.
     */
    public function getGameScreenshots($slug)
    {
        $respuesta = Http::withHeaders([
            'User-Agent' => 'GameStack',
        ])->get("{$this->baseUrl}/games/{$slug}/screenshots", ['key' => $this->apiKey]);

        if ($respuesta->successful()) {
            return $respuesta->json()['results'];
        }
        return [];
    }

    public function getStores()
    {
        $respuesta = Http::withHeaders([
            'User-Agent' => 'GameStack'
        ])->get("{$this->baseUrl}/stores", ['key' => $this->apiKey]);

        if ($respuesta->successful()) {
            return $respuesta->json()['results'];
        }

        return [];
    }


    /**
     * Método que nos trae los sitios donde podemos comprar el juego
     */
    public function getGameStores($slug)
    {
        $respuesta = Http::withHeaders([
            'User-Agent' => 'GameStack'
        ])->get("{$this->baseUrl}/games/{$slug}/stores", ['key' => $this->apiKey]);

        if ($respuesta->successful()) {
            return $respuesta->json()['results'];
        }

        return [];
    }
}
