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
            padding-top: 80px; /* altura del navbar */
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
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" class="active"
                    aria-current="true" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item">
                    <img src="/img/banner1.png" class="d-block w-100" alt="Banner 1">
                </div>
                <div class="carousel-item active">
                    <img src="/img/banner2.jpeg" class="d-block w-100" alt="Banner 2">
                </div>
                <div class="carousel-item">
                    <img src="/img/banner3.jpeg" class="d-block w-100" alt="Banner 3">
                </div>
            </div>
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
        <h2 class="text-center mb-4" style="color:#037E8C;">Actividades de la Fundación</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="/img/foto2.jpg" class="card-img-top" alt="Taller de apoyo">
                    <div class="card-body">
                        <h5 class="card-title">Talleres de apoyo</h5>
                        <p>Sesiones de crecimiento personal y fortalecimiento emocional para mujeres y jóvenes.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="/img/foto2.jpg" class="card-img-top" alt="Charlas educativas">
                    <div class="card-body">
                        <h5 class="card-title">Charlas educativas</h5>
                        <p>Charlas en colegios y comunidades sobre prevención de la violencia y derechos humanos.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="/img/foto2.jpg" class="card-img-top" alt="Eventos comunitarios">
                    <div class="card-body">
                        <h5 class="card-title">Eventos comunitarios</h5>
                        <p>Actividades culturales y ferias para sensibilizar y acercar la misión de la fundación a la población.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección Testimonios -->
    <section id="testimonios" class="container py-5">
        <h2 class="text-center mb-5 fw-bold" style="color: #037E8C;">Testimonios</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm h-100 border-0 rounded-4 text-center">
                    <img src="/img/banner1.png" alt="María" class="img-fluid rounded-circle mb-3" style="width:100px;height:100px;object-fit:cover;">
                    <p class="fst-italic">“Gracias a la fundación recuperé la confianza en mí misma y encontré apoyo psicológico.”</p>
                    <h6 class="fw-semibold" style="color:#7EC544;">— María, beneficiaria</h6>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm h-100 border-0 rounded-4 text-center">
                    <img src="/img/banner1.png" alt="Ana" class="img-fluid rounded-circle mb-3" style="width:100px;height:100px;object-fit:cover;">
                    <p class="fst-italic">“Hoy puedo decir que mi vida cambió para mejor gracias a la ayuda recibida aquí.”</p>
                    <h6 class="fw-semibold" style="color:#7EC544;">— Ana, joven atendida</h6>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm h-100 border-0 rounded-4 text-center">
                    <img src="/img/banner1.png" alt="Carmen" class="img-fluid rounded-circle mb-3" style="width:100px;height:100px;object-fit:cover;">
                    <p class="fst-italic">“Un lugar donde encontré seguridad, comprensión y esperanza para mi familia.”</p>
                    <h6 class="fw-semibold" style="color:#7EC544;">— Carmen, madre beneficiaria</h6>
                </div>
            </div>
        </div>
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
                        <input type="email" class="form-control" id="email" placeholder="correo@ejemplo.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Mensaje</label>
                        <textarea class="form-control" id="message" rows="4" placeholder="Escribe tu mensaje" required></textarea>
                    </div>
                    <button type="submit" class="btn w-100" style="background-color:#13C0E5; color:white;">Enviar</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-4 footer mt-auto">
        <div class="container text-center">
            <h5 class="mb-3 fw-bold" style="color: #7EC544;">Fundación Levántate Mujer</h5>
            <div class="d-flex justify-content-center gap-3 mb-3">
                <a href="#" class="btn btn-light rounded-circle" style="background-color:#13C0E5;color:white;"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="btn btn-light rounded-circle" style="background-color:#7EC544;color:white;"><i class="fab fa-twitter"></i></a>
                <a href="#" class="btn btn-light rounded-circle" style="background-color:#F4F4F2;color:#037E8C;"><i class="fab fa-instagram"></i></a>
                <a href="#" class="btn btn-light rounded-circle" style="background-color:#13C0E5;color:white;"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" class="btn btn-light rounded-circle" style="background-color:#7EC544;color:white;"><i class="fab fa-youtube"></i></a>
            </div>
            <small style="color: #F4F4F2;">© 2025 FLM Todos los derechos reservados.</small><br>
            <small style="color: #13C0E5;">Bryan Kender Mendoza Canaviri</small>
        </div>
    </footer>

</body>

</html>
