<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fundación Levántate Mujer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background-color: #F4F4F2;
            scroll-behavior: smooth;
            padding-top: 80px;
            /* altura del navbar */
        }

        .navbar {
            background-color: #037E8C;
        }

        .nav-link {
            color: white !important;
        }

        .nav-link:hover {
            background-color: #13C0E5;
            border-radius: 5px;
        }

        .navbar-brand {
            color: white !important;
        }

        .card-title {
            color: #7EC544;
        }

        .footer {
            background-color: #037E8C;
        }


        /* Fija altura del carousel y ajusta las imágenes */
        .carousel-img {
            height: 800px;
            /* Cambia 500px por la altura que necesites */
            object-fit: cover;
        }

        .carousel-img {
            width: 100%;
            height: 60vh;
            /* Altura adaptable */
            object-fit: cover;
            /* Evita que la imagen se deforme */
        }

        @media (max-width: 768px) {
            .carousel-caption {
                font-size: 0.9rem;
                padding: 0.5rem;
            }

            .carousel-img {
                height: 40vh;
            }
        }

        @media (max-width: 576px) {
            .carousel-caption h5 {
                font-size: 1rem;
            }

            .carousel-caption p {
                font-size: 0.8rem;
            }
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Navbar fijo -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="#inicio">
                    <img src="{{ asset('img/flm_blanco.png') }}" alt="Logo" class="me-2" width="80">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="#inicio">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#actividades">Actividades</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#testimonios">Testimonios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#contacto">Contacto</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link">
                                Iniciar Sesión</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- Sección Inicio con carousel -->
    <main id="inicio">
        <div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel">

            <!-- Indicadores -->
            <div class="carousel-indicators">
                @foreach ($slides as $key => $slide)
                    <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="{{ $key }}"
                        class="{{ $key == 0 ? 'active' : '' }}" aria-current="{{ $key == 0 ? 'true' : '' }}"
                        aria-label="Slide {{ $key + 1 }}"></button>
                @endforeach
            </div>

            <!-- Slides -->
            <div class="carousel-inner">
                @foreach ($slides as $key => $slide)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $slide->imagen) }}" class="d-block w-100 carousel-img"
                            alt="{{ $slide->titulo }}" style="object-fit: cover; height: 60vh;">

                        @if ($slide->titulo || $slide->descripcion)
                            <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-2 rounded">
                                @if ($slide->titulo)
                                    <h5 class="fs-5 fs-md-3">{{ $slide->titulo }}</h5>
                                @endif
                                @if ($slide->descripcion)
                                    <p class="fs-6 fs-md-5">{{ $slide->descripcion }}</p>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Controles -->
            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
    </main>

    <!-- Sección Actividades -->
    <section id="actividades" class="container py-5">
        <h2 class="text-center mb-4" style="color:#037E8C;">Nuestras Actividades</h2>
        <div class="row g-4">
            @foreach ($actividades as $actividad)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        @if ($actividad->imagen)
                            <img src="{{ asset('storage/' . $actividad->imagen) }}" class="card-img-top"
                                alt="{{ $actividad->titulo }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $actividad->titulo }}</h5>
                            <p>{{ Str::limit($actividad->descripcion, 100) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section id="testimonios" class="container py-5">
        <h2 class="text-center mb-5 fw-bold" style="color: #037E8C;">Testimonios</h2>
        <div class="row g-4">
            @foreach ($testimonios as $testimonio)
                <div class="col-md-4">
                    <div class="card shadow-sm h-100 border-0 rounded-4 text-center">
                        @if ($testimonio->imagen)
                            <img src="{{ asset('storage/' . $testimonio->imagen) }}" class="rounded-circle mx-auto img-fluid mb-3"
                                style="width:100px;height:100px;object-fit:cover;">
                        @endif
                        <p class="fst-italic">{{ $testimonio->mensaje }}</p>
                        <h6 class="fw-semibold" style="color:#7EC544;">— {{ $testimonio->nombre }}, {{ $testimonio->rol }}</h6>
                        
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    <section id="contenidos" class="py-5">
        <h2 class="text-center">Contenidos</h2>
        @foreach ($contenidos as $contenido)
            <div class="mb-4 text-center">
                <h3>{{ $contenido->titulo }}</h3>
                <p>{{ $contenido->descripcion }}</p>
                @if ($contenido->imagen)
                    <img src="{{ asset('storage/' . $contenido->imagen) }}" class="img-fluid"
                        alt="{{ $contenido->titulo }}">
                @endif
            </div>
        @endforeach
    </section>

    <!-- Sección Contacto -->
    <section id="contacto" class="container py-5">
        <h2 class="text-center mb-4" style="color: #037E8C;">Contáctanos</h2>
        <div class="row">
            <div class="col-md-6">
                <h4 style="color: #7EC544;">Oficinas Centrales</h4>
                <p><i class="bi bi-geo-alt-fill"></i> Av. Guadalquivir, Zona Nuevos Horizontes II</p>
                <p><i class="bi bi-envelope-fill"></i> gerencia@levantatemujer.org</p>
                <p><i class="bi bi-telephone-fill"></i> +591 2 2784513</p>
                <p><i class="bi bi-phone-fill"></i> +591 690 02358</p>
            </div>
            <div class="col-md-6">
                <form>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" placeholder="Tu nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="email" placeholder="correo@ejemplo.com"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Mensaje</label>
                        <textarea class="form-control" id="message" rows="4" placeholder="Escribe tu mensaje" required></textarea>
                    </div>
                    <button type="submit" class="btn w-100"
                        style="background-color:#13C0E5; color:white;">Enviar</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-4 footer mt-auto">
        <div class="container text-center">
            <h5 class="mb-3 fw-bold" style="color: #7EC544;">Fundación Levántate Mujer</h5>
            <div class="d-flex justify-content-center gap-3 mb-3">
                <a href="#" class="btn btn-light rounded-circle"
                    style="background-color:#13C0E5;color:white;"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="btn btn-light rounded-circle"
                    style="background-color:#7EC544;color:white;"><i class="fab fa-twitter"></i></a>
                <a href="#" class="btn btn-light rounded-circle"
                    style="background-color:#F4F4F2;color:#037E8C;"><i class="fab fa-instagram"></i></a>
                <a href="#" class="btn btn-light rounded-circle"
                    style="background-color:#13C0E5;color:white;"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" class="btn btn-light rounded-circle"
                    style="background-color:#7EC544;color:white;"><i class="fab fa-youtube"></i></a>
            </div>
            <small style="color: #F4F4F2;">© 2025 FLM Todos los derechos reservados.</small><br>
            <small style="color: #13C0E5;">Bryan Kender Mendoza Canaviri</small>
        </div>
    </footer>

</body>

</html>
