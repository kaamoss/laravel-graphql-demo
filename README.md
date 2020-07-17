## Laravel Test Project with Doctrine and rebing GraphQL

After you check this out, you should copy `.env.example` to `.env` in the project root. 
You also need to set permissions on storage `chmod -R 777 storage`. 

You should be able to run `docker-compose up` from the project root. 
After it is up, don't forget to run `composer install` either on directly on your host machine or by bashing into the foo-api-app container.
You will also need to run  `php artisan key:generate` to generate an app key in your .env file




