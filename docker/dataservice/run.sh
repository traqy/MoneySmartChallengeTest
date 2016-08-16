#/bin/bash

action=$1

export DOCKER_NET=booking-net
export DOCKER_IMAGE_NAME="traqy/booking-miniapp-dataservice"
export DOCKER_CONTAINER_NAME="booking-miniapp-dataservice"

cwd=`pwd`
booking_app_path=`cd ../../apps/dataservice && pwd && cd $cwd`

docker ps -a | grep "${DOCKER_CONTAINER_NAME}" | awk '{print $1}' | xargs docker rm

if [ "$action" = "shell" ]; then
    docker run -it --net $DOCKER_NET -v "$booking_app_path":/root/apps/dataservice -p 5000:5000 --ip 172.20.0.3 --name=$DOCKER_CONTAINER_NAME --privileged ${DOCKER_IMAGE_NAME} /bin/bash
else
    docker run -d --net $DOCKER_NET -v "$booking_app_path":/root/apps/dataservice -p 5000:5000 --ip 172.20.0.3 --name=$DOCKER_CONTAINER_NAME --privileged ${DOCKER_IMAGE_NAME} /root/apps/dataservice/booking/run-flask-app.sh
fi

