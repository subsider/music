@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex">
                        <span class="mr-auto">{{ $chart->name }}</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead class="text-uppercase">
                            <tr>
                                <th>Rank</th>
                                <th>Artist</th>
                                <th>Album</th>
                                <th>Year</th>
                                <th>Score</th>
                                <th>Genres</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($albums as $album)
                                <tr>
                                    <td>{{ $album->pivot->rank }}</td>
                                    <td>
                                        @foreach ($album->artists as $artist)
                                            <a href="{{ route('admin.artists.show', $artist) }}">{{ $artist->name }}</a>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="#">{{ $album->name }}</a>
                                    </td>
                                    <td>{{ $album->year }}</td>
                                    <td>{{ $album->pivot->score }}</td>
                                    <td>
                                        @foreach($album->genres as $genre)
                                            <a href="#">{{ $genre->name }}</a>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
