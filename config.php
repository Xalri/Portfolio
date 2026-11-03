<?php 
// https://www.linkedin.com/in/samy-teilloux-751096326
$projects = [
    [
        'name' => "NOPLP Lyrics", 
        'description-en' => "An application designed to display the lyrics of songs for the French TV show &quot; N'Oubliez Pas Les Paroles &quot; from NOPLP Wiki Fandom.", 
        'description-fr' => "Une application conçue pour afficher les paroles des chansons de l'émission de télévision française &quot; N'Oubliez Pas Les Paroles &quot; du wiki .",
        'description-long-fr' => "NOPLP Lyrics est une application python basé sur PySimpleGui et Tktinter permettant d'afficher les paroles des chansons de l'émission &quot; N'Oubliez Pas Les Paroles &quot; depuis le WikiFandom. L'objectif de ce logiciel est d'afficher non pas les paroles officielles des chansons mais les paroles attendues par l'émission qui peuvent différer des paroles officielles. J'ai pour cela utilisé du WebScraping afin de récupérer automatiquement les paroles depuis le Wikifandom.",
        'description-long-en' => "NOPLP Lyrics is a Python application based on PySimpleGUI and Tkinter that displays the lyrics of songs from the show 'N'Oubliez Pas Les Paroles' using WikiFandom. The goal of this software is to show not the official lyrics, but the lyrics expected by the show, which may differ from the official ones. I used web scraping to automatically retrieve the lyrics from WikiFandom.",
        'codeName' => 'noplp-lyrics',
        'languages' => ['Python'],
        'tags' => ['SimplePyGUI', 'Web Scraping', 'Git', 'Github'],
        'date' => '2024-09-20',
    ],
    [
        'name' => "Bot Discord",
        'description-fr' => "J'ai fais quelques bot discord pour plein d'utilisation différente. Message automatique à chaqque sortie de vidéo youtube, système de moderation complet, giveaway, jeux, et plus.",
        'description-en' => "I made some discord bot for a a lot of purpose. Automatic message for each youtube video upload, whole moderation system, giveaway, games, and more.",
        'description-long-fr' => "Les bots discord que j'ai réalisé sont très variés. En effet, j'ai fais des bots  de modération afin de faciliter la gestion du serveur, des bots de loisir avec des commandes et des actions amusantes, ainsi que des bots utilitaires avec par exemple un système de ticket complet comprenant les permissions, la transcription et l'organisation des tickets. Pour cela j'ai eu recours à des bases de donnée MongoDB ainsi qu'a des APIs pour des notifications en cas de vidéo Youtube ou de live Twitch.",
        'description-long-en' => "The Discord bots I created are very diverse. I made moderation bots to help manage servers, fun bots with commands and entertaining actions, and utility bots such as a complete ticket system with permissions, transcription, and ticket organization. For this, I used MongoDB databases and APIs for notifications when a YouTube video is uploaded or a Twitch stream goes live.",
        'codeName' => 'discord-bot',
        'languages' => ['Javascript', 'NodeJS'],
        'tags' => ['DiscordJS', 'MongoDB'],
    ],
    [
        'name' => 'Pterodactyl Panel',
        'description-fr' => "J'ai installe un panel open-source appelé Pterodactyl. J'ai mis en place le panel avec plusieurs vps pour gérer une grande variété de services.",
        'description-en' => "I installed an open-source panel called Pterodactyl and configured it with multiple vps to manage a large variety of services.",
        'description-long-fr' => "Pterodactyl est un logiciel Open-Source permettant de deployer des serveurs de jeu et de les gérer depuis un panel. J'ai installé et configuré ce logiciel afin de pouvoir déployer mes propres serveurs de jeu et également de pouvoir m'initier aux systèmes Linux. Pterodactyl est mon premier projet en rapport avec Linux.",
        'description-long-en' => "Pterodactyl is open-source software that allows you to deploy and manage game servers from a panel. I installed and configured this software to deploy my own game servers and to get started with Linux systems. Pterodactyl was my first project related to Linux.",
        'codeName' => 'pterodactyl-panel',
        'languages' => [],
        'tags' => ['Docker', 'VPS', 'Open-Source', 'Server Management'],
    ],
    [
        'name' => 'Time Clicker',
        'description-en' => 'Time Clicker is a school project i made with 2 friends. It is a clicker game where you earn time units to gain timeline in order to discord new era.',
        'description-fr' => 'Time Clicker est un projet scolaire que j\'ai réalisé avec 2 amis. C\'est un jeu de clic où vous gagnez des unités de temps pour gagner une chronologie afin de découvrir une nouvelle ère.',
        'description-long-fr' => "Time Clicker est un projet que j'ai réalisé lors de mon année de Terminale. Il s'agit d'un jeu de type &quot; Clicker &quot; qui consiste à cliquer pour avoir plus de ressource. Ce projet a été réalisé à l'aide de 2 amis avec qui nous formions un groupe. J'ai pu apprendre à sécuriser les données utilisateurs, à gérer l'affichage, le rendu et l'optimisation ainsi que la création d'une version autonome dite &quot; Standalone &quot; pour windows et son installateur assoscié.",
        'description-long-en' => "Time Clicker is a project I made during my final year of high school. It is a clicker-type game where you click to get more resources. This project was made with two friends as a group. I learned how to secure user data, manage display, rendering, and optimization, as well as create a standalone version for Windows and its associated installer.",
        'codeName' => 'time-clicker',
        'languages' => ['Python'],
        'tags' => ['Pygame', 'Game Development', 'School Project', 'Github', 'Git'],
    ],
    [
        'name' => 'Portfolio',
        'description-en' => 'This portfolio is a project that I created to showcase my work and skills. It is built using HTML, CSS, JavaScript and a bit of PHP.',
        'description-fr' => 'Ce portfolio est un projet que j\'ai créé pour présenter mon travail et mes compétences. Il est construit en utilisant HTML, CSS, JavaScript et un peu de PHP.',
        'description-long-fr' => "Ce portfolio est un vrai challenge pour moi. Il me représente numériquement et permet de montrer ce dont je suis capable. J'ai passé beaucoup de temps à conçevoir le design de ce site en accord avec mon logo réalisé par Rex14. Cette deuxième version de mon portfolio réaliser en HTML/CSS/JS/PHP inclut une page de contact me permettant d'ouvrir une discussion depuis le site. Il inclut également une fonctionnalité de blog, fonctionnant à l'aide d'une base de donnée MySQL.",
        'description-long-en' => "This portfolio is a real challenge for me. It represents me digitally and allows me to show what I am capable of. I spent a lot of time designing the site to match my logo made by Rex14. This second version of my portfolio, made in HTML/CSS/JS/PHP, includes a contact page to start a conversation from the site. It also features a blog, powered by a MySQL database.",
        'codeName' => 'portfolio',
        'languages' => ['HTML', 'CSS', 'Javascript', 'PHP'],
        'tags' => ['Web Development'],
    ],
];

