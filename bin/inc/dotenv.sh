#!/usr/bin/env bash

function dotenv_has_diverged()
{
    cd_project_root
    if [ ! -f .env ]
    then
        false

        return
    fi
    diff .env .env.dist &>/dev/null

    if [ $? -ne 0 ]
    then
        true

        return
    fi

    false
}

function user_wants_to_override_dotenv()
{
    local response=

    read -r -p "Do you want to override your .env file? [Y/n] " response
    if [ -z "${response}" ]
    then
        response="Y"
    fi

    case "${response:0:1}" in
        [yY])
            true
            ;;
        *)
            false
            ;;
    esac
}

function dotenv_manage()
{
    cd_project_root
    if (set +e;dotenv_has_diverged) && user_wants_to_override_dotenv
    then
        rm .env
    fi

    [ ! -f .env ] && (set -x; cp .env.dist .env)

    return 0
}
