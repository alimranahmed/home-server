#!/bin/bash

# Get hostname, IP, and OS version
HOST_NAME=$(hostname)
HOST_IP=$(hostname -I | awk '{print $1}')
HOST_OS=$(lsb_release -d | awk -F'\t' '{print $2}')

# Write to .env file
cat <<EOF > .env
HOST_NAME=$HOST_NAME
HOST_IP=$HOST_IP
HOST_OS=$HOST_OS
EOF

echo ".env file generated"

# Run the docker container
docker compose up -d

