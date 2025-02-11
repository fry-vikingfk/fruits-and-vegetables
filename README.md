# Stack
* Symfony 7
* Doctrine 3.3
* PHP 8.2
* Alpine 16 / fpm-alpine3.21

All of them were upgrated from previous versions. You can check the progress here: https://github.com/fry-vikingfk/fruits-and-vegetables/pull/1

# Installation
After cloning or downloading the repository, run:
### 📥 Pulling image
```bash
make install
```
This Makefile command will create the containers, clear cache and run composer install, migrations, a command to populate the db with the provided request.json and all the tests.

You can run `make init` in case you need, or want, reset your local environment. For more deatils, please check the Makefile


# 🍎🥕 Fruits and Vegetables

## 🎯 Goal
We want to build a service which will take a `request.json` and:
* Process the file and create two separate collections for `Fruits` and `Vegetables`
* Each collection has methods like `add()`, `remove()`, `list()`;
* Units have to be stored as grams;
* Store the collections in a storage engine of your choice. (e.g. Database, In-memory)
* Provide an API endpoint to query the collections. As a bonus, this endpoint can accept filters to be applied to the returning collection.
* Provide another API endpoint to add new items to the collections (i.e., your storage engine).
* As a bonus you might:
  * consider giving option to decide which units are returned (kilograms/grams);
  * how to implement `search()` method collections;
  * use latest version of Symfony's to embbed your logic 

### ✔️ How can I check if my code is working?
You have two ways of moving on:
* You call the Service from PHPUnit test like it's done in dummy test (just run `bin/phpunit` from the console)

or

* You create a Controller which will be calling the service with a json payload

## 💡 Hints before you start working on it
* Keep KISS, DRY, YAGNI, SOLID principles in mind
* Timebox your work - we expect that you would spend between 3 and 4 hours.
* Your code should be tested

## When you are finished
* Please upload your code to a public git repository (i.e. GitHub, Gitlab)

