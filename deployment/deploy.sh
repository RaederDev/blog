#!/usr/bin/env bash

ssh benni@raeder.technology << EOL
cd /home/benni/craft-blog && \
git pull && \
cd blog/frontend && \
npm ci && \
gulp
EOL
rm /tmp/deploy_rsa
