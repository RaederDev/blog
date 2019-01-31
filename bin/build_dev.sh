#!/usr/bin/env bash

cd "${0%/*}"
cd ..

docker build -t blog --build-arg USER_ID=$(id -u) --build-arg USER_NAME=$(whoami) -f docker-assets/Dockerfile .
