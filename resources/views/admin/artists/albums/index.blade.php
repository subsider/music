@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                @include('admin.artists._card')
            </div>
            <div class="col-md-9">
                <div class="card">
                    @include('admin.artists._tabs')
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead class="text-uppercase">
                            <tr>
                                <th>Name</th>
                                <th>Mbid</th>
                                <th class="text-nowrap">Release Date</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($albums as $album)
                                <tr>
                                    <td>
                                        <a href="#">{{ $album->name }}</a>
                                    </td>
                                    <td class="mbid">{{ $album->mbid }}</td>
                                    <td>{{ $album->year ?? '' }}</td>
                                    <th>
                                        @auth
                                            @if(!$album->liked)
                                                <form action="{{ route('admin.albums.like', $album) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-primary">Like</button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.albums.unlike', $album) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-primary">Unlike</button>
                                                </form>
                                            @endif
                                        @endauth
                                    </th>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer pb-0">
                        {{ $albums->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
