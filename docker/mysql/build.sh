#/bin/bash

DOCKER_IMAGE_NAME="traqy/booking-miniapp-mysql"
DOCKER_CONTAINER_NAME="booking-miniapp-mysql"

docker build -t=$DOCKER_IMAGE_NAME .
