FROM ubuntu:14.04

# Keep upstart from complaining
RUN dpkg-divert --local --rename --add /sbin/initctl
RUN ln -sf /bin/true /sbin/initctl

# Let the conatiner know that there is no tty
ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update
RUN apt-get -y upgrade

# Setup Basic tools
RUN apt-get install -y telnet wget curl

# Setup MySQL Server
RUN apt-get install -y mysql-server

# Copy my.cnf
COPY ./etc/my.cnf /etc/mysql/my.cnf

# Copy scripts
RUN mkdir -p /root/scripts
