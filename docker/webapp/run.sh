#/bin/bash

action=$1

export DOCKER_NET=booking-net
export DOCKER_IMAGE_NAME="traqy/booking-miniapp-nodejs"
export DOCKER_CONTAINER_NAME="booking-miniapp-nodejs"

cwd=`pwd`
booking_webb_path=`cd ../../apps/webapp && pwd && cd $cwd`

docker ps -a | grep "${DOCKER_CONTAINER_NAME}" | awk '{print $1}' | xargs docker rm

if [ "$action" = "shell" ]; then
    docker run -it --net $DOCKER_NET -v "$booking_webb_path":/usr/src/app -p 8080:8080 --ip 172.20.0.4 --name=$DOCKER_CONTAINER_NAME --privileged ${DOCKER_IMAGE_NAME} /bin/bash
else
    docker run -d  --net $DOCKER_NET -v "$booking_webb_path":/usr/src/app -p 8080:8080 --ip 172.20.0.4 --name=$DOCKER_CONTAINER_NAME --privileged ${DOCKER_IMAGE_NAME} /usr/src/app/start-node.sh
fi
