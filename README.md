# RabbitMQTinker

Tinkering around with RabbitMQ as an async messaging bus between services.


# Setup
```sh
git clone https://github.com/twentysix22/rabbitmqtinker.git
cd rabbitmqtinker
./setup/setup.sh
```
> **Note:** The setup script can take a few minutes - please be patient.  Once finished the script starts the service, performs migrations, and exposes the public endpoint.

# Usage

Eg request a user -  http://localhost:3000/getUser/1


You can also:
  - Stop services
```sh
$ ./setup/stop.sh
```
  - Start services -
```sh
$ ./setup/start.sh
```

# Tests

```sh
$ ./setup/test.sh
```


### Todos

 - Write MORE Tests! - only a few have been added.
