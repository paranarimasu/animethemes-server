<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SeriesCollection;
use App\Http\Resources\SeriesResource;
use App\Models\Series;

class SeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/series/",
     *     operationId="getSerie",
     *     tags={"Series"},
     *     summary="Get paginated listing of Series",
     *     description="Returns listing of Series",
     *     @OA\Response(
     *         response=200,
     *         description="Successful",
     *         @OA\JsonContent(@OA\Property(property="series",type="array", @OA\Items(ref="#/components/schemas/SeriesResource")))
     *     )
     * )
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new SeriesCollection(Series::with('anime', 'anime.synonyms', 'anime.themes', 'anime.themes.entries', 'anime.themes.entries.videos', 'anime.themes.song', 'anime.themes.song.artists', 'anime.externalResources')->paginate());
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/series/{alias}",
     *     operationId="getSeries",
     *     tags={"Series"},
     *     summary="Get properties of Series",
     *     description="Returns properties of Series",
     *     @OA\Response(
     *         response=200,
     *         description="Successful",
     *         @OA\JsonContent(ref="#/components/schemas/SeriesResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource Not Found!"
     *     )
     * )
     *
     * @param  \App\Models\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function show(Series $series)
    {
        return new SeriesResource($series->load('anime', 'anime.synonyms', 'anime.themes', 'anime.themes.entries', 'anime.themes.entries.videos', 'anime.themes.song', 'anime.themes.song.artists', 'anime.externalResources'));
    }
}