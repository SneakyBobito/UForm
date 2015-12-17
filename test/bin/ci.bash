#!/bin/bash

set -e

SCRIPTFILE=$(readlink -f "$0")
SCRIPTDIR=$(dirname "$SCRIPTFILE")

phpunit -c "$SCRIPTDIR/../../phpunit.dist.xml" --coverage-clover "$SCRIPTDIR/../../build/logs/clover.xml"

$SCRIPTDIR/phpcs.bash $1


if [ "$PROCESS_CODECLIMAE" = true ] && [ "${TRAVIS_PULL_REQUEST}" = "false" ] && [ "${TRAVIS_BRANCH}" = "master" ]
then
    ./vendor/bin/test-reporter
fi


if [ "$PUBLISH_DOCUMENTATION" = true ] && [ "${TRAVIS_PULL_REQUEST}" = "false" ] && [ "${TRAVIS_BRANCH}" = "master" ]
then
    composer global require couscous/couscous

fi
