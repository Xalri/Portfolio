<?php require_once "./config.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xalri - Portfolio</title>
    <link rel="stylesheet" href="style.css?random=<?php echo rand(); ?>">
    <link rel="stylesheet" href="css/index.css?random=<?php echo rand(); ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Limelight|Nunito+Sans|Lexend">
    <link rel="icon" type="image/x-icon" href="img/logo-background-rounded.png">
    <script defer src="https://unami.xalri.ovh/script.js" data-website-id="2122e7f9-a7d3-4602-8e26-b7451721f6ae"></script>

</head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-N5G8BQ48XX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-N5G8BQ48XX');
</script>
<body class="language-switch visible">
    <header>
        <h1><img src="./img/logo.png" alt="">alri</h1>
        <nav>
            <ul>
                <li><a href="/" class="active" data-fr="Accueil" data-en="Home">Home</a></li>
                <li><a href="/projects" data-fr="Projets" data-en="Projects">Projects</a></li>
                <li><a href="/blog" data-fr="Blog" data-en="Blog">Blog</a></li>
                <li><a href="/contact" data-fr="Contact" data-en="Contact">Contact</a></li>
                <li class="lang-switch">
                    <a href="#" class="lang-switch"><img src="./img/globe.svg" alt="">
                        <div class="lang-bubble" data-en="<p>Passer en <img class='lang-flag' src='./img/france-logo.png' alt=''></p>" data-fr="<p><img class='lang-flag' src='./img/english-logo.png' alt=''>Switch to </p>"><p>Passer en <img class='lang-flag' src='./img/france-logo.png' alt=''></p></div>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="links">
            <a href="#" class="lang-switch"><img src="./img/globe.svg" alt="">
                <div class="lang-bubble" data-en="<p>Passer en <img class='lang-flag' src='./img/france-logo.png' alt=''></p>" data-fr="<p>Switch to <img class='lang-flag' src='./img/english-logo.png' alt=''></p>"><p>Passer en <img class='lang-flag' src='./img/france-logo.png' alt=''></p></div>
            </a>
            
            <a href="https://github.com/Xalri" target="_blank">
                <svg data-v-098ada39="" width="21" height="24" viewBox="0 0 21 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path data-v-098ada39="" 
                    d="M9.07032 20.5029C9.0703 20.3563 9.03802 20.2114 8.97578 20.0786C8.91353 19.9458 8.82284 19.8284 8.71014 19.7345C8.59743 19.6407 8.46546 19.5728 8.32359 19.5356C8.18171 19.4985 8.03341 19.493 7.88917 19.5195C6.58009 19.7598 4.92726 19.7959 4.4878 18.5615C4.10461 17.6055 3.46987 16.7711 2.65089 16.1465C2.59246 16.1148 2.53677 16.0782 2.48439 16.0372C2.41272 15.8481 2.2854 15.6852 2.11925 15.5699C1.95311 15.4547 1.75592 15.3925 1.55372 15.3916H1.54884C1.28444 15.3916 1.03077 15.4962 0.843354 15.6827C0.655937 15.8692 0.55004 16.1224 0.548842 16.3868C0.544932 17.2022 1.35984 17.7247 1.69044 17.9014C2.08029 18.2931 2.39359 18.7541 2.61427 19.2608C2.97853 20.2842 4.03712 21.837 7.08009 21.6368C7.08109 21.6719 7.08204 21.7051 7.08253 21.7354L7.08692 22.003C7.08692 22.2682 7.19228 22.5226 7.37982 22.7101C7.56735 22.8976 7.82171 23.003 8.08692 23.003C8.35214 23.003 8.60649 22.8976 8.79403 22.7101C8.98157 22.5226 9.08692 22.2682 9.08692 22.003L9.08204 21.6846C9.07716 21.4951 9.07032 21.2207 9.07032 20.5029ZM19.7373 5.37694C19.7691 5.25194 19.8003 5.11327 19.8277 4.95702C19.9894 3.84261 19.8484 2.70521 19.4195 1.66402C19.3653 1.52828 19.2822 1.40603 19.1758 1.30582C19.0694 1.20562 18.9425 1.12989 18.8037 1.08395C18.4477 0.963828 17.1333 0.727498 14.6197 2.33395C12.5302 1.84224 10.3551 1.84224 8.26565 2.33395C5.76222 0.751028 4.4546 0.965828 4.10206 1.07911C3.95993 1.12319 3.82946 1.19851 3.72021 1.29957C3.61097 1.40062 3.52572 1.52483 3.47071 1.66311C3.03301 2.72429 2.89355 3.88488 3.06739 5.01955C3.09181 5.14748 3.11817 5.26565 3.14552 5.37404C2.31709 6.47748 1.87583 7.8234 1.89015 9.20314C1.88745 9.51097 1.90163 9.81873 1.93263 10.125C2.26663 14.7275 5.26663 16.1094 7.35694 16.584C7.31349 16.709 7.27394 16.8428 7.23878 16.9844C7.17612 17.2417 7.21805 17.5133 7.35538 17.7398C7.49271 17.9662 7.71422 18.1289 7.97135 18.1923C8.22848 18.2556 8.50024 18.2144 8.72703 18.0777C8.95382 17.941 9.11714 17.7199 9.18116 17.4629C9.24479 17.1297 9.40788 16.8236 9.64894 16.585C9.7947 16.4574 9.90023 16.2902 9.9527 16.1037C10.0052 15.9172 10.0023 15.7195 9.94447 15.5346C9.88663 15.3497 9.77631 15.1856 9.62693 15.0623C9.47754 14.9389 9.29554 14.8617 9.10304 14.8399C5.64894 14.4453 4.14942 13.0381 3.92384 9.94143C3.89885 9.69616 3.88761 9.44968 3.89015 9.20315C3.87411 8.2198 4.19898 7.26123 4.80958 6.49026C4.87093 6.40988 4.93628 6.33263 5.00538 6.25881C5.12781 6.12181 5.21013 5.95373 5.2433 5.77301C5.27646 5.5923 5.25919 5.40594 5.19338 5.2344C5.12592 5.05393 5.07397 4.86803 5.03811 4.67873C4.95664 4.14044 4.98337 3.59132 5.11671 3.06349C5.98585 3.30896 6.80383 3.70853 7.53171 4.24317C7.65208 4.32334 7.78828 4.3767 7.93108 4.39961C8.07388 4.42253 8.21994 4.41447 8.35935 4.37599C10.3805 3.82749 12.5113 3.82783 14.5322 4.37699C14.6724 4.41543 14.8192 4.42303 14.9626 4.39926C15.106 4.37549 15.2425 4.32091 15.3628 4.2393C16.0872 3.70244 16.9018 3.2993 17.768 3.04887C17.9008 3.56402 17.9305 4.10032 17.8554 4.62699C17.8192 4.83453 17.7626 5.03799 17.6865 5.23442C17.6207 5.40596 17.6034 5.59232 17.6366 5.77303C17.6697 5.95375 17.7521 6.12183 17.8745 6.25883C17.9516 6.34574 18.0288 6.43949 18.0981 6.52738C18.7044 7.2853 19.0238 8.23285 19 9.20314C19.0018 9.46275 18.9893 9.72226 18.9624 9.98048C18.7422 13.0361 17.2368 14.4443 13.7666 14.8398C13.5741 14.8618 13.392 14.9392 13.2427 15.0626C13.0933 15.1861 12.983 15.3503 12.9253 15.5353C12.8675 15.7202 12.8647 15.918 12.9172 16.1046C12.9698 16.2911 13.0754 16.4583 13.2212 16.5859C13.4698 16.831 13.6333 17.1493 13.6875 17.4941C13.7551 17.7618 13.7861 18.0375 13.7798 18.3135V20.6475C13.77 21.2949 13.77 21.7803 13.77 22.0029C13.77 22.2682 13.8754 22.5225 14.0629 22.71C14.2504 22.8976 14.5048 23.0029 14.77 23.0029C15.0352 23.0029 15.2896 22.8976 15.4771 22.71C15.6647 22.5225 15.77 22.2682 15.77 22.0029C15.77 21.7861 15.77 21.3106 15.7798 20.6631V18.3135C15.7878 17.8713 15.7358 17.4301 15.625 17.002C15.5933 16.8614 15.5545 16.7226 15.5088 16.586C17.03 16.3332 18.4123 15.5489 19.4094 14.3726C20.4065 13.1962 20.9539 11.7042 20.9541 10.1621C20.987 9.84355 21.0024 9.5234 21 9.20314C21.0222 7.82191 20.5773 6.47366 19.7373 5.37696L19.7373 5.37694Z" fill="white">
                        
                    </path>
                </svg>
            </a>
            <a class="cv" >Mon CV</a>
        </div>
    </header>

    <button id="go-up" onclick="goUp()">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#EEEEEE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up">
            <line x1="12" y1="19" x2="12" y2="5"></line>
            <polyline points="5 12 12 5 19 12"></polyline>
        </svg>
    </button>

    <main class="fade-in">
        <section id="about">
            <div class="text">
               <h3 class="animate" data-fr="- Je suis" data-en="- I am">- I am</h3> 
               <h1 class="animate" >Samy .</h1>
               <p class="animate" data-en="I am a 17-year-old aspiring developer. Currently in first grade, I work on many projects in my free time. I want to learn new skills to improve my abilities." data-fr="Je suis un futur developeur de 17 ans. Actuellement en 1ère année d'école supérieur, je travail sur plusieurs projets pendant mon temps libre. Je souhaite apprendre de nouvelles compétences pour améliorer mes capacités.">
                I am a 17-year-old aspiring developer. Currently in first grade, I work on many projects in my free time. I want to learn new skills to improve my abilities.
            </p>
               <div class="clear-infos animate">
                    <div class="element">
                        <img src="./img/map-pin.svg" alt="">
                        <p>France - Paris</p>
                    </div>
                    <!-- <div class="element">
                        <img src="./img/calendar.svg" alt="">
                        <p data-fr="16 ans" data-en="16 years old">16 years old</p>
                    </div> -->

               </div>
            </div>
            <img class="animate me" src="./img/me2.png" alt="">
        </section>

        <section id="skills">
            <h3 class="animate" data-fr="Mes compétences" data-en="My Skills">My Skills</h3>
            <div class="carousel animate">
                <div class="group">
                    <img src="./img/languages/html5.svg" alt="">
                    <img src="./img/languages/css3.svg" alt="">
                    <img src="./img/languages/JS.svg" alt="">
                    <img src="./img/languages/Python.svg" alt="">
                    <img src="./img/languages/PHP.svg" alt="">
                </div>
                <div aria-hidden class="group">
                    <img src="./img/languages/html5.svg" alt="">
                    <img src="./img/languages/css3.svg" alt="">
                    <img src="./img/languages/JS.svg" alt="">
                    <img src="./img/languages/Python.svg" alt="">
                    <img src="./img/languages/PHP.svg" alt="">
                </div>
            </div>
            <div class="progress-bar">
                <div class="element animate from-bottom">
                    <img src="./img/languages/git.svg" alt="">
                    <div class="element-progress-bar">
                        <div class="dot ok"></div>
                        <div class="dot ok"></div>
                        <div class="dot ok"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                    </div>
                </div>
                <div class="element animate from-bottom">
                    <img src="./img/languages/github.svg" alt="">
                    <div class="element-progress-bar">
                        <div class="dot ok"></div>
                        <div class="dot ok"></div>
                        <div class="dot ok"></div>
                        <div class="dot ok"></div>
                        <div class="dot ok"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                    </div>
                </div>
            </div>
        </section>

        <section id="projects">
            <h2 class="animate from-left">Projects</h2>
            <div class="projects-container">
                <?php 
                unset($project);
                foreach ($projects as $project): ?>
                    <a href="/project?project=<?php echo $project['codeName']; ?>" class="project-card animate from-bottom">
                        <img src="./img/projects/<?php echo $project['codeName']; ?>.png" alt="<?php echo $project['codeName']; ?>.png" class="project-image">

                        <div class="infos">
                            <h3><?php echo $project['name']; ?></h3>
                            <div class="tags">
                                <?php foreach ($project['type'] as $type): ?>
                                    <span class="tag"><?php echo $type; ?></span>
                                <?php endforeach; ?>
                            </div>
                            <!-- <a href="/projects/<?php echo $project['codeName']; ?>" class="view-project">View Project</a> -->
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const screenWidth = window.screen.width;
                console.log('Screen width:', screenWidth);
                if (screenWidth <= 768) {
                    console.log("Mobile view detected, applying animations.");
                    const container = document.querySelector('.projects-container');
                    console.log('Container:', container);
                    container.classList.add('animate', 'from-bottom');
                    document.querySelectorAll('.project-card.animate.from-bottom').forEach(card => {
                        console.log('Card:', card);
                        card.classList.remove('animate', 'from-bottom');
                    });
                }
            });
        </script>
    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-about">
                <h3 data-en="About Me" data-fr="À Propos">About Me</h3>
                <p data-en="I am a 17-year-old aspiring developer based in Paris, France. I enjoy working on projects and learning new skills to improve my abilities." data-fr="Je suis un jeune de 17 ans passionné par le développement web.">I am a 17-year-old aspiring developer based in Paris, France. I enjoy working on projects and learning new skills to improve my abilities.</p>
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
                <div class="socials-links">
                    <a href="https://github.com/Xalri" target="_blank" aria-label="GitHub">
                        <img src="./img/languages/github.svg" alt="GitHub">
                    </a>
                    <a href="https://twitch.com/XalriTV" target="_blank" aria-label="Twitter">
                        <img src="./img/languages/twitch.svg" alt="Twitter">
                    </a>
                    <a href="https://linkedin.com" target="_blank" aria-label="LinkedIn">
                        <img src="./img/languages/linkedin.svg" alt="LinkedIn">
                    </a>
                </div>
            </div>
        </div>
    
        <div class="footer-bottom">
            <p>&copy; 2025 Samy. All rights reserved.</p>
        </div>
    </footer>
    <script src="script.js?random=<?php echo rand(); ?>"></script>
</body>
</html>