foreach ($projects as &$project) {
    $project['type'] = $project['languages'];
    foreach ($project['tags'] as $tag) {
        if(!in_array($tag, $project['type'])) {
            $project['type'][] = $tag;
        }
    }
    // echo "changed project type for: " . $project['name'] . "\n";
    // echo count($project['type']) . "\n";
};
// echo  var_export($projects, true);


$allTags = [
    '<img src="/img/languages/Python.svg" alt="an Image" >Python',
    '<img src="/img/languages/html5.svg" alt="an Image" >HTML',
    '<img src="/img/languages/css3.svg" alt="an Image" >CSS',
    '<img src="/img/languages/JS.svg" alt="an Image" >Javascript',
    '<img src="/img/languages/PHP.svg" alt="an Image" >PHP',
    '<img src="./img/languages/git-simple.svg" alt="an Image" >Git',
    '<img src="/img/languages/github.svg" alt="an Image" >Github',
    '<img src="/img/languages/nodejs.svg" alt="an Image" >NodeJS',
    '<img src="/img/languages/mongodb-simple.svg" alt="an Image" >MongoDB',
    '<img src="/img/languages/docker.svg" alt="an Image" >Docker',
    'Web Scraping',
    'VPS',
    'Open-Source',
    'Server Management',
    'Game Development',
    'School Project',
    'SimplePyGUI',
    'DiscordJS',
    'Pygame',
    'Web Development',
]
?>
