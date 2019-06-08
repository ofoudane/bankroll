# bankroll
## Introduction
Ce site représente pour moi, ma première expérience en développement Web. Grâce à ce projet qui a duré une semaine, j'ai pû appliquer mes connaissances en développement Web.
Vous pouvez tester ce site web sur le lien suivant  : http://ofoudane.a2hosted.com/bankroll/ .
## Installation
Afin de tester ce site web en local, vous devrez suivre les étapes suivantes :
1. Sous une base de données PostgreSQL, lancez la commande \i Install.sql pour préparer la base de données du site web. 
2. Copiez le contenu du répertoire Web dans votre serveur Web.
3. Assurez que le répertoire bankroll-connect soit placer dans le même répertoire parent vers lequel vous avez copié le contenu du répertoire Web.
4. Testez le site web.

Notez-bien que l'utilisateur "bankroll:B@nkr01l" est utilisé lors de la connexion à la base de données "bankroll", sur laquelle sont enregistrées les données receuillies du site web. Vous pouvez changer cet utilisateur, ainsi que la base de données utilisée, en mettons à jour les fichiers Install.sql et bankroll-connect/db-connect.php.

## Langages/Librairies employés
Pour réaliser ce site, j'ai utilisé plusieurs langages de programmation et de balisage, à savoir : 
* Front-end : Javascript, HTML et CSS.
* Back-end  : PHP et PL/pgSQL.
J'ai aussi employé des librairies javascript, notamment:
* JQuery : Pour manipuler plus facilement, les noeuds présents sur une page web et éxecuter les requêtes Http (GET et POST).
* Chart.js : Pour ajouter une visualisation graphique des données.
* Owl-Carousel.
