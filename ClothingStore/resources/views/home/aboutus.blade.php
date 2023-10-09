<!DOCTYPE html>
<html lang="en">

<head>
    @include('home.css_js') 
    <style>
        /* Style for the Facebook link */
.facebook-link {
    margin-top: 20px;
    margin-bottom: 20px;
    text-align: center;
}

/* Style for the Facebook logo */
.facebook-link img {
    vertical-align: middle;
    margin-right: 10px; /* Add spacing between the logo and text */
}

/* Style for the Facebook link text */
.facebook-link a {
    text-decoration: none;
    color: #333; /* Change the color as needed */
    font-size: 18px;
    font-weight: bold;
    display: inline-block;
}

/* Hover effect for the Facebook link */
.facebook-link a:hover {
    color: #1877f2; /* Change to the Facebook brand color or your preferred color */
}
.about-us{
    margin-top: 40px;
}

    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    @include('home.header')
    <!-- Header Section End -->
  

    <section class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="about-us">
                        <h2 style="margin-bottom:20px;">Welcome to Amity Collection</h2>
                        <p>Amity Collection is a US-based distributor of Women's Apparel and accessories. We are a
                            dedicated manufacturer and wholesale apparel and accessories company, bringing together
                            timeless artisan craftwork and on-trend fashion design for our customers in America and
                            around the world.</p>

                        <p>Each piece sold under The Amity Collection brand is genuinely artisan-made, reflecting our
                            commitment to quality and craftsmanship. We offer a wide range of women's apparel, including
                            Jackets, Dresses, Tops, Skirts, Trousers, and a variety of Accessories.</p>

                        <p>When you shop at Amity Collection, you're not only getting high-quality fashion but also
                            supporting the employment of women in Nepal, contributing to a brighter future for
                            communities around the world.</p>
                        <div class="facebook-link">
                            <a href="https://www.facebook.com/profile.php?id=100071366924285&mibextid=2JQ9oc" target="_blank">
                                <i class="fab fa-facebook-square"></i> Follow us on Facebook
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('home.instagram')
    <!-- Main Content Section End -->

    <!-- Footer Section Begin -->
    @include('home.footer')
    <!-- Footer Section End -->

    <!-- Search Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search End -->

    <!-- Js Plugins -->
    <script src="{{asset('home/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('home/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('home/js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('home/js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('home/js/mixitup.min.js')}}"></script>
    <script src="{{asset('home/js/jquery.countdown.min.js')}}"></script>
    <script src="{{asset('home/js/jquery.slicknav.js')}}"></script>
    <script src="{{asset('home/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('home/js/jquery.nicescroll.min.js')}}"></script>
    <script src="{{asset('home/js/main.js')}}"></script>
</body>

</html>
