# CMSC495-Group3

Topic: Create a consumer website to sell merchandise.

How to use Windows Docker setup (Only can use if you have Windows Pro or Enterprise):

1. Install docker
2. Ensure git repository on host is up to date with "dockertesting" branch
3. Open git repository on host in a command prompt
4. Run "docker-compose up -d". This will install dependancies needed for containers and start the containers.
5. Wait a couple minutes for the dependancies to install (only will do once) and for the database to connect to the web server.
6. Open a web browser and type "localhost" (site is running on http or port 80). You can also go to "localhost:8080" to access the a gui to view the database (root - password).

How to use Windows Docker Toolbox setup (For Windows Home):

1. Follow instructions at <https://docs.docker.com/toolbox/toolbox_install_windows/> (Step 1-3)
2. Launch "Docker Quickstart Terminal"
NOTE: USE THE DOCKER TERMINAL. Docker compose will only work in the docker terminal when using docker toolbox.
3. Clone repository from github "git clone <https://github.com/jhramey/CMSC495-Group3.git>"
4. Enter the repository in the terminal
5. While in the directory with the repository, list the directory (use "ls" since the docker terminal has bash) and make sure you see "docker-compose.yml". If you dont see the yml file, you are not in the correct directory.
6. Use the command "docker-compose up -d" to start the docker containers
7. When this is run the first time the device will install all the dependancies needed to run the containers.
8. When the terminal has the following statements "Creating XXXX ... done" where XXXX is the container name, the installation is completed and containers have started.
9. Verify that the containers are running by using the Kitematic. Running containers will show on the left side. Or you can use the command "docker container ls" to show active containers
10. Now that we know the containers are running, go to a browser and type in "http://192.168.99.100/" to access the project.
NOTE: For database admins use "http://192.168.99.100/:8080" to get to the Adminer container

Note: I have already populated 2 users into the database: JaneDoe - password and admin - P@ssw0rD!

To turn off containers open command prompt in the git repository on the host and type "docker-compose down".

Resources:
php files - <https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php>
