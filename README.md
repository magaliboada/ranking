## SOCIALPOINT TEST

### Prerequisites:

- Docker: www.docker.com
- Docker-compose: https://docs.docker.com/compose/install
- PHP 8.0: https://www.php.net/downloads.php
- Composer: https://getcomposer.org/download

### Installation:

- Once you have them, you can run the project with the following command:
  `docker-compose up --build`
- Then you can access the project in the following url: http://localhost:8000
  If you can see a Holi! The project is running correctly.

### Endpoints:

> In order to make the testing easier, I have created a postman collection with all the endpoints.
> You can find it in the following folder location:
> `socialpoint/project/Socialpoint.postman_collection.json`

- **POST** /user/{username}/{score}
    - Updates the score of the user with the given username.
- **GET** /ranking?type=top{number}
    - Returns the ranking of the top {number} users.
- **GET** /ranking?type=At{limit}/{position}
    - Returns the ranking of the users around the given position.

### Testing:

The project has been tested with PHPUnit. You can run the tests with the following command:

`cd socialpoint/project`

`php vendor/bin/phpunit tests`

### Folder structure:

- **project/src/Ranking**: Contains the code of the project.
    - **project/src/Ranking/Domain**: Contains the domain logic of the project.
        - **Exceptions**
        - **Factories**
        - **Interfaces**
        - **Models**
        - **UseCases**
    - **project/src/Ranking/Infrastructure**: Contains the infrastructure logic of the project.
        - **Exceptions**
        - **Http**
        - **Repositories**
        - **Services**

### Considerations:

- I have used the Symfony framework to create the project. I have used it because it is the framework
  I am most familiar with, although I have tried to use the minimum amount of components possible.
- The lack of comments in the code is because I have tried to make the code as readable as possible.
- I apologise if there is any Pythonian code, I have been working with Python for the last 2 years :D