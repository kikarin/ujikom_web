@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Welcome Banner with Animated Text -->
    <div class="welcome-banner text-center mb-5 p-4 rounded shadow-lg">
        <h2 class="text-white mb-2">Welcome to SMKN 4 Kota Bogor Gallery</h2>
        <div class="logo-animation mb-3">
            <img src="{{ asset('images/LOGO.png') }}" alt="Logo" height="100">
        </div>
        <p class="animated-text text-white">Discover the best moments captured by our school.</p>

             <!-- Social Media Icons -->
     <div class="social-icons d-flex justify-content-center mt-4">
        <a href="https://web.facebook.com/people/SMK-NEGERI-4-KOTA-BOGOR/100054636630766/" target="_blank" class="social-icon text-white mx-2">
            <i class="fab fa-facebook fa-2x"></i>
        </a>
        <a href="https://www.instagram.com/smkn4kotabogor/" target="_blank" class="social-icon text-white mx-2">
            <i class="fab fa-instagram fa-2x"></i>
        </a>
        <a href="https://www.youtube.com/channel/UC4M-6Oc1ZvECz00MlMa4v_A/videos?reload=9&app=desktop" target="_blank" class="social-icon text-white mx-2">
            <i class="fab fa-youtube fa-2x"></i>
        </a>
        <a href="https://api.whatsapp.com/send/?phone=6282260168886" target="_blank" class="social-icon text-white mx-2">
            <i class="fab fa-whatsapp fa-2x"></i>
        </a>
    </div>
    </div>



    <!-- Carousel Section with Shadow Effect -->
    <div class="mb-5">
        <div id="carouselExampleIndicators" class="carousel slide shadow-lg rounded carousel-small" data-bs-ride="carousel">
            <div class="carousel-indicators custom-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4"></button>
            </div>
            <div class="carousel-inner rounded">
                @foreach($photos->take(5) as $index => $photo)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                <img src="{{ $photo->full_image_url }}" 
     class="d-block w-100 carousel-image" 
     alt="{{ $photo->title ?? 'Photo Slide' }}" 
     loading="lazy">


                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- News Ticker with Smooth Animation and Icon -->
    <div class="news-ticker-container mb-5 shadow-lg rounded">
        <div class="d-flex align-items-center ticker-content">
            <div class="ticker-icon bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                <i class="fas fa-newspaper fa-2x"></i>
            </div>
            <h4 class="text-white mb-0 flex-grow-1" id="newsTickerText">
                Stay tuned for the latest updates on our school gallery!
            </h4>
        </div>
    </div>


    <!-- Content Sections (Gallery, Info, Agenda) with Hover Effects -->
    <div class="content-sections">
        <!-- Gallery Section -->
        <div class="section mb-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="text-primary">Gallery</h4>
                <a href="{{ route('gallery.index') }}" class="btn btn-link">View All</a>
            </div>
            <div class="row">
                @foreach($galleryItems as $item)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card gallery-card shadow-sm h-100">
                        <div class="image-wrapper">
                            <img src="{{ $item->photos[0]->full_image_url ?? asset('images/placeholder.jpg') }}"
                                class="card-img-top"
                                alt="Gallery Image">
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $item->title }}</h5>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>


        <!-- Info Section -->
        <div class="section mb-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="text-primary">Info</h4>
                <a href="{{ route('info.index') }}" class="btn btn-link">View All</a>
            </div>
            <div class="row">
                @foreach($infoItems as $item)
                <div class="col-md-6 mb-3">
                    <div class="card info-card p-4 shadow-sm">
                        <h5 class="card-title">{{ $item->title }}</h5>
                        <p class="card-text">{{ Str::limit($item->content, 100) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Agenda Section -->
        <div class="section">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="text-primary">Agenda</h4>
                <a href="{{ route('agenda.index') }}" class="btn btn-link">View All</a>
            </div>
            <div class="row">
                @foreach($agendaItems as $item)
                <div class="col-md-6 mb-3">
                    <div class="card agenda-card p-4 shadow-sm">
                        <h5 class="card-title">{{ $item->title }}</h5>
                        <p class="card-text">{{ Str::limit($item->description, 100) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Google Maps Section -->
<div class="maps-section mt-5">
    <h4 class="text-primary text-center mb-4">Find Us on Google Maps</h4>
    <div class="maps-container shadow-lg rounded overflow-hidden">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d31704.398742240563!2d106.824694!3d-6.640733000000001!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c8b16ee07ef5%3A0x14ab253dd267de49!2sSMK%20Negeri%204%20Bogor%20(Nebrazka)!5e0!3m2!1sid!2sid!4v1731673473768!5m2!1sid!2sid"
            width="100%"
            height="450"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</div>
</div>

<!-- Custom Styles -->
<style>

.social-icons a {
        transition: color 0.3s, transform 0.3s;
    }

    .social-icons a:hover {
        transform: scale(1.2); /* Perbesar ikon saat hover */
    }
    .news-ticker-container {
        background: linear-gradient(135deg, #446496, #88A5DB);
        padding: 15px 20px;
        border-radius: 15px;
        overflow: hidden;
        position: relative;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    /* Icon Styling */
    .ticker-icon {
        width: 60px;
        height: 60px;
        background: #ffffff;
        color: #446496;
        font-size: 24px;
        box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.15);
        flex-shrink: 0;
    }

    /* Ticker Text Animation */
    #newsTickerText {
        font-size: 1.2rem;
        font-weight: 600;
        color: #ffffff;
        animation: fadeInOut 6s linear infinite;
        /* Smooth animation between messages */
    }

    /* Fade In and Out Keyframes */
    @keyframes fadeInOut {

        0%,
        20% {
            opacity: 0;
            transform: translateY(20px);
        }

        20%,
        80% {
            opacity: 1;
            transform: translateY(0);
        }

        80%,
        100% {
            opacity: 0;
            transform: translateY(-20px);
        }
    }

    /* Responsive Styling */
    @media (max-width: 768px) {
        #newsTickerText {
            font-size: 1rem;
        }

        .ticker-icon {
            width: 50px;
            height: 50px;
            font-size: 20px;
        }
    }

    .custom-indicators button {
        width: 15px;
        height: 15px;
        margin: 0 5px;
        border: none;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        transition: background 0.3s ease, transform 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .custom-indicators button.active {
        background: #88A5DB;
        /* Highlight color for the active button */
        transform: scale(1.2);
        /* Slight enlargement for the active button */
        box-shadow: 0 4px 10px rgba(136, 165, 219, 0.6);
        /* Add glow effect */
    }

    .custom-indicators button:hover {
        background: #446496;
        /* Darker color on hover */
        transform: scale(1.2);
        /* Slight enlargement on hover */
        cursor: pointer;
    }

    .carousel-small {
        max-width: 800px;
        /* Adjust the width as needed */
        margin: 0 auto;
        /* Center the carousel */
    }

    .carousel-image {
        height: 300px;
        /* Set the height to make the carousel smaller */
        object-fit: cover;
        /* Cover the area while maintaining aspect ratio */
        object-position: center;
        /* Center the image */
    }

    /* Adjust indicator position if the carousel is smaller */
    .carousel-indicators {
        bottom: 10px;
        /* Move indicators closer if the carousel height is reduced */
    }

    @media (max-width: 768px) {
        .carousel-image {
            height: 200px;
            /* Smaller height for mobile devices */
        }
    }

    /* Welcome Banner Styling */
    .welcome-banner {
        background: linear-gradient(135deg, #446496, #88A5DB);
        color: white;
        border-radius: 15px;
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
    }

    .logo-animation img {
        animation: scaleUp 2s ease-in-out forwards;
    }

    .animated-text {
        font-size: 1.2rem;
        animation: fadeIn 2s ease-in-out;
    }

    @keyframes scaleUp {
        from {
            transform: scale(0);
        }

        to {
            transform: scale(1);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    /* Carousel Styling */
    .carousel-inner img {
        border-radius: 15px;
        transition: transform 0.5s ease;
    }

    .carousel-inner img:hover {
        transform: scale(1.05);
    }

    /* News Ticker Styling */
    .news-ticker {
        background: linear-gradient(135deg, #3c4c67, #4c6b8a);
        color: white;
        font-weight: bold;
        border-radius: 10px;
    }

    #newsTickerText {
    color: #e2e2e2; /* Lighter text color */
}

    .gallery-card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        border-radius: 15px;
        overflow: hidden;
        /* Ensure content does not overflow */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .gallery-card:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}


    /* Image Wrapper for Fixed Aspect Ratio */
    .image-wrapper {
        width: 100%;
        aspect-ratio: 4 / 3;
        /* 4:3 aspect ratio */
        overflow: hidden;
        /* Hide parts of the image that overflow */
        display: flex;
        justify-content: center;
        align-items: center;
        background: #f8f9fa;
        /* Light background as a fallback */
    }

    /* Card Body */
    .card-body {
        padding: 15px;
        background-color: #fff;
        text-align: center;
        border-top: 1px solid #f0f0f0;
    }

    /* Card Title Styling */
    .card-title {
        font-size: 1rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 0;
        transition: color 0.3s ease;
    }

    .card-title:hover {
        color: #446496;
    }

    /* Responsive Adjustments */
    @media (max-width: 576px) {
    .gallery-card, .info-card, .agenda-card {
        flex-direction: column;
        margin-bottom: 15px;
    }
}


    /* Image Styling */
    .image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Ensures the image fills the area without stretching */
    }

    /* Gallery, Info, Agenda Cards Styling */
    .gallery-card,
    .info-card,
    .agenda-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 15px;
    }

    .gallery-card:hover,
    .info-card:hover,
    .agenda-card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
    }

    .gallery-card img,
    .info-card img,
    .agenda-card img {
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    /* Button Links */
    .btn-link {
        color: #446496;
        text-decoration: none;
    }

    .btn-link:hover {
        color: #88A5DB;
        transform: translateY(-3px);    }

    .btn-link, .card-title {
    transition: color 0.3s ease, transform 0.3s ease;
}

    /* Google Maps Section */
    .maps-section {
        margin-top: 50px;
        padding: 20px;
        background: linear-gradient(135deg, #EBF1F6, #ffffff);
        border-radius: 15px;
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
    }

    .maps-section h4 {
        font-weight: bold;
        color: #446496;
    }

    .maps-container {
        border-radius: 15px;
        overflow: hidden;
        /* Ensures no overflow from the iframe */
        background-color: #f8f9fa;
        border: 1px solid #ddd;
    }
</style>

<!-- JavaScript for Interactive Effects -->
<script>
    // News Ticker Animation
    document.addEventListener('DOMContentLoaded', function() {
        const newsTexts = [
            "Explore our School Gallery!",
            "Check out the latest updates on our Gallery!",
            "Want to join? Just log in!",
            "Discover amazing moments captured by our students!",
            "Stay connected for more exciting updates!"
        ];

        const tickerText = document.getElementById('newsTickerText');
        let currentIndex = 0;

        setInterval(() => {
            tickerText.textContent = newsTexts[currentIndex];
            currentIndex = (currentIndex + 1) % newsTexts.length;
        }, 6000); // Change text every 6 seconds
    });
</script>
@endsection