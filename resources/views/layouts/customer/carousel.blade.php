@push('light-slider-css')
    <link rel="stylesheet" href="{{ asset('frontend/css/lightslider.min.css') }}" type="text/css" />
@endpush
{{-- <div class="container" style="margin-top: 100px; margin-bottom: 50px">
    <div id="carouselExampleAutoplaying" class="carousel slide h-50" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('frontend/images/carousel/bg1.jpg') }}" class="d-block w-100 carousel-img"
                    alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>First slide label</h5>
                    <p>Some representative placeholder content for the first slide.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('frontend/images/carousel/bg2.jpg') }}" class="d-block w-100 carousel-img"
                    alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Second slide label</h5>
                    <p>Some representative placeholder content for the second slide.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('frontend/images/carousel/bg3.jpg') }}" class="d-block w-100 carousel-img"
                    alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Third slide label</h5>
                    <p>Some representative placeholder content for the third slide.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

</div> --}}
<div class="container">
    <ul id="carousel-snacki" class="mt-3">
        <li><img src="{{ asset('frontend/images/carousel/bg1.jpg') }}" loading="lazy" alt=""></li>
        <li><img src="{{ asset('frontend/images/carousel/bg2.jpg') }}" loading="lazy" alt=""></li>
        <li><img src="{{ asset('frontend/images/carousel/bg3.jpg') }}" loading="lazy" alt=""></li>
        <li><img src="{{ asset('frontend/images/carousel/bg1.jpg') }}" loading="lazy" alt=""></li>
        <li><img src="{{ asset('frontend/images/carousel/bg2.jpg') }}" loading="lazy" alt=""></li>
        <li><img src="{{ asset('frontend/images/carousel/bg3.jpg') }}" loading="lazy" alt=""></li>
    </ul>
</div>
@push('light-slider-js')
    <script src="{{ asset('frontend/js/lightslider.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#carousel-snacki').lightSlider({
                adaptiveHeight: true,
                autoWidth: true,
                loop: true,
                pauseOnHover: true,
                onSliderLoad: function() {
                    $('#autoWidth').removeClass('cS-hidden');
                }
            });
        });
    </script>
@endpush
