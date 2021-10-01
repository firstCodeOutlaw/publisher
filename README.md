## About Publisher

## Installation
### Clone application
- Clone from GitHub

### Install Docker and Configure Bash
- Install [Docker](https://docs.docker.com/engine/install/) (for Linux) or [Docker Desktop](https://www.docker.com/products/docker-desktop) for another OS
- `cd` into application directory and run `vendor/bin/sails up` to start application. 
You may want to configure a bash alias so that you may execute Sail commands by simply typing `sail` instead of the 
long `vendor/bin/sails up` command.
- To configure a bash alias for Sail, `cd` into application directory and run 
`alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'` for as long as the terminal lasts. 
Henceforth, you'll be able to start the application using `sail up`.
- Once the application's Docker containers have been started, you can access the application in your web browser at: http://localhost

### Edit Environment Variables
- Edit `.env`: get your INET address and use it as the value of `DB_HOST`. You can use `hostname -I | awk '{print $1}'` to get 
an INET address on Linux machines

### Run _setup.sh_ script
- Run the command `. setup.sh` to set up RabbitMQ queues and other configurations

### Running the application
Use an API testing tool such as Postman to make a POST request to http://localhost/api/publish/topic1.
Ensure that you pass the JSON data below as request body:
```
{
    "msg": "you can enter any string e.g. hello"
}
```
The message will be published to messaging queue and transmitted to the concerned services.

## License
Unlicensed
