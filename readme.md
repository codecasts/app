## CODECASTS V3

Source code for [https://codecasts.com.br](https://codecasts.com.br).


# 1. Development instructions.

This is how to run this project:

## 1.1. Dependencies and Setup:


### 1.1.1 Fixing permissions (first run only). 

```
docker-compose run app sudo chown -R ambientum:ambientum /home/ambientum
docker-compose run front sudo chown -R ambientum:ambientum /home/ambientum
```

### 1.1.2. Installing Dependencies (when needed).

```
docker-compose run app composer install
```
```
docker-compose run front yarn
```

## 1.2. Running the project:
```
docker-compose up
```

