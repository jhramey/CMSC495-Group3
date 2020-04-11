# CMSC495-Group3

Topic: Create a consumer website to sell merchandise.

How to use the docker setup:
1. Install docker
2. Ensure git repository on host is up to date with "dockertesting" branch
3. Open git repository on host in a command prompt
4. Run "docker-compose up -d". This will install dependancies needed for containers and start the containers.
5. Wait a couple minutes for the dependancies to install (only will do once) and for the database to connect to the web server.
6. Open a web browser and type "localhost" (site is running on http or port 80). You can also go to "localhost:8080" to access the a gui to view the database (root - password).

Note: I have already populated 2 users into the database: JaneDoe - password and admin - P@ssw0rD!

To turn off containers open command prompt in the git repository on the host and type "docker-compose down".

Resources:
php files - https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php
