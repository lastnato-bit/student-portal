<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo e(config('app.name', 'Student Academic Portal')); ?></title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;500;700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

    <!-- Tailwind or your CSS (if using Vite) -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body, html { font-family: 'Roboto', sans-serif; }
        .top-bar {
            background-color: #2563eb;
            color: white;
            display: flex;
            justify-content: space-between;
            padding: 10px 20px;
            font-size: 14px;
            flex-wrap: wrap;
        }
        .top-bar .left span { margin-right: 20px; }
        .top-bar .right a {
            margin-left: 10px;
            color: white;
            text-decoration: none;
        }
        .login-btn {
            background-color: #f97316;
            padding: 6px 12px;
            border-radius: 20px;
            color: white;
            margin-left: 15px;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .navbar .logo {
            font-size: 22px;
            font-weight: bold;
        }
        .navbar nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
        }
        .navbar nav ul li a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }
        .hero {
            background: url('https://images.pexels.com/photos/1181263/pexels-photo-1181263.jpeg') no-repeat center center/cover;
            height: 85vh;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .hero .overlay {
            background-color: rgba(0,0,0,0.6);
            padding: 40px;
            text-align: center;
            color: white;
            max-width: 650px;
            border-radius: 10px;
        }
        .hero h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }
        .hero p {
            font-size: 16px;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        .btn {
            background: #f97316;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
        }
        .btn:hover {
            background: #fb923c;
        }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="left">
            <span><i class="fas fa-envelope"></i> registrar@school.edu</span>
            <span><i class="fas fa-phone"></i> (555) 123-4567</span>
            <span><i class="fas fa-clock"></i> Mon - Fri: 8:00AM - 5:00PM</span>
        </div>
        <div class="right">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
            <a href="<?php echo e(route('login')); ?>">Login</a>


        </div>
    </div>

    <!-- Navbar -->
    <header class="navbar">
        <div class="logo">Student Academic Portal</div>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#teachers">Instructors</a></li>
                <li><a href="#gallery">Gallery</a></li>
                <li><a href="#testimonials">Testimonials</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="overlay">
            <div class="hero-text">
                <h1>Welcome to Your Academic Portal</h1>
                <p>
                    Securely access your grades, schedules, and important announcements—anytime, anywhere.
                </p>
                <a href="<?php echo e(route('login')); ?>" class="btn">Access My Account</a>
                
            </div>
        </div>
    </section>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\student-portal\resources\views/landing.blade.php ENDPATH**/ ?>