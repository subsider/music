<div class="card">
    <div class="card-header text-center">
        <strong>{{ $artist->name }}</strong>
    </div>
    <img class="card-img-bottom" src="{{ $artist->cover->src ?? '' }}">
    <div class="card-body"></div>
    <div class="card-footer"></div>
</div>
