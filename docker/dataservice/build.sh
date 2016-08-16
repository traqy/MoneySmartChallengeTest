#/bin/bash

DOCKER_IMAGE_NAME="traqy/booking-miniapp-dataservice"
DOCKER_CONTAINER_NAME="booking-miniapp-dataservice"

docker build -t=$DOCKER_IMAGE_NAME .
