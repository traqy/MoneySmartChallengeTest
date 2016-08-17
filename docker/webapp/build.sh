#!/bin/bash

DOCKER_IMAGE_NAME="traqy/booking-miniapp-nodejs"
DOCKER_CONTAINER_NAME="booking-miniapp-nodejs"

docker build -t=$DOCKER_IMAGE_NAME .
