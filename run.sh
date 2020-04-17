#! /bin/bash

DOCROOT="$(pwd)/public"
SERVER="$(pwd)/server.php"
HOST=127.0.0.1
PORT=8000
MYSQl=$(which mysql)
PHP=$(which php)

if [[ $? != 0 ]] ; then
echo "Unable to find PHP"
exit 1
elif [[ $MYSQL -ne 0 ]] ; then
echo "Unable to find MYSQL"
exit 1
fi

$PHP -S $HOST:$PORT -t $DOCROOT $SERVER