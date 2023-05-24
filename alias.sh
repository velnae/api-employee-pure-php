#!/bin/bash
DOCKER_COMPOSE_PATH=".docker"
source ${DOCKER_COMPOSE_PATH}/.env
DOCKER_PHP="${APP_NAME}-php"

# php composer
alias composer="U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_PHP} composer";

# PHP
alias php="U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_PHP} php";

# CI3 - bin/console
alias cli="U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_PHP} php /var/www/html/cli";