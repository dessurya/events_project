<div id="carouselRunningText" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        @foreach($texts as $text)
        <div class="carousel-item">
            <div class="d-block w-100 text-center bg-secondary text-white">
                <label>{{ $text->text }}</label>
            </div>
        </div>
        @endforeach
    </div>
</div>