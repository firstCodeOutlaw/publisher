#!/usr/bin/env bash

# queues to be created
QUEUES=('notifications')

# this function returns the value of an environment variable.
# get_env_value($env_variable, $search_result)
# e.g. get_env_value("AMQP_USER", ENV)
get_env_value() {
    IFS='='
    # use grep to search for $1 in search result
    result="$(grep "$1" <<< "$2")"
    read -a array <<< "$result";
    echo "${array[1]}";
}

# check .env file for AMQP_USER and AMQP_PASSWORD environment variables, get
# their values and assign them to local variables
search_result=$(grep -i "AMQP_USER\|AMQP_PASSWORD" .env)
amqp_user=$(get_env_value "AMQP_USER" "$search_result")
amqp_password=$(get_env_value "AMQP_PASSWORD" "$search_result")

# define commands for creating users, permissions and queues
CREATE_USER="rabbitmqctl delete_user test && rabbitmqctl add_user test 1234 && rabbitmqctl set_user_tags test administrator"
SET_PERMISSIONS="rabbitmqctl set_permissions -p / test \".*\" \".*\" \".*\""
CREATE_QUEUES="rabbitmqadmin -u $amqp_user -p $amqp_password -V / declare queue name=${QUEUES[0]}"
CREATE_EXCHANGE="rabbitmqadmin -u $amqp_user -p $amqp_password -V / declare exchange name='my_exchange' type=fanout"
BIND_QUEUES_TO_EXCHANGE="rabbitmqadmin -u $amqp_user -p $amqp_password -V / declare binding source='my_exchange' \
destination=${QUEUES[0]}"

# execute the command in a RabbitMQ container shell
docker exec -it rabbitmq bash -lic "$CREATE_USER && $SET_PERMISSIONS && $CREATE_EXCHANGE && $CREATE_QUEUES && \
$BIND_QUEUES_TO_EXCHANGE"
