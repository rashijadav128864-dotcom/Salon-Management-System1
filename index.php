<?php
include 'includes/database.php';
?>

<!DOCTYPE html>
<!--
    HOME PAGE - Salon Management System
    This is a pure HTML/Bootstrap page (no PHP logic yet).
    It uses Bootstrap 5 for the responsive grid/navbar, our own
    style.css for the luxury pink & gold theme, and script.js
    for small interactive touches (scroll effects, testimonial slider).
-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloom & Gold Salon | Luxury Beauty & Hair Studio</title>

    <!-- Bootstrap 5 CSS via CDN: gives us the responsive grid, navbar, and buttons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons via CDN: used for social media icons and small UI icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Google Fonts: Playfair Display (elegant headings) + Jost (clean body text) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700;800&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Our own custom stylesheet - loaded AFTER Bootstrap so our styles can override it -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- =====================================================
         NAVIGATION BAR
         Bootstrap's navbar classes handle the responsive
         "hamburger menu" behavior on small screens automatically.
    ====================================================== -->
    <nav class="navbar navbar-expand-lg fixed-top" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <span class="brand-mark">Bloom<span class="brand-amp">&amp;</span>Gold</span>
            </a>

            <!-- This button only appears on small screens and toggles the menu -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="services.php">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="gallery.php">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="user/login.php">Login</a></li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-nav-register" href="user/register.php">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- =====================================================
         HERO BANNER
         The "thesis" of the page - first impression with the
         main call-to-action button.
    ====================================================== -->
    <header class="hero" id="home">
        <div class="hero-frame" data-aos>
            <img src="https://images.unsplash.com/photo-1560066984-138dadb4c035?q=80&w=1200&auto=format&fit=crop" alt="Client relaxing during a luxury salon treatment" class="hero-img">
        </div>

        <div class="container hero-content">
            <p class="eyebrow">Est. Jamnagar &mdash; Private Studio</p>
            <h1 class="hero-title">
                Where every strand<br>
                is treated like <span class="gold-italic">gold.</span>
            </h1>
            <p class="hero-sub">
                Bloom &amp; Gold is an intimate beauty studio for hair, skin, and self-care rituals &mdash;
                crafted around you, one appointment at a time.
            </p>
            <div class="hero-actions">
                <a href="user/book_appointment.php" class="btn btn-hero-primary">Book Appointment</a>
                <a href="#services" class="btn btn-hero-ghost">View Services</a>
            </div>
        </div>
    </header>

    <!-- =====================================================
         ABOUT SALON SECTION
    ====================================================== -->
    <section class="section about-section" id="about">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="about-img-wrap">
                        <img src="https://images.unsplash.com/photo-1522337660859-02fbefca4702?q=80&w=1000&auto=format&fit=crop" alt="Interior of the Bloom and Gold salon studio" class="img-fluid about-img">
                        <div class="about-badge">
                            <span class="about-badge-num">12+</span>
                            <span class="about-badge-label">Years of<br>Craft</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <p class="eyebrow">About The Studio</p>
                    <h2 class="section-title">A quiet corner for beautiful things</h2>
                    <p class="section-text">
                        Bloom &amp; Gold began as a single chair and a belief that beauty care should feel
                        unhurried. Today our stylists and therapists still hold onto that idea &mdash;
                        soft lighting, warm tea, and undivided attention for every guest who walks through our doors.
                    </p>
                    <ul class="about-list">
                        <li><i class="bi bi-check2"></i> Certified stylists &amp; licensed therapists</li>
                        <li><i class="bi bi-check2"></i> Premium, cruelty-free product lines</li>
                        <li><i class="bi bi-check2"></i> Private, appointment-only studio rooms</li>
                    </ul>
                    <a href="about.php" class="link-more">Read our full story <i class="bi bi-arrow-up-right"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- =====================================================
         OUR SERVICES SECTION (6 cards)
    ====================================================== -->
    <section class="section services-section" id="services">
        <div class="container">
            <div class="text-center section-head">
                <p class="eyebrow">What We Offer</p>
                <h2 class="section-title">Our Signature Services</h2>
            </div>

            <div class="row g-4">
                <!-- Service Card 1 -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card">
                        <div class="service-icon"><i class="bi bi-scissors"></i></div>
                        <h3>Hair Styling &amp; Cut</h3>
                        <p>Precision cuts and styling tailored to your face shape and lifestyle.</p>
                        <span class="service-price">From &#8377;499</span>
                    </div>
                </div>
                <!-- Service Card 2 -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card">
                        <div class="service-icon"><i class="bi bi-droplet"></i></div>
                        <h3>Hair Color &amp; Highlights</h3>
                        <p>Rich, dimensional color using ammonia-free, nourishing formulas.</p>
                        <span class="service-price">From &#8377;1,299</span>
                    </div>
                </div>
                <!-- Service Card 3 -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card">
                        <div class="service-icon"><i class="bi bi-flower1"></i></div>
                        <h3>Signature Facial</h3>
                        <p>A restorative facial ritual that leaves skin visibly radiant.</p>
                        <span class="service-price">From &#8377;999</span>
                    </div>
                </div>
                <!-- Service Card 4 -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card">
                        <div class="service-icon"><i class="bi bi-magic"></i></div>
                        <h3>Bridal Makeup</h3>
                        <p>Full bridal beauty packages, from trial to the big day.</p>
                        <span class="service-price">From &#8377;7,999</span>
                    </div>
                </div>
                <!-- Service Card 5 -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card">
                        <div class="service-icon"><i class="bi bi-hand-index-thumb"></i></div>
                        <h3>Manicure &amp; Pedicure</h3>
                        <p>Nail care and pampering with premium gel and spa treatments.</p>
                        <span class="service-price">From &#8377;699</span>
                    </div>
                </div>
                <!-- Service Card 6 -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card">
                        <div class="service-icon"><i class="bi bi-stars"></i></div>
                        <h3>Body Spa &amp; Massage</h3>
                        <p>Full-body relaxation therapy using warm aromatic oils.</p>
                        <span class="service-price">From &#8377;1,499</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =====================================================
         WHY CHOOSE US SECTION
    ====================================================== -->
    <section class="section why-section">
        <div class="container">
            <div class="text-center section-head">
                <p class="eyebrow">Our Promise</p>
                <h2 class="section-title">Why Guests Choose Bloom &amp; Gold</h2>
            </div>

            <div class="row g-4 text-center">
                <div class="col-sm-6 col-lg-3">
                    <div class="why-card">
                        <i class="bi bi-award"></i>
                        <h4>Certified Experts</h4>
                        <p>Every stylist is trained and certified in their craft.</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="why-card">
                        <i class="bi bi-calendar-check"></i>
                        <h4>Easy Booking</h4>
                        <p>Reserve your slot online in under a minute.</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="why-card">
                        <i class="bi bi-heart"></i>
                        <h4>Gentle Products</h4>
                        <p>Skin and scalp friendly formulas, always.</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="why-card">
                        <i class="bi bi-shield-check"></i>
                        <h4>Hygiene First</h4>
                        <p>Sterilized tools and single-use essentials.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =====================================================
         CUSTOMER TESTIMONIALS SECTION
    ====================================================== -->
    <section class="section testimonial-section">
        <div class="container">
            <div class="text-center section-head">
                <p class="eyebrow">Kind Words</p>
                <h2 class="section-title">From Our Guests</h2>
            </div>

            <!-- Bootstrap Carousel: built-in JS handles the sliding, no custom JS required -->
            <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="testimonial-card mx-auto">
                            <i class="bi bi-quote quote-icon"></i>
                            <p class="testimonial-text">"The most relaxing salon visit I've had. My stylist actually listened to what I wanted &mdash; no more, no less."</p>
                            <p class="testimonial-name">Ananya Sharma</p>
                            <span class="testimonial-role">Regular Guest, 2 years</span>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="testimonial-card mx-auto">
                            <i class="bi bi-quote quote-icon"></i>
                            <p class="testimonial-text">"Booked my bridal trial here and never looked elsewhere again. Professional, warm, and worth every rupee."</p>
                            <p class="testimonial-name">Priya Mehta</p>
                            <span class="testimonial-role">Bride, March 2026</span>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="testimonial-card mx-auto">
                            <i class="bi bi-quote quote-icon"></i>
                            <p class="testimonial-text">"Clean, calm, and the gold-and-pink interior alone makes it worth the visit. The facial results speak for themselves."</p>
                            <p class="testimonial-name">Ritika Desai</p>
                            <span class="testimonial-role">Regular Guest, 1 year</span>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                    <span class="testimonial-nav-btn"><i class="bi bi-chevron-left"></i></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                    <span class="testimonial-nav-btn"><i class="bi bi-chevron-right"></i></span>
                </button>
            </div>
        </div>
    </section>

    <!-- =====================================================
         CALL TO ACTION STRIP
    ====================================================== -->
    <section class="cta-strip">
        <div class="container text-center">
            <h2>Ready for your next appointment?</h2>
            <a href="user/book_appointment.php" class="btn btn-hero-primary">Book Appointment</a>
        </div>
    </section>

    <!-- =====================================================
         FOOTER
    ====================================================== -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <span class="brand-mark footer-brand">Bloom<span class="brand-amp">&amp;</span>Gold</span>
                    <p class="footer-text">
                        A private beauty studio for hair, skin, and self-care &mdash;
                        built around unhurried, personal attention.
                    </p>
                    <div class="social-icons">
                        <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                        <a href="#" aria-label="Pinterest"><i class="bi bi-pinterest"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-sm-4">
                    <h6 class="footer-heading">Explore</h6>
                    <ul class="footer-links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="services.php">Services</a></li>
                        <li><a href="gallery.php">Gallery</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-sm-4">
                    <h6 class="footer-heading">Account</h6>
                    <ul class="footer-links">
                        <li><a href="user/login.php">Login</a></li>
                        <li><a href="user/register.php">Register</a></li>
                        <li><a href="user/book_appointment.php">Book Now</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-sm-4">
                    <h6 class="footer-heading">Visit Us</h6>
                    <ul class="footer-contact">
                        <li><i class="bi bi-geo-alt"></i> Patel Colony, Jamnagar, Gujarat</li>
                        <li><i class="bi bi-telephone"></i> +91 98765 43210</li>
                        <li><i class="bi bi-envelope"></i> hello@bloomandgold.studio</li>
                        <li><i class="bi bi-clock"></i> Tue&ndash;Sun, 10:00 AM &ndash; 8:00 PM</li>
                    </ul>
                </div>
            </div>

            <hr class="footer-rule">
            <p class="footer-bottom">&copy; <span id="year"></span> Bloom &amp; Gold Salon. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle (includes Popper) via CDN: powers navbar toggle & carousel -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Our own custom JavaScript file -->
    <script src="assets/js/script.js"></script>
</body>
</html>
