FROM node:15.14-alpine

ARG UID
RUN if [ -z "$UID" ]; then echo "Build argument 'UID' was not set" 1>&2 && exit 1; fi

RUN echo "dev:x:$UID:$UID::/home/dev:" >> /etc/passwd \
    && echo "dev:!:$(($(date +%s) / 60 / 60 / 24)):0:99999:7:::" >> /etc/shadow \
    && echo "dev:x:$UID:" >> /etc/group \
    && mkdir /home/dev && chown dev: /home/dev

ENV PATH="/home/dev/.yarn/bin:/home/dev/.config/yarn/global/node_modules/.bin:${PATH}"

USER dev

WORKDIR /var/www
