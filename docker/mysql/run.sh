#/bin/bash

action=$1

export DOCKER_NET=booking-net
export DOCKER_IMAGE_NAME="traqy/booking-miniapp-mysql"
export DOCKER_CONTAINER_NAME="booking-miniapp-mysql"

mount_dir=`pwd`/scripts

if [ "$action" = "rebuild" ]; then
    docker ps -a | grep "${DOCKER_CONTAINER_NAME}" | awk '{print $1}' | xargs docker rm
    docker run -d --net $DOCKER_NET -v "$mount_dir":/root/scripts -p 3306:3306 --ip 172.20.0.2 --name=$DOCKER_CONTAINER_NAME --privileged ${DOCKER_IMAGE_NAME} /root/scripts/run-mysql.sh
else
    docker stop $DOCKER_CONTAINER_NAME
    docker start $DOCKER_CONTAINER_NAME
    docker ps
fi
