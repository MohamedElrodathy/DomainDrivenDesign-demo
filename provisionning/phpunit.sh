#!/usr/bin/env bash
# Opens a browser

# Exit immediately if a command exits with a non-zero status.
set -e

SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
PROJECT_DIR="$( cd "$( dirname "${SCRIPT_DIR}" )" && pwd )"
DOTENV_FILE="${PROJECT_DIR}/.env"

COLOR_NORMAL="\e[0;30m"
COLOR_RED="\e[0;31m"
COLOR_GREEN="\e[0;32m"
COLOR_YELLOW="\e[0;33m"

cd "${PROJECT_DIR}"

printf "${COLOR_GREEN}Ensure containers are up... ${COLOR_NORMAL}"
if [ "$(docker-compose ps | tail -n +3 | grep -q -v "Up" | wc -l)" -ne 0 ]
then
    printf "${COLOR_RED}FAIL${COLOR_NORMAL}\n"

    printf "${COLOR_YELLOW}You should consider starting the containers first.${COLOR_NORMAL}\n"

    exit 1
fi
printf "${COLOR_YELLOW}OK${COLOR_NORMAL}\n"

docker-compose exec php bash -c 'TEMP=$(mktemp); sed "s/^\(..*=..*\)$/export \1/g" .env > ${TEMP}; source ${TEMP}; php vendor/bin/phpunit; rm ${TEMP}'