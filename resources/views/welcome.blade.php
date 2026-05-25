<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Apollo Todo</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <main class="landing-page">
        <nav class="landing-nav">
            <div class="landing-brand">
                <img src="{{ asset('images/apollo_gs_logo.jfif') }}"
                     alt="Apollo Green Solutions Logo"
                     class="landing-logo">

                <span>Apollo Todo</span>
            </div>

            <div class="landing-actions">
                @auth
                    <a href="{{ route('projects.index') }}" class="btn btn-primary">
                        Open Projects
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-secondary">
                        Log in
                    </a>

                    <a href="{{ route('register') }}" class="btn btn-primary">
                        Register
                    </a>
                @endauth
            </div>
        </nav>

        <section class="landing-hero">
            <div class="landing-content">
                <p class="page-kicker">Apollo Green Solutions Assignment</p>

                <h1 class="landing-title">
                    A simple To do app.
                </h1>

                <p class="landing-description">
                    Work made by : Taha GHAZOUANI.
                </p>

                <!-- MY contact -->
                <div class="landing-contact">
                    <a href="https://www.linkedin.com/in/taha-ghazouani/" class="contact-link" target="_blank" rel="noopener noreferrer">
                        LinkedIn
                    </a>
                    <span class="contact-divider">•</span>
                    <a href="https://github.com/TahaGHZ" class="contact-link" target="_blank" rel="noopener noreferrer">
                        GitHub
                    </a>
                </div>

                <div class="landing-feature-list">
                    <div class="landing-feature">
                        <span class="feature-dot"></span>
                        User authentication
                    </div>

                    <div class="landing-feature">
                        <span class="feature-dot"></span>
                        Project CRUD
                    </div>

                    <div class="landing-feature">
                        <span class="feature-dot"></span>
                        Task CRUD inside projects
                    </div>

                    <div class="landing-feature">
                        <span class="feature-dot"></span>
                        User-owned private workspace
                    </div>
                </div>

                <div class="btn-row">
                    @auth
                        <a href="{{ route('projects.index') }}" class="btn btn-primary">
                            Go to Workspace
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            Get Started
                        </a>

                        <a href="{{ route('login') }}" class="btn btn-secondary">
                            I already have an account
                        </a>
                    @endauth
                </div>


            </div>

        </section>

        <footer class="landing-footer">
            <p>
                Built with Laravel, Blade, PostgreSQL, and clean ownership checks.
            </p>
        </footer>
    </main>
</body>
</html>
