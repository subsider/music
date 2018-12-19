<?php

namespace App\Http\Controllers\Admin\Artist;

use App\Models\Music\Artist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArtistRelatedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Artist $artist
     * @return \Illuminate\Http\Response
     */
    public function index(Artist $artist)
    {
        $related = $artist->related()
            ->with('artist.cover')
            ->get()
            ->pluck('artist')
            ->paginate();

        return view('admin.artists.related.index', [
            'artist' => $artist,
            'relatedArtists' => $related,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
