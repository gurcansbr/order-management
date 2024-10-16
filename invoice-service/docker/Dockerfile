FROM --platform=linux/amd64 golang:1.21.4

RUN apt-get update && \
    apt-get install -y gcc g++ librdkafka-dev bash

WORKDIR /app

COPY go.mod go.sum ./

RUN go mod download

COPY . .

RUN go build -o /build

EXPOSE 3000

CMD [ "/build" ]