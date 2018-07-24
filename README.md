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
$ ./setup/rabbitlisten.sh
```

# Tests

```sh
$ ./setup/test.sh
```
> **Note on tests:** Only a couple of tests have been added and include both functional and unit.  Services MUST be running for tests to run.  Normally should separate unit from functional - but time limitations etc etc...

### Todos

 - Write MORE Tests! - only a few have been added.
