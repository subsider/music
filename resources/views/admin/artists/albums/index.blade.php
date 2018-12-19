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
