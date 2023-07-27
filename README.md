# Externatic
*student project*

## Presentation

[Externatic](https://www.externatic.fr/) is a company specializing in IT profile recruitment.
Our mission was to create a hirement website. We have decided to focus on facilitating the hiring process for both candidates and companies. With just one click, a candidate can apply for a job offer, and companies can easily update applications.You can find a demo of the application [here](https://www.loom.com/share/b2266e12c2aa40419b5a8efb44e4042d?sid=9112185d-7a4e-4c5f-8111-6635b3dd207f).

## Authors

* [Erika Ikelempo](https://github.com/Erikaike)
* [Esther Martinez](https://github.com/strmarlop)
* [Léa Hadida](https://github.com/leahad)
* [Lionel Da Rosa](https://github.com/Lionel-darosa)

## Technical specifications

This project has been created with the help of a starter kit developed by Wild Code School teachers.
It's a symfony website with some additional libraries (webpack, GrumPHP, fixtures) and tools to validate code standards.

### Prerequisites

1. Check that composer is installed
2. Check that yarn & node are installed

### Install

1. Clone this project
2. Run `composer install`
3. Run `yarn install`
4. Run `yarn build` to build assets
5. Create and configure _.env.local_ from _.env_ file :
    * add your database parameters by entering your mySQL credentials and the name of your database
    * add your MAILER_DSN credentials and your MAILER_FROM_ADDRESS
6. Run `symfony console doctrine:database:create` to create your database 
7. Run `symfony console doctrine:migrations:migrate` to import the content of the database app

### Working

1. Run `symfony server:start` to launch your local php web server
2. Run `yarn run dev --watch` to launch your local server for assets (or `yarn dev-server` do the same with Hot Module Reload activated)
3. Go to `localhost:8000` with your favorite browser

## Built With

* [Symfony](https://github.com/symfony/symfony)
* [GrumPHP](https://github.com/phpro/grumphp)
* [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)
* [PHPStan](https://github.com/phpstan/phpstan)
* [PHPMD](http://phpmd.org)
* [ESLint](https://eslint.org/)
* [Sass-Lint](https://github.com/sasstools/sass-lint)

## License

MIT License

Copyright (c) 2019 aurelien@wildcodeschool.fr

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
