#!/usr/bin/env bash

function cd_project_root()
{
    local dir="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && cd ../.. && pwd )"

    cd "${dir}"
}
