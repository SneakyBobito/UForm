#!/bin/bash

set -e

SCRIPTFILE=$(readlink -f "$0")
SCRIPTDIR=$(dirname "$SCRIPTFILE")

phpunit --debug -c "$SCRIPTDIR/../../phpunit.dist.xml" --coverage-clover "$SCRIPTDIR/../../build/logs/clover.xml" --process-isolation

[ "$PROCESS_CODECLIMAE" = true ] &&  ./vendor/bin/test-reporter