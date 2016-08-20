#/bin/bash

action=$1

export DOCKER_NET=booking-net
export DOCKER_IMAGE_NAME="traqy/booking-miniapp-web-ci"
export DOCKER_CONTAINER_NAME="booking-miniapp-web-ci"

booking_app_path=`pwd`/booking

docker ps -a | grep "${DOCKER_CONTAINER_NAME}" | awk '{print $1}' | xargs docker rm

docker run -it --net $DOCKER_NET \
  -v "$booking_app_path":/var/www/booking -p 80:80 --ip 172.20.0.8 \
  --name=$DOCKER_CONTAINER_NAME \
  --add-host booking.techtest-moneysmart.com:172.20.0.8 \
  --privileged ${DOCKER_IMAGE_NAME} /bin/bash

