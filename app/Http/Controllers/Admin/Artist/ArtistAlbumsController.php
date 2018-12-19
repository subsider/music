<?php

namespace App\Http\Controllers\Admin\Artist;

use App\Models\Music\Artist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArtistAlbumsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Artist $artist
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(Artist $artist)
    {
        $albums = $artist->albums()
            ->with('type')
            ->latest('release_date')
            ->paginate();

        return view('admin.artists.albums.index', [
            'artist' => $artist,
            'albums' => $albums,
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
