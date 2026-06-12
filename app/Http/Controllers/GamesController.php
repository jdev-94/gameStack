<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// -----------------------------------------------------------------
// PUNTO 1: IMPORTAR EL CLIENTE HTTP
// Aquí le avisamos a Laravel que usaremos su "teléfono" para llamadas web.
// -----------------------------------------------------------------
use Illuminate\Support\Facades\Http;
use App\Services\RawgService; //Importamos el servcio donde manejamos la lógica.


class GamesController extends Controller
{
    protected $rawgService;

    //Indicamos a Laravel que se inyecte automáticamente el servicio en el controlador.
    public function __construct(RawgService $rawgService)
    {
        $this->rawgService = $rawgService;
    }

    /**
     * Método principal que muestra todo la información de la landing
     */
    public function index(Request $request)
    {
        //1. Capturamos la página actual para mandarla a la vista.
        $paginaActual = $request->input('page', 1);

        //2. Le pedimos los juegos al servicio paándole los inputs.
        $results = $this->rawgService->getGames($request->all());

        //3. Pedimos las plataformas a la api
        $plataformas = $this->rawgService->getPlatforms();

        //4. Le pedimos al servicio los géneros para la barra de filtros.
        $generos = $this->rawgService->getGenres();

        //5. Si falla la petición de juegos, manejamos el error.
        if (!filled($results) && $paginaActual > 1) {
            return back()->with('error', 'No se pudieron obtener más datos');
        }

        //5.Retornamos la vista.
        return view('juegos.index', compact('results', 'paginaActual', 'generos', 'plataformas'));
    }

    /**
     * Método con el que sacamos la información de un juego.
     * $slug->ID juego
     */
    public function show($slug)
    {
        //Llamamos al servicio para traer los datos de este juego.
        $juego = $this->rawgService->getGameDetails($slug);

        //Controlamos si la API devuelve el juego. Si no, abortamos con 404.
        if (!$juego) {
            abort(404, 'Videojuego no encontrado');
        }

        //Pedimos al servicio el nombre de la tiendas globales que tiene la api para la venta de videojuegos.
        $tiendasGlobales = $this->rawgService->getStores();

        //Cogemos el id y el nombre de cada tienda. Con array_column nos ahorramos un foreach
        $idTiendasGlobales = array_column($tiendasGlobales, 'name', 'id');

        //Cogemos el id y la url del logo de la tienda
        $tiendasGlobalesImg = array_column($tiendasGlobales, 'image_background', 'id');

        //Pedimos al servicio el id y url de las tiendas en las que podemos comprar el juego seleccionado.
        $tiendas = $this->rawgService->getGameStores($slug);
        $infoTienda = [];


        foreach ($tiendas as $tienda) {
            $id = $tienda['store_id'];

            $infoTienda[] = [
                'name' => $idTiendasGlobales[$id] ?? 'Tienda Oficial',
                'img' => $tiendasGlobalesImg[$id] ?? 'Img Oficial',
                'url' => $tienda['url'],
            ];
        }

        //Pedimos todas las capturas de pantalla
        $todasLasCapturas = $this->rawgService->getGameScreenshots($slug);

        //Cortamos el array, nos quedamos con un máximo de 4 capturas de pantalla.
        $capturas = array_slice($todasLasCapturas, 0, 4);

        //Mandamos datos a la vista
        return view('juegos.show', compact('juego', 'capturas', 'tiendas', 'infoTienda'));
    }
}
