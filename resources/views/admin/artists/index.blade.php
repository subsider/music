@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex">
                        <span class="mr-auto">Artists</span>
                        <form method="GET"
                              action="{{ route('admin.artists.index', [
                              "filter['name']" => request("filter['name']"
                              )]) }}">
                            <input type="text"
                                   placeholder="Search"
                                   name="filter[name]"
                                   class="form-control form-control-sm"
                            >
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead class="text-uppercase">
                            <tr>
                                <th>Name</th>
                                <th>Mbid</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($artists as $artist)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.artists.show', $artist) }}">{{ $artist->name }}</a>
                                    </td>
                                    <td class="mbid">{{ $artist->mbid }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer pb-0">
                        {{ $artists->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
