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
                                <th>Album(s)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tracks as $track)
                                <tr>
                                    <td>
                                        <a href="#">{{ $track->name }}</a>
                                    </td>
                                    <td>
                                        @foreach($track->albums as $album)
                                            <a href="#">{{ $album->name }}</a>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer pb-0">
                        {{ $tracks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
