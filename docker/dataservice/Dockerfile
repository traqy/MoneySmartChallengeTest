FROM ubuntu:14.04

# Keep upstart from complaining
RUN dpkg-divert --local --rename --add /sbin/initctl
RUN ln -sf /bin/true /sbin/initctl

# Let the conatiner know that there is no tty
ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update
RUN apt-get -y upgrade

# Setup basic tools
RUN apt-get install -y curl telnet wget

# Setup python and python modules
RUN apt-get install -y python2.7 python-setuptools python-flask python-mysql.connector python-cjson
RUN ln -sf /usr/bin/python2.7 /usr/bin/python

# Copy python scripts
RUN mkdir -p /root/apps/dataservice
