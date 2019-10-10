# Demo of escaping shell commands and arguments in PHP

This project runs in Docker and demonstrates how to escape strings intended to be interpreted by a shell.

## Running the project

Use these commands to run the project

    cd docker
    docker-compose up -d
    docker exec -it php /bin/bash
    php index.php

Cave Emptor: It's safest to experiment with this on a disposable VM, or otherwise simply avoid using destructive shell commands when testing.