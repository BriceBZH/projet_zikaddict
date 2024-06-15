# Zik Addict

## Description

Zik Addict est une application web conçue pour les collectionneurs d’albums de musique. L'objectif principal est de permettre aux utilisateurs de référencer leurs albums et de créer des listes d'albums qu'ils cherchent à acquérir. En générant ces listes dans des formats pratiques tels que Word, Excel ou PDF, Zik Addict simplifie la gestion et l'organisation des collections musicales.

Avec une base de données fournie, Zik Addict permet également aux utilisateurs de découvrir de nouveaux artistes ou des albums d’artistes déjà connus, enrichissant ainsi leur expérience musicale.

## Fonctionnalités

- Référencement d'albums de musique.
- Création de listes d'albums recherchés.
- Génération de listes en formats Word, Excel et PDF.
- Découverte de nouveaux artistes et albums grâce à une base de données fournie.
- Gestion et organisation simplifiées des collections musicales.
- Utilisation de Sass pour le style.

## Technologies

- **Framework** : Symfony 7.0.4
- **Langage** : PHP
- **Base de données** : MySQL / PostgreSQL / SQLite
- **Front-end** : HTML, CSS (Sass), JavaScript
- **Exports** : Word, Excel, PDF

## Installation

### Prérequis

- PHP 7.4 ou supérieur
- Composer
- Symfony CLI
- Serveur web (Apache, Nginx, etc.)
- Base de données (MySQL, PostgreSQL, SQLite, etc.)

### Étapes d'installation

1. Clonez le dépôt :
    ```bash
    git clone https://github.com/BriceBZH/projet_zikaddict.git
    cd projet_zikaddict
    ```

2. Installez les dépendances :
    ```bash
    composer install
    ```

3. Configurez les variables d'environnement :
    ```bash
    cp .env.example .env
    ```
    Mettez à jour `.env` avec les paramètres de votre base de données et autres configurations nécessaires.

4. Importez la base de données depuis le dump fourni :
    ```bash
    mysql -u root -p ma_base_de_donnees < dump/mon_dump.sql
    ```
    Remplacez `ma_base_de_donnees` par le nom de votre base de données et ajustez la commande en fonction de votre système de gestion de base de données.

5. Lancez le serveur de développement Symfony :
    ```bash
    symfony server:start
    ```
    Accédez à l'application via `http://localhost:8000`.

## Utilisation

1. **Référencement d'albums** : Ajoutez vos albums de musique préférés à votre collection personnelle.
2. **Création de listes** : Créez et gérez des listes d'albums que vous souhaitez acquérir.
3. **Export des listes** : Exportez vos listes au format Word, Excel ou PDF pour une gestion plus facile.
4. **Découverte musicale** : Utilisez la base de données pour découvrir de nouveaux artistes et albums.

## Contribution

Les contributions sont les bienvenues ! Pour contribuer :

1. Forkez le projet.
2. Créez une branche pour votre fonctionnalité (`git checkout -b feature/ma-fonctionnalité`).
3. Commitez vos changements (`git commit -m 'Ajout de ma fonctionnalité'`).
4. Poussez vers la branche (`git push origin feature/ma-fonctionnalité`).
5. Ouvrez une Pull Request.

## Licence

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

## Auteurs

RUBEAUX Brice

---

Merci d'utiliser Zik Addict !
