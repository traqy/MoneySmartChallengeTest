FROM node:argon

RUN apt-get update

# Install Basic
RUN apt-get install -y net-tools telnet wget curl

# Setup tinc VPN config
RUN apt-get install -y tinc
COPY ./etc/tinc/ /etc/tinc/

# Setup basic tools
RUN apt-get install -y curl telnet wget

# Create app directory
RUN mkdir -p /usr/src/app
WORKDIR /usr/src/app

# Install app dependencies
#COPY package.json /usr/src/app/
RUN npm install express passport-facebook 

# Bundle app source
#COPY . /usr/src/app

EXPOSE 8080
#CMD [ "npm", "start" ]