@if(count($texts) > 0)
<marquee direction="left" class="bg-dark text-white">
    @foreach($texts as $key => $text)
        @if($key > 0) <label style="width:72.5vw"></label> @endif
        {{ $text->text }}
    @endforeach
</marquee>
<?php
// <div id="carouselRunningText" class="carousel slide" data-ride="carousel">
//     <div class="carousel-inner">
//         @foreach($texts as $text)
//         <div class="carousel-item">
//             <div class="d-block w-100 text-center bg-secondary text-white">
//                 <label>{{ $text->text }}</label>
//             </div>
//         </div>
//         @endforeach
//     </div>
// </div>
?>
@endif