# Camagru

An Instagram like web application allowing you to make basic photo editing using your webcam and some predefined images. Project part of the web branch at 42 school. No libraries were allowed (both in front and back).

## ✅ Goal

The goal of this project was to have practice with:

 * Create responsive layouts and page design
 * Secure website (no SQL-, HTML injections, plain passwords in the databases)
 * Authorized languages:
    [Server] PHP
    [Client] HTML - CSS - JavaScript (only with browser native API)
 * MYSQL with PDO
 * Firefox and Chrome support

## ✅ Tech stack!

* Frontend:
    * HTML
    * CSS/Bootstrap 4
    * Javascript
    * AJAX
* Backend:
    * PHP
    * MySQL

## ✅ Functionality

<details>
  <summary>User features</summary>
  <br>

  * Register / Login (including activating account and  resetting password through a unique link send by email).
  * User profile page.
  * User data management: modify user data (username, email,  password), delete and create images, set notification  preferences.
</details>

<details>
  <summary>Gallery features</summary>
  <br>

  * All images are public and likeable and comment able by logged in users.
  * Once image is commented or liked the author is notified by email.
</details>

<details>
  <summary>Editing features</summary>
  <br>

  * Create custom images using webcam or images downloaded from computer combined with filters.
</details>

<br>

## 🚀 Getting started

<br>

* You will need to have a local webserver on your machine, for example install [mamp](https://bitnami.com/stack/mamp)
* Then you can clone this repo in your mamp/apache2/htdocs directory for MAMP server.
* Change config/config.php, config/database.php, & config/db_connection.php file with your mySqlAdmin credentials.
* Start your server and open http://localhost/your_name_of_folder/index.php.php to fire up the project.
* Make sure you can send email from terminal. Here is a good link to POSTFIX configuration if you have [macOS](https://gist.github.com/loziju/66d3f024e102704ff5222e54a4bfd50e)
* Once your database is created you can create an account and ENJOY.


## ✌ Found a bug? Missing a specific feature?

* Feel free to file a new issue with a respective title and description on the repository.

## 🙋‍♀️ Authors

[Tasmia Rahman](https://github.com/tasmiarahmantanjin)
