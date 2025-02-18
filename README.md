<div style="display: flex; justify-content: center; text-align: left; margin-top: 20px">
    <img src="./docker/web/images/logos/logoButify.png" width="100" style="margin-right: 20px;">
    <div>
        <h3 style="margin-bottom: 5px; color: #EE964B">Butify</h3>
        <h5 style="margin: 0; color: white">Plateforme de musique</h5>
    </div>
</div>

## Installation:

    npm install

    Windows:
        npm run docker

    Linux:
        cd docker
        docker compose up --build -d

    Tests: npm run tests

    Mobile(./mobile): Suivre le tutoriel.

## Lien d'accès avec Docker:

### Documentation

[Documentation API](http://localhost:8084/docs/api/index.html)

[Documentation Mobile](http://localhost:8084/docs/mobile/index.html)

### Web

[Web (page de connexion)](http://localhost:8080/web/login.php)

[Web (page personnel)](http://localhost:8080/web/home)

### Admin

[Admin (page de connexion)](http://localhost:8080/web/admin/login.php)

### Autre

[Phpmyadmin](http://localhost:8083)

## Base de donnée:

Utilisation de l'interface pour le [SCRIPTING (Docker)](http://localhost:8080/web/scripting/index.php). Où importer le fichier ./docker/example.sql dans la base de données.

## Information de connexion:

### Admin:

    admin@admin.com
    butify

### Tous les autres comptes:

    Voir les adresses mail dans la base de données
    butify
