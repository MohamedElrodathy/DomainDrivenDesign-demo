#!/usr/bin/env bash

# Exit immediately if a command exits with a non-zero status.
set -e

CURRENT_USER_DIR="$(pwd)"
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
PROJECT_DIR="$( cd "$( dirname "${SCRIPT_DIR}" )" && pwd )"

# Print commands and their arguments as they are executed.
set -x

cd "${PROJECT_DIR}"

[ ! -f .env ] && cp .env.dist .env

docker-compose build
docker-compose up -d

sleep 2

cd - &>/dev/null
cd "${SCRIPT_DIR}"

# composer always returns 129
set +e
./composer.sh install
set -e
./browser.sh

cd - &>/dev/null
