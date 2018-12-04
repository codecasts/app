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

## 1.3. Optional virtua host:

It's recommended you use `codecasts.local` as virtual host since some references will point to `http://codecasts.local:8080`

## 1.4. Links & Ports:

| Resource        | Value                                         |
| -               | -                                             |
| Application     | http://codecasts.local:8080                   |
| Redis           | cache:6379                                    |                                                   |
| MongoDB         | mongodb://codecasts:codecasts@mongo/codecasts |
| MailHog (SMTP)  | mailhog:1025                                  |
| MailHog (Web)   | http://codecasts.local:8025                   |
   