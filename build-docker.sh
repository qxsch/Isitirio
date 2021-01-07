#!/bin/bash
cd Docker
docker build --file Dockerfile-Cli -t php:8-cli-pgsql .
docker build --file Dockerfile-Apache -t php:8-apache-pgsql .

