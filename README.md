# RabbitMQTinker

Tinkering around with RabbitMQ as an async messaging bus between services.

# Aim

1. Build a DataService:
- upon start, it should load provided CSV to memory,
- it should not be accessible from the browser,
- it should subscribe to a UserRequests topic on a pubsub like rabbitmq or redis,
- it should listen to GetUser messages on the pubsub and respond on UserResponses topic with UserData message(containing data of a given user) or UserNotFound message (if the user is not found)
2. Build an API/REST service:
- it should be accessible from the browser,
- it should not store any data,
- it should implement a GET endpoint: /getUser/$id, which should return a JSON with user details or 404 if user doesn't exist,
- upon receiving the request - it should send a GetUser message on the UserRequests topic, wait for DataService to respond via the UserResponses topic, and then the API should respond to the user with a JSON containing user data or 404

# Stack

- API service - laravel - public facing rest endpoint at http://localhost:3000
- RabbitMQ service as message bus.
- Userservice - laravel - Event driven responder to messages on RabbitMQ sent from API service. Easily extended to handle multiple event/request types arriving on the RabbitMQ bus.



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

 - Write more Tests! - only a few have been added - and split out unit and functional tests.
 - Configure logging output - ElasticSearch, Logstash/fluentd and Kibana stack - see https://github.com/deviantony/docker-elk
 - Write alternative Go and/or Node service example (http://localhost:3001)
 - Abstract DataService adapters so message bus can be swapped from RabbitMQ to any other messaging service - AWS SNS Topics etc.
