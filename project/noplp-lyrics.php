<?php require_once "../config.php"; 

$name = "noplp-lyrics";

$project = null;

foreach ($projects as $proj) {

    if ($proj['codeName'] === $name) {

        $project = $proj;

        break;

    }

}

?>



<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $project['name']; ?> - Xalri Portfolio</title>

    <link rel="stylesheet" href="/style.css">
<a href="https://github.com/Xalri" target="_blank">
    <link rel="stylesheet" href="/css/project.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Limelight|Nunito+Sans|Lexend">

    <link rel="icon" type="image/x-icon" href="/img/logo-background.png">

</head>

<body class="language-switch visible">

    <header>

        <h1><img src="/img/logo.png" alt="">alri</h1>

        <nav>

            <ul>

                <li><a href="/" data-fr="Accueil" data-en="Home">Home</a></li>

                <li><a href="/projects" class="active" data-fr="Projets" data-en="Projects">Projects</a></li>

                <li><a href="/blog" data-fr="Blog" data-en="Blog">Blog</a></li>

                <li><a href="/contact" data-fr="Contact" data-en="Contact">Contact</a></li>

            </ul>

        </nav>

        <div class="links">

            <a href="#" class="lang-switch"><img src="/img/globe.svg" alt=""></a>

            <a href="https://github.com/Xalri">

                <img src="/img/languages/github.svg" alt="GitHub">

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

                <img src="/img/projects/<?php echo $project['codeName']; ?>.png" alt="<?php echo $project['name']; ?>">

            </div>

        </section>



        <section id="project-info">

            <h2 data-fr="Détails du Projet" data-en="Project Details">Project Details</h2>

            <ul>

                <li><strong data-fr="Type" data-en="Type">Languages:</strong> <?php echo implode(', ', $project['languages']); ?></li>

                <li><strong data-fr="Date" data-en="Date">Date:</strong> <?php echo $project['date']; ?></li>

                <li><strong data-fr="Technologies" data-en="Technologies">Technologies:</strong> <?php echo implode(', ', $project['tags']); ?></li>

            </ul>

        </section>



        <section id="project-content">

            <h2 data-fr="Description" data-en="Description">Description</h2>

            <p data-fr="<?php echo $project['description-fr']; ?>" data-en="<?php echo $project['description-en']; ?>">

                <?php echo $project['description-en']; ?>

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

                    <li><a href="/contact" data-fr="Contact" data-en="Contact">Contact</a></li>

                </ul>

            </div>

            <div class="footer-social">

                <h3 data-en="Follow Me" data-fr="Suivez-moi">Follow Me</h3>

                <a href="https://github.com/Xalri" target="_blank" aria-label="GitHub">

                    <img src="/img/languages/github.svg" alt="GitHub">

                </a>

                <a href="https://twitch.com/XalriTV" target="_blank" aria-label="Twitch">

                    <img src="/img/languages/twitch.svg" alt="Twitch">

                </a>

                <a href="https://linkedin.com" target="_blank" aria-label="LinkedIn">

                    <img src="/img/languages/linkedin.svg" alt="LinkedIn">

                </a>

            </div>

        </div>

        <div class="footer-bottom">

            <p>&copy; 2025 Samy TEILLOUX. All rights reserved.</p>

        </div>

    </footer>

    <script src="/script.js"></script>

    <style>

        /**************************************************************

        *********************** PROJECT PAGE **************************

        **************************************************************/



        main {

            margin: 3em auto 2em auto;

            padding: 0 1em;

            max-width: 900px;

            color: #eeeeee;

            background: transparent;

        }



        #project-details {

            display: flex;

            flex-direction: row;

            align-items: flex-start;

            gap: 2.5em;

            margin-bottom: 2.5em;

            flex-wrap: wrap;

        }



        .project-header {

            flex: 2;

            min-width: 250px;

        }



        .project-header h1 {

            font-family: "Lexend", sans-serif;

            font-size: 2.7em;

            color: #d84040;

            margin-bottom: 0.5em;

            letter-spacing: 1px;

        }



        .project-header .description {

            font-size: 1.2em;

            color: #cccccc;

            margin-bottom: 1.5em;

            line-height: 1.5;

        }



        .project-image {

            flex: 1;

            min-width: 220px;

            display: flex;

            align-items: center;

            justify-content: center;

        }



        .project-image img {

            width: 100%;

            max-width: 320px;

            border-radius: 18px;

            box-shadow: 0 4px 16px rgba(0,0,0,0.18);

            object-fit: cover;

            background: #222;

        }



        /**************************************************************

        *********************** PROJECT INFO **************************

        **************************************************************/



        #project-info {

            margin-bottom: 2.5em;

            background: rgba(142, 22, 22, 0.08);

            border-radius: 14px;

            padding: 1.5em 2em;

            box-shadow: 0 2px 8px rgba(0,0,0,0.07);

        }



        #project-info h2 {

            font-size: 1.3em;

            color: #d84040;

            margin-bottom: 1em;

            font-family: "Lexend", sans-serif;

        }



        #project-info ul {

            list-style: none;

            padding: 0;

            margin: 0;

        }



        #project-info li {

            margin-bottom: 0.7em;

            font-size: 1.1em;

            color: #eeeeee;

        }



        #project-info strong {

            color: #d84040;

            font-weight: 600;

            margin-right: 0.5em;

        }



        /**************************************************************

        *********************** PROJECT CONTENT ***********************

        **************************************************************/



        #project-content {

            margin-bottom: 2.5em;

        }



        #project-content h2 {

            font-size: 1.3em;

            color: #d84040;

            margin-bottom: 0.7em;

            font-family: "Lexend", sans-serif;

        }



        #project-content p {

            font-size: 1.1em;

            color: #cccccc;

            line-height: 1.6;

            margin-bottom: 0.5em;

        }



        /**************************************************************

        *********************** PROJECT LINKS *************************

        **************************************************************/



        #project-links {

            margin-bottom: 2em;

        }



        #project-links h2 {

            font-size: 1.2em;

            color: #d84040;

            margin-bottom: 0.7em;

            font-family: "Lexend", sans-serif;

        }



        #project-links ul {

            list-style: none;

            padding: 0;

            margin: 0;

            display: flex;

            gap: 1.5em;

            flex-wrap: wrap;

        }



        #project-links li {

            margin-bottom: 0.5em;

        }



        #project-links a {

            color: #eeeeee;

            background: #8e1616;

            padding: 0.5em 1.2em;

            border-radius: 8px;

            text-decoration: none;

            font-weight: 600;

            transition: background 0.2s, color 0.2s, transform 0.2s;

            display: inline-block;

        }



        #project-links a:hover {

            background: #d84040;

            color: #fff;

            transform: scale(1.05);

        }



        /**************************************************************

        *********************** RESPONSIVE ****************************

        **************************************************************/



        @media (max-width: 900px) {

            main {

                max-width: 98vw;

                padding: 0 0.5em;

            }

            #project-details {

                flex-direction: column;

                align-items: stretch;

                gap: 1.5em;

            }

            .project-image {

                justify-content: flex-start;

            }

        }



        @media (max-width: 600px) {

            .project-header h1 {

                font-size: 2em;

            }

            #project-info, #project-content, #project-links {

                padding: 1em 0.5em;

            }

            .project-image img {

                max-width: 100%;

            }

        }

    </style>

</body>

</html>