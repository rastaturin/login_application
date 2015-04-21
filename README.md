# Login Application

This is sample login / register application using PHP, MySQL, HTML/CSS, Javascript, MVC design pattern.

## Demo

[http://loginapp.mobi22.com/](http://loginapp.mobi22.com/)

## Sources

1. Clone project `git clone https://rastaturin@bitbucket.org/rastaturin/sample-login-application.git`

2. Modify file `Application/config.php` according to your DB settings.

3. Create a table in the database:

```
CREATE TABLE users
 (
     email VARCHAR(100) NOT NULL,
     name VARCHAR(100) NOT NULL,
     mdpass VARCHAR(32) NOT NULL,
     salt VARCHAR(10) NOT NULL,
     activation VARCHAR(32) NOT NULL,
     active TINYINT DEFAULT 0 NOT NULL
 );
```
