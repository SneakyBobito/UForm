#!/bin/bash

echo -en "\e[32m"
read -p "Dont you want to fix code standard automatically? [y/N] " -n 1 -r
echo -e "\e[0m"
if [[ ! $REPLY =~ ^[Yy]$ ]]
then
    echo "Aborting..."
    exit 1
fi


SCRIPTFILE=$(readlink -f "$0")
SCRIPTDIR=$(dirname "$SCRIPTFILE")

cd $SCRIPTDIR/../.. && $SCRIPTDIR/../../vendor/bin/phpcbf --standard="$SCRIPTDIR/../../test/phpcs/ruleset.xml"