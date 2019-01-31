#!/usr/bin/env bash

cd "${0%/*}"
cd ..

ip=$(ifconfig | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*' | grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1' | grep -v '172.*')

docker run --rm \
    --name blog \
    -v "$(pwd)/blog":/srv \
    -v "$(pwd)/docker-assets/Caddyfile":/etc/Caddyfile \
    -p 8080:2015 \
    --add-host "parent:$ip" \
    blog
