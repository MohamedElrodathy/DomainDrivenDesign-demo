#!/usr/bin/env bash

# Exit immediately if a command exits with a non-zero status.
set -e

CURRENT_USER_DIR="$(pwd)"
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
PROJECT_DIR="$( cd "$( dirname "${SCRIPT_DIR}" )" && pwd )"

# Print commands and their arguments as they are executed.
set -x

cd "${PROJECT_DIR}"

docker-compose down

cd - # will keep history