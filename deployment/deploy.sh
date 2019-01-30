#!/usr/bin/env bash

ssh benni@raeder.technology << EOL
cd /var/www/blog/ && \
git pull && \
cd blog/frontend && \
npm ci && \
gulp && \
cd .. && \
php composer.phar install
EOL
rm /tmp/deploy_rsa
