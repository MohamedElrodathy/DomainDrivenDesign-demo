#!/usr/bin/env bash

# Wrapper for the composer command line tool.


# Exit immediately if a command exits with a non-zero status.
set -e

SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
PROJECT_DIR="$( cd "$( dirname "${SCRIPT_DIR}" )" && pwd )"

cd "${PROJECT_DIR}"

# Print commands and their arguments as they are executed.
set -x

docker-compose exec -T php composer $*

cd - &>/dev/null
