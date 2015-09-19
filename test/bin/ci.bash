#!/bin/bash

set -e

SCRIPTFILE=$(readlink -f "$0")
SCRIPTDIR=$(dirname "$SCRIPTFILE")

phpunit --debug -c "$SCRIPTDIR/../../phpunit.dist.xml" --coverage-clover "$SCRIPTDIR/../../build/logs/clover.xml" --process-isolation

$SCRIPTDIR/phpcs.bash $1

if [ "$PROCESS_CODECLIMAE" = true ]
then
    ./vendor/bin/test-reporter
fi