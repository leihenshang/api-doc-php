FROM golang:alpine as builder

# set the work directory
WORKDIR /app

# set enviroment to enable the go module mode
RUN go env -w GO111MODULE=on \
&& go env -w GOPROXY="https://goproxy.cn, direct"

# copy project files from "context".
COPY . /app/
# compile
RUN CGO_ENABLED=0 GOOS=linux go build -o /app/main /app/


# ---------------------------------------------------------------
# setup 2 build
FROM alpine:latest as prod

#RUN apk --no-cache add ca-certificates

# define the expose port
EXPOSE 9091

# switch to the work dirctory
WORKDIR /app

# copy the binary excutable
COPY --from=0 /app/main .

# the command executed when the container is started 
CMD [ "/app/main","-addr=:9091" ]



