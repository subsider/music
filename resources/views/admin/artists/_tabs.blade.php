<div class="card-header">
    <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="#">Overview</a>
        </li>
        <li class="nav-item">
            <a class="nav-link"
               href="{{ route('admin.artists.albums.index', $artist) }}"
            >Albums</a>
        </li>
        <li class="nav-item">
            <a class="nav-link"
               href="{{ route('admin.artists.tracks.index', $artist) }}"
            >Tracks</a>
        </li>
        <li class="nav-item">
            <a class="nav-link"
               href="{{ route('admin.artists.related.index', $artist) }}"
            >Related</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Events</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Tags</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Images</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Bio</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Charts</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Fans</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Services</a>
        </li>
    </ul>
</div>
