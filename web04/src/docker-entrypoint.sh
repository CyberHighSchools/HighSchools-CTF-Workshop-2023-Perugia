#!/bin/sh
set -e

if [ -f /usr/local/bin/init.sh ]; then
  /usr/local/bin/init.sh
  rm -f /usr/local/bin/init.sh
fi

exec "$@"
