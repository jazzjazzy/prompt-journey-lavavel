## To install and run DEV environment

Install assume you have git, docker, docker-compose and Composer installed


1: clone the package
```bash
git clone http://[ user ]:[ token ]@github.com/jazzjazzy/prompt-journey-lavavel.git
```
```bash 
cd prompt-journey-lavavel 
```
todo: correct the spelling in github

2: add .env file
```bash
cp .env.example .env
```
3: install composer

we need to install composer first, as we need to add vendor folder to the project
as it us using docker-compose setup uses config files found in vendor\lavarel
```bash
 composer install
```
if you are on windows, you may need to run this will as something will not install so we force it for now  
```bash
 composer install --ignore-platform-reqs --no-scripts
```
4: start docker-compose

```bash
docker-compose up -d
```
  -- or --
- run npm script 'docker up' in your IDE

5: rerun composer install

now we rerun the Composer install need on the docker container to make sure all the packages are installed 
```bash
docker exec -it prompt-journey-app composer install
```

5: install npm packages
we also install npm packages on the docker container
```bash
docker exec -it prompt-journey-app npm install
```      
6: start npm app
and then start the app on the docker container
```bash
docker exec -it prompt-journey-app npm run dev
```
-- or --    
- run npm script 'docker-dev' in your IDE

7: run migrations
and then run the migrations on the docker container, --seed will also seed the database
```bash
docker exec -it prompt-journey-app php artisan migrate --seed
```
