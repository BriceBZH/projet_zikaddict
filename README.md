# Zik Addict

## Description

Zik Addict is a web application designed for music album collectors. Its primary goal is to allow users to catalog their albums and create wishlists of albums they wish to acquire. By generating these lists in practical formats such as Word, Excel, or PDF, Zik Addict simplifies the management and organization of music collections.

With a provided database, Zik Addict also enables users to discover new artists or albums from familiar artists, enriching their music experience.

## Features

- Cataloging music albums.
- Creating wishlists of desired albums.
- Generating lists in Word, Excel, and PDF formats.
- Discovering new artists and albums through a provided database.
- Simplified management and organization of music collections.
- Utilization of Sass for styling.

## Technologies

- **Framework**: Symfony 7.0.4
- **Language**: PHP
- **Database**: MySQL / PostgreSQL / SQLite
- **Front-end**: HTML, CSS (Sass), JavaScript
- **Exports**: Word, Excel, PDF

## Installation

### Prerequisites

- PHP 7.4 or higher
- Composer
- Symfony CLI
- Web server (Apache, Nginx, etc.)
- Database (MySQL, PostgreSQL, SQLite, etc.)

### Installation Steps

1. Clone the repository:
    ```bash
    git clone https://github.com/BriceBZH/projet_zikaddict.git
    cd projet_zikaddict
    ```

2. Install dependencies:
    ```bash
    composer install
    ```

3. Configure environment variables:
    ```bash
    cp .env.example .env
    ```
    Update `.env` with your database and other configuration settings.

4. Import the database from the provided dump:
    ```bash
    mysql -u root -p ma_base_de_donnees < dump/mon_dump.sql
    ```
    Replace `ma_base_de_donnees` with your database name and adjust the command based on your database management system.

5. Start the Symfony development server:
    ```bash
    symfony serve
    ```
    Access the application via `http://localhost:8000`.

## Usage

1. **Album cataloging**: Add your favorite music albums to your personal collection.
2. **Wishlist creation**: Create and manage lists of albums you want to acquire.
3. **List exports**: Export your lists in Word, Excel, or PDF format for easier management.
4. **Music discovery**: Utilize the database to discover new artists and albums.

## Contribution

Contributions are welcome! To contribute:

1. Fork the project.
2. Create a feature branch (`git checkout -b feature/my-feature`).
3. Commit your changes (`git commit -m 'Added my feature'`).
4. Push to the branch (`git push origin feature/my-feature`).
5. Open a pull request.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## Authors

RUBEAUX Brice

---

Thank you for using Zik Addict!
