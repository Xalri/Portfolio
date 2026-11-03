<?php require_once "./config.php"; ?>



<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $project['name']; ?> - Xalri Portfolio</title>

    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="css/projects.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Limelight|Nunito+Sans|Lexend">

    <link rel="icon" type="image/x-icon" href="img/logo.jpg">

</head>

<body class=<a href="https://github.com/Xalri" target="_blank">

    <header>

        <h1><img src="./img/logo.png" alt="">alri</h1>

        <nav>

            <ul>

                <li><a href="/" data-fr="Accueil" data-en="Home">Home</a></li>

                <li><a href="/projects" class="active" data-fr="Projets" data-en="Projects">Projects</a></li>

                <li><a href="/blog" data-fr="Blog" data-en="Blog">Blog</a></li>

                <li><a href="#contact" data-fr="Contact" data-en="Contact">Contact</a></li>

            </ul>

        </nav>

        <div class="links">

            <a href="#" class="lang-switch"><img src="./img/globe.svg" alt=""></a>

            <a href="https://github.com/Xalri">

                <img src="./img/languages/github.svg" alt="GitHub">

            </a>

            <a class="cv">Mon CV</a>

        </div>

    </header>



    <button id="go-up" onclick="goUp()">

        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#EEEEEE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up">

            <line x1="12" y1="19" x2="12" y2="5"></line>

            <polyline points="5 12 12 5 19 12"></polyline>

        </svg>

    </button>



    <main class="fade-in">

        <section id="project-details">

            <div class="project-header">

                <h1><?php echo $project['name']; ?></h1>

                <p class="description" data-fr="<?php echo $project['description-fr']; ?>" data-en="<?php echo $project['description-en']; ?>">

                    <?php echo $project['description-en']; ?>

                </p>

            </div>

            <div class="project-image">

                <img src="./img/projects/<?php echo $project['codeName']; ?>.png" alt="<?php echo $project['name']; ?>">

            </div>

        </section>



        <section id="project-info">

            <h2 data-fr="Détails du Projet" data-en="Project Details">Project Details</h2>

            <ul>

                <li><strong data-fr="Type" data-en="Type">Type:</strong> <?php echo implode(', ', $project['type']); ?></li>

                <li><strong data-fr="Date" data-en="Date">Date:</strong> <?php echo $project['date']; ?></li>

                <li><strong data-fr="Technologies" data-en="Technologies">Technologies:</strong> <?php echo implode(', ', $project['technologies']); ?></li>

            </ul>

        </section>



        <section id="project-content">

            <h2 data-fr="Description" data-en="Description">Description</h2>

            <p data-fr="<?php echo $project['content-fr']; ?>" data-en="<?php echo $project['content-en']; ?>">

                <?php echo $project['content-en']; ?>

            </p>

        </section>



        <section id="project-links">

            <h2 data-fr="Liens" data-en="Links">Links</h2>

            <ul>

                <?php if (!empty($project['github'])): ?>

                    <li><a href="<?php echo $project['github']; ?>" target="_blank" data-fr="Code Source" data-en="Source Code">Source Code</a></li>

                <?php endif; ?>

                <?php if (!empty($project['live'])): ?>

                    <li><a href="<?php echo $project['live']; ?>" target="_blank" data-fr="Voir en Ligne" data-en="Live Demo">Live Demo</a></li>

                <?php endif; ?>

            </ul>

        </section>

    </main>



    <footer>

        <div class="footer-container">

            <div class="footer-about">

                <h3 data-en="About Me" data-fr="À Propos">About Me</h3>

                <p data-en="I am a 16-year-old aspiring developer based in Paris, France. I enjoy working on projects and learning new skills to improve my abilities." data-fr="Je suis un jeune de 16 ans passionné par le développement web. J'aime travailler sur des projets et apprendre de nouvelles compétences pour améliorer mes compétences.">I am a 16-year-old aspiring developer based in Paris, France. I enjoy working on projects and learning new skills to improve my abilities.</p>

            </div>

            <div class="footer-links">

                <h3 data-en="Quick Links" data-fr="Liens Rapides">Quick Links</h3>

                <ul>

                    <li><a href="/" data-fr="Accueil" data-en="Home">Home</a></li>

                    <li><a href="/projects.html" data-fr="Projets" data-en="Projects">Projects</a></li>

                    <li><a href="/blog.html" data-fr="Blog" data-en="Blog">Blog</a></li>

                    <li><a href="#contact" data-fr="Contact" data-en="Contact">Contact</a></li>

                </ul>

            </div>

            <div class="footer-social">

                <h3 data-en="Follow Me" data-fr="Suivez-moi">Follow Me</h3>

                <a href="https://github.com/Xalri" target="_blank" aria-label="GitHub">

                    <img src="./img/languages/github.svg" alt="GitHub">

                </a>

                <a href="https://twitch.com/XalriTV" target="_blank" aria-label="Twitch">

                    <img src="./img/languages/twitch.svg" alt="Twitch">

                </a>

                <a href="https://linkedin.com" target="_blank" aria-label="LinkedIn">

                    <img src="./img/languages/linkedin.svg" alt="LinkedIn">

                </a>

            </div>

        </div>

        <div class="footer-bottom">

            <p>&copy; 2025 Samy TEILLOUX. All rights reserved.</p>

        </div>

    </footer>

    <script src="script.js"></script>

</body>

</html>