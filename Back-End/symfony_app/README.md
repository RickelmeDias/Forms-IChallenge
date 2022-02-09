## Docker pattern created by Paulo:
https://github.com/paulopmt1/docker-symfony-environment

## PHP 7.4 with Apache:
This docker runs Symfony applications through apache and php-7.4

## Docker and docker-compose install:
First, you'll need docker and docker-compose:
- [Install Docker](https://docs.docker.com/install/)
- [Install docker compose](https://docs.docker.com/compose/install/)

## How to run this back-end symfony api:
1. Clone this repository.
2. Enter on the folder: `cd docker-symfony-environment`
3. Start the environment: ```sudo docker-compose up -d```
4. Login on the container with ```sudo docker exec -it dev_apache_php74 /bin/bash```
5. Create the dot env file: 
```
APP_ENV=dev
APP_SECRET=
DATABASE_URL="mysql://root:root@dev_database:3306/my_database?serverVersion=5.7"
```
More informations about the database (Example on `http://localhost:8282`):
<details>
<img src="../../Images/database_example.png" />
</details>