Bonjours dans le partie Calendrier il vous faut:
1- un Editaire de text comme visual studio code
2- un serveur de base de donnee  de donne Wamp serveur
3-pour le creation de table de calendrier voila le scrpit SQL qui permet de cree un table calendrier:

CREATE TABLE calendrier(
    id int NOT null PRIMARY KEY  AUTO_INCREMENT,
    event_date date,
    details text,
    user_id int NOT null,
    constraint foreign key(user_id) REFERENCES users(id));


4- apres cree un dossier dans le dossier est deplace  dans votre Disque local comment ca : C:\wamp64\www\nomdevotredossier
5-de que vous fenis tout ca vous allez a vorte navigateur est vous allez ecrire  :localhost/nomdevotredossier
6-apres vous choisi le fichier calendrier.html
7-pour ajouter des événements click sur un date est ajouter vôtres événements 
deque vous ajouter un couleur vert vas aparet qui vous indique que il existe un événement 
8-pour modifier ou supprimer un événement existant vous click sur la date qui a un événement est modifié ou supprimé directement 
