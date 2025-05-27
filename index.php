<?php require_once "includes/config.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxStay - Premium Hotel Booking</title>
    <link rel="stylesheet" href="css/index.css">k
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo-section">
            <div class="logo">W</div>
            <h1 class="title">WonderNest</h1>
        </div>
        
        <nav class="nav">
            <a href="index.php">Home</a>
            <a href="hotel_list.php">Hotel List</a>
            <a href="contact.php">Contact Us</a>
            <a href="about.php">About Us</a>
        </nav>
        
        <div class="auth-buttons">
            <a href="login.php" class="btn btn-login">Login</a>
            <a href="register.php" class="btn btn-register">Register</a>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-content">
            <h1>Discover Your Perfect Stay</h1>
            <p>Experience luxury and comfort at the world's finest hotels. Your journey to extraordinary begins here.</p>
            <button class="btn-book-now"><a href="login.php">Book Now</a></button>
        </div>
    </section>

    <!-- Popular Hotels Section -->
    <section class="popular-hotels" id="hotels">
        <div class="container">
            <h2 class="section-title">Most Popular Hotels</h2>
            
            <div class="hotels-grid">
                <div class="hotel-card">
                    <div class="hotel-image"><img src="images/Hotel the Diamond Ring.jpg" alt=""></div>
                    <div class="hotel-info">
                        <h3 class="hotel-name">Hotel the Diamond Ring</h3>
                        <p class="hotel-location">Lake Pichola, Udaipur, Rajasthan</p>
                        <div class="hotel-rating">
                            <span class="stars">★★★★★</span>
                            <span class="rating-text">4.9 (2,847 reviews)</span>
                        </div>
                        <p class="hotel-price">₹17,000/night</p>
                        <button class="btn-view-hotel" ><a href="login.php">View Details</a></button>
                    </div>
                </div>

                <div class="hotel-card">
                    <div class="hotel-image"><img src="images/Taj Falaknuma Palace Engine.jpg" alt=""></div>
                    <div class="hotel-info">
                        <h3 class="hotel-name">Taj Falaknuma Palace</h3>
                        <p class="hotel-location">Falaknuma, Hyderabad, Telangana</p>
                        <div class="hotel-rating">
                            <span class="stars">★★★★★</span>
                            <span class="rating-text">4.8 (1,923 reviews)</span>
                        </div>
                        <p class="hotel-price">₹24,000/night</p>
                        <button class="btn-view-hotel"><a href="login.php">View Details</a></button>
                    </div>
                </div>

                <div class="hotel-card">
                    <div class="hotel-image"><img src="images/The Taj.jpeg" alt=""></div>
                    <div class="hotel-info">
                        <h3 class="hotel-name">The Taj Mahal Palace</h3>
                        <p class="hotel-location">Mumbai, Maharashtra</p>
                        <div class="hotel-rating">
                            <span class="stars">★★★★★</span>
                            <span class="rating-text">4.7 (3,156 reviews)</span>
                        </div>
                        <p class="hotel-price">₹10,000/night</p>
                        <button class="btn-view-hotel"><a href="login.php">View Details</a></button>
                    </div>
                </div>
                
                <div class="hotel-card">
                    <div class="hotel-image"><img src="images/The Claridger.jpeg" alt=""></div>
                    <div class="hotel-info">
                        <h3 class="hotel-name">The Claridges</h3>
                        <p class="hotel-location">APJ Abdul Kalam Road, New Delhi</p>
                        <div class="hotel-rating">
                            <span class="stars">★★★★★</span>
                            <span class="rating-text">4.7 (3,156 reviews)</span>
                        </div>
                        <p class="hotel-price">₹9,000/night</p>
                        <button class="btn-view-hotel"><a href="login.php">View Details</a></button>
                    </div>
                </div>

                <div class="hotel-card">
                    <div class="hotel-image"><img src="images/The Oberoi Rajvilas.jpg" alt=""></div>
                    <div class="hotel-info">
                        <h3 class="hotel-name">The Oberoi Rajvilas</h3>
                        <p class="hotel-location">Goner Rd, Jaipur, Rajasthan</p>
                        <div class="hotel-rating">
                            <span class="stars">★★★★★</span>
                            <span class="rating-text">4.8 (2,341 reviews)</span>
                        </div>
                        <p class="hotel-price">₹25,500/night</p>
                        <button class="btn-view-hotel"><a href="login.php">View Details</a></button>
                    </div>
                </div>

                <div class="hotel-card">
                    <div class="hotel-image"><img src="images/W Goa.jpg" alt=""></div>
                    <div class="hotel-info">
                        <h3 class="hotel-name">W Goa</h3>
                        <p class="hotel-location">Vagator Beach, Goa</p>
                        <div class="hotel-rating">
                            <span class="stars">★★★★★</span>
                            <span class="rating-text">4.6 (4,287 reviews)</span>
                        </div>
                        <p class="hotel-price">₹16,000/night</p>
                        <button class="btn-view-hotel"><a href="login.php">View Details</a></button>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <script>
        // Add smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add header scroll effect
        window.addEventListener('scroll', () => {
            const header = document.querySelector('.header');
            if (window.scrollY > 100) {
                header.style.background = 'rgba(240, 235, 229, 0.98)';
                header.style.backdropFilter = 'blur(20px)';
            } else {
                header.style.background = 'linear-gradient(135deg, var(--cream) 0%, rgba(240, 235, 229, 0.95) 100%)';
                header.style.backdropFilter = 'blur(10px)';
            }
        });

        // Book Now button functionality
        function startBooking() {
            alert('🎉 Welcome to LuxStay! Your booking journey starts here. Please select your preferred dates and destination.');
        }

        // Add staggered animation for hotel cards
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.animation = 'slideUp 0.8s ease-out forwards';
                    }, index * 100);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.hotel-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            observer.observe(card);
        });

        // Add click effects to buttons
        document.querySelectorAll('.btn, .btn-view-hotel, .btn-book-now').forEach(btn => {
            btn.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.cssText = `
                    position: absolute;
                    width: ${size}px;
                    height: ${size}px;
                    left: ${x}px;
                    top: ${y}px;
                    background: rgba(255, 255, 255, 0.3);
                    border-radius: 50%;
                    transform: scale(0);
                    animation: ripple 0.6s ease-out;
                    pointer-events: none;
                `;
                
                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);
                
                setTimeout(() => ripple.remove(), 600);
            });
        });

        // Add ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>