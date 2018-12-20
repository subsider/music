@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex">
                        <span class="mr-auto">Charts</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead class="text-uppercase">
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Genre</th>
                                <th>Publication</th>
                                <th class="text-right">Records</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($charts as $chart)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.charts.show', $chart) }}">{{ $chart->name }}</a>
                                    </td>
                                    <td>{{ ucfirst($chart->type->name) }}</td>
                                    <td>
                                        <a href="#">{{ $chart->genre->name ?? '' }}</a>
                                    </td>
                                    <td>{{ $chart->publication->name ?? '' }}</td>
                                    <td class="text-right">{{ $chart->albums_count }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer pb-0">
                        {{ $charts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
