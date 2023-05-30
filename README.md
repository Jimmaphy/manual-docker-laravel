# Handmatig Laravel in Docker

Docker is een manier om te applicatie te draaien door middel van containers.
Voor school is het de opdracht om hiermee aan de slag te gaan.
Hoe docker geïnstalleerd en gebruikt wordt is na te kijken op de onderstaande link.
Dit is een pagina van mijn bedrijf waarmee ik instructies maak voor informatica.

[AMP Stack met Docker](https://github.com/De-Informatica-Student/docker-amp-stack)

## Laravel Installeren

Om laravel te installeren op deze installatie moeten we een aantal dingen doen.
We gebruiken dezelfde werkwijze als MySQL om Composer en Node te installeren.
Daarnaast moet er een wijziging worden aangebracht in de dockerfile.
De website van Laravel begint in de public map, hier moeten we naar verwijzen.
Hiervoor hebben we de volgende code nodig:

```dockerfile
# Set document root to public folder
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public 

# Replace the default apache root with ours
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf 
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Enable rewrite mod, this is required for Laravel to work
# Rewrite mod allows the app to change the way the server handles urls
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf 
RUN a2enmod rewrite
```

Vanaf dit punt kunnen we de console gebruiken om laravel te installeren.
We hebben de package managers ingesteld om automatisch alles voor ons te installeren.
Dit hebben we gedaan door hun composerfiles respectievelijk te wijzigen naar:

```dockerfile
# dockerfile.composer
FROM composer:latest
WORKDIR /var/app/
CMD [ "composer", "install" ]

# dockerfile.node
FROM node:20-alpine
WORKDIR /var/app/
CMD [ "npm", "install" ]
```

Voor deze opdracht is het gebruik van docker-compose niet toegestaan.
Ook is het niet toegestaan om package managers te installeren in de container.
Om onze mentale gezondheid te behouden heb ik daarom een PowerShell script geschreven.
Dit script zorgt ervoor dat de containers worden gebouwd en gestart.
Er is ook een script om de containers te stoppen en te verwijderen.

```powershell
# Build the images
docker build -t myapp .
docker build -t mydb -f dockerfile.mysql .
docker build -t mycomposer -f dockerfile.composer .
docker build -t mynode -f dockerfile.node .

# Create the network
docker network create -d bridge larwork

# Run the containers
docker run --name mycomposer -d -v ${PWD}/src/:/var/app/ mycomposer
docker run --name mynode -d -v ${PWD}/src/:/var/app/ mynode
docker run --name mydb --network larwork -d -v ${PWD}/data/:/var/lib/mysql/ mydb
docker run --name myapp --network larwork -d -p 8080:80 -v ${PWD}/src/:/var/www/html/ myapp
```

```powershell
# Stop the containers
docker stop myapp
docker stop mydb
docker stop mycomposer
docker stop mynode

# Remove everything
docker system prune
```

## CRUD

De laatste stap voor de opdracht is het maken van een crud opdracht.
Ik heb hiervoor een tabel gemaakt waar GitHub gebruikers in worden opgeslagen.
Deze zullen laten in het project gebruikt worden om gegevens van te laden.
