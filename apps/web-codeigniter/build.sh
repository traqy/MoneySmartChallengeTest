#/bin/bash

DOCKER_IMAGE_NAME="traqy/booking-miniapp-web-ci"
DOCKER_CONTAINER_NAME="booking-miniapp-web-ci"

docker build -t=$DOCKER_IMAGE_NAME .
