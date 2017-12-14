#!/bin/bash

if [[ -z "$1" ]]; then
	serverAddr="0.0.0.0:8080"
else
	serverAddr="$1"
fi

cd  $(dirname $0)
php --server "$serverAddr" --docroot public public/router.php

