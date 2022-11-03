# Project fbr renovation

This traineeship project is programming in symfony, everything is already set up and good to go.

# Requirements

Install (Composer)[https://getcomposer.org/]
Install (Scoop)[https://scoop.sh/] for Install (Symfony CLI)[https://symfony.com/download]
Install (Node.js)[https://nodejs.org/en/download/]

# Symfony Setup

```
Composer install
npm install
```

### Compile and Minify for Production

```
npm run watch
```

### Compile and Hot-Reload for Development

```
symfony serve
```

### Create database

```
symfony console make:migration
symfony console d:m:m
```

## FYI

1. #### Parse error: syntax error, unexpected '?'

   Create a `.php-version` file and simply type in your php version to fix the error

   Example : `8.1.3`

2. #### Database

   Change the database path in the `.env` file, and don't forget to add the `.env` file to your .gitignore

3. #### PROD

   `yarn run encore production` to build
