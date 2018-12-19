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
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($relatedArtists as $related)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.artists.show', $related) }}"
                                        >{{ $related->name }}</a>
                                    </td>
                                    <td class="mbid">{{ $related->mbid }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer pb-0">
                        {{ $relatedArtists->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
