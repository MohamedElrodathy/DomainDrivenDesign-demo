#!/usr/bin/env bash

function container_status()
{
    local status=
    local file=$(mktemp)
    cd_project_root
    docker-compose ps | tail -n +3 > "${file}"

    if [ "$(cat "${file}"|wc -l)" -eq 0 ]
    then
        printf "DOWN"
    elif [ "$(grep -v "Up" "${file}" | wc -l)" -ne 0 ]
    then
        printf "FAIL"
    else
        printf "UP"
    fi

    rm "${file}"
}

function container_build()
{
    local show_command="$1"

    [ "${show_command}" -eq 1 ] && (set -x; docker-compose build) || docker-compose build
}

function container_up()
{
    local show_command="$1"
    local status=$(container_status)

    if [ "${status}" != "UP" ]
    then
        container_build ${show_command}
        [ "${show_command}" -eq 1 ] && (set -x; docker-compose up -d) || docker-compose up -d
        sleep 2
    fi
}

function container_down()
{
    local show_command="$1"
    local status=$(container_status)

    if [ "${status}" != "DOWN" ]
    then
        [ "${show_command}" -eq 1 ] && (set -x; docker-compose down) || docker-compose down;
    fi
}

function container_must_be_up()
{
    local status=$(container_status)
    cd_project_root

    printf "${COLOR_GREEN}Ensure containers are up... ${COLOR_NORMAL}"
    if [ "${status}" = "UP" ]
    then
        printf "${COLOR_YELLOW}OK${COLOR_NORMAL}\n"
        return
    fi

    printf "${COLOR_RED}FAIL${COLOR_NORMAL}\n"

    exit 1
}
