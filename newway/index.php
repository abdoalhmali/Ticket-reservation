<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management System</title>

    <!-- External CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #3b82f6;
            --background-color: #f8fafc;
            --text-color: #1e293b;
            --card-bg: rgba(255, 255, 255, 0.9);
            --shadow-color: rgba(0, 0, 0, 0.1);
        }

        [data-theme="dark"] {
            --primary-color: #3b82f6;
            --secondary-color: #60a5fa;
            --background-color: #0f172a;
            --text-color: #e2e8f0;
            --card-bg: rgba(30, 41, 59, 0.9);
            --shadow-color: rgba(0, 0, 0, 0.3);
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
            transition: all 0.3s ease;
            min-height: 100vh;
            position: relative;
        }

        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background: var(--card-bg);
            border: none;
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 4px 6px var(--shadow-color);
        }

        .glass-card {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 8px 32px var(--shadow-color);
            transition: transform 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-5px);
        }

        .navbar {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
        }

        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .hero-content {
            text-align: center;
            padding: 2rem;
            max-width: 800px;
        }

        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.5;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        .btn-custom {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px var(--shadow-color);
        }

        .event-card {
            margin-bottom: 30px;
        }

        .event-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }

        .footer {
            background: var(--card-bg);
            padding: 40px 0;
            margin-top: 50px;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .fade-in {
            animation: fadeIn 1s ease-in;
        }

        /* Loading Animation */
        .loader {
            width: 50px;
            height: 50px;
            border: 5px solid var(--background-color);
            border-top: 5px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Theme Toggle Button -->
    <button class="theme-toggle" onclick="toggleTheme()">
        <i class="fas fa-moon"></i>
    </button>

    <!-- Animated Background -->
    <div class="animated-bg"></div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">EventMS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#events">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-custom ms-2" href="login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="hero-content" data-aos="fade-up">
            <h1 class="display-4 mb-4">Welcome to Event Management System</h1>
            <p class="lead mb-4">Discover and book amazing events happening around you</p>
            <a href="#events" class="btn btn-custom btn-lg">Explore Events</a>
        </div>
    </section>

    <!-- Events Section -->
    <section id="events" class="container py-5">
    <h2 class="text-center mb-5" data-aos="fade-up">Upcoming Events</h2>
    <div class="row">
        <?php if ($events && count($events) > 0): ?>
            <?php foreach ($events as $event): ?>
                <div class="col-md-4 event-card" data-aos="fade-up">
                    <div class="glass-card">
                        <img src="https://picsum.photos/800/600?random=<?= htmlspecialchars($event['event_id']) ?>"
                             class="event-image mb-3" alt="<?= htmlspecialchars($event['title']) ?>">
                        <h5><?= htmlspecialchars($event['title']) ?></h5>
                        <p><?= htmlspecialchars($event['description']) ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-primary">$<?= htmlspecialchars($event['price']) ?></span>
                            <button class="btn btn-custom btn-sm">Book Now</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No events available at the moment.</p>
        <?php endif; ?>
    </div>
</section>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content glass-card">
                <div class="modal-header">
                    <h5 class="modal-title">Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="loginForm">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-custom w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>About Us</h5>
                    <p>Your premier destination for event management and booking.</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#events">Events</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact Us</h5>
                    <p>Email: info@eventms.com</p>
                    <p>Phone: +1 234 567 890</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init();

        // Theme Toggle
        function toggleTheme() {
            const body = document.body;
            const themeIcon = document.querySelector('.theme-toggle i');

            if (body.getAttribute('data-theme') === 'dark') {
                body.removeAttribute('data-theme');
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
            } else {
                body.setAttribute('data-theme', 'dark');
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            }
        }

        // Dynamic Event Loading
        async function loadEvents() {
            try {
                const response = await fetch('api/events.php');
                const events = await response.json();
                const eventsContainer = document.querySelector('#events .row');

                events.forEach(event => {
                    const eventCard = `
                        <div class="col-md-4 event-card" data-aos="fade-up">
                            <div class="glass-card">
                                <img src="https://picsum.photos/800/600?random=${event.id}"
                                    class="event-image mb-3" alt="${event.title}">
                                <h5>${event.title}</h5>
                                <p>${event.description}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-primary">${event.price}</span>
                                    <button class="btn btn-custom btn-sm">Book Now</button>
                                </div>
                            </div>
                        </div>
                    `;
                    eventsContainer.innerHTML += eventCard;
                });
            } catch (error) {
                console.error('Error loading events:', error);
            }
        }

        // Initialize the page
        document.addEventListener('DOMContentLoaded', () => {
            loadEvents();
        });
    </script>


<script>
    // Initialize AOS
    AOS.init();

    // Theme Toggle
    function toggleTheme() {
        const body = document.body;
        const themeIcon = document.querySelector('.theme-toggle i');

        if (body.getAttribute('data-theme') === 'dark') {
            body.removeAttribute('data-theme');
            themeIcon.classList.remove('fa-sun');
            themeIcon.classList.add('fa-moon');
        } else {
            body.setAttribute('data-theme', 'dark');
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
        }
    }

    // Dynamic Event Loading with Sample Event Fallback
    async function loadEvents() {
        const eventsContainer = document.querySelector('#events .row');

        try {
            const response = await fetch('api/events.php');
            const events = await response.json();

            events.forEach(event => {
                const eventCard = `
                    <div class="col-md-4 event-card" data-aos="fade-up">
                        <div class="glass-card">
                            <img src="https://picsum.photos/800/600?random=${event.id}"
                                class="event-image mb-3" alt="${event.title}">
                            <h5>${event.title}</h5>
                            <p>${event.description}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-primary">${event.price}</span>
                                <button class="btn btn-custom btn-sm">Book Now</button>
                            </div>
                        </div>
                    </div>
                `;
                eventsContainer.innerHTML += eventCard;
            });
        } catch (error) {
            console.error('Error loading events:', error);

            // Fallback sample event
            const sampleEvent = `
                <div class="col-md-4 event-card" data-aos="fade-up">
                    <div class="glass-card">
                        <img src="https://picsum.photos/800/600?random=1" class="event-image mb-3" alt="Sample Event">
                        <h5>Sample Event Title</h5>
                        <p>This is a sample description for an event to showcase the layout.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-primary">$10.00</span>
                            <button class="btn btn-custom btn-sm">Book Now</button>
                        </div>
                    </div>
                </div>
            `;
            eventsContainer.innerHTML += sampleEvent;
        }
    }

    // Initialize the page
    document.addEventListener('DOMContentLoaded', () => {
        loadEvents();
    });
</script>
</body>
</html>