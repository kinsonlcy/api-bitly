# A Clone of Bit.ly

This is a simple project that perform url shortening service, like Bit.ly. The backend is built by Lumen PHP Framework. There is a simple frontend that let user input the url they want to shorten. The shortened url will be shown immediately. When the frontend received the required url, it will do a ajax call to the Lumen API endpoint to perform shorten link request. For each request, the system will check whether the url has been shortened before or not. If yes, the shorten url will be return from cache (database). If it is a new url, the system will randomly assign a 8-digit id and cache it to the database for future usage.

Lumen is used in this system simply because of the framework boost the development process.

Assumption:
1. Every valid address user typed is assumed to be existing.

Limitation
1. The database can only store certain amount of urls. It is because the upper bound of 8-digit random number has a limit.
2. Same address with "www" difference will have two different shorten url.
3. Simple checking for url is implemented. There maybe some kinds of string that satisfy with the requirement maybe stored into the database. 
## Getting Started

These instructions will get you implementing the system on Amazon Web Service.

### Prerequisites
1. Start an instance on AWS, with Ubuntu 16.04.
2. Start a AWS RDS database with SQL engine.
3. Get the auto deployment script from here:

```
https://github.com/kinsonleung1996/deploy-lumen
```

### Installing

SSH into the AWS instance

Copy the deploy_lumen.sh to /home/ubuntu directory.

Make the script executable by:

```
sudo chmod +x deploy_lumen.sh
```

Run the script by:

```
./deploy_lumen.sh
```

Press yes all the way until it completes.



### To set up the correct entry point of Apache

```
cd /etc/apache2/sites-available/
sudo cp 000-default.conf project.conf
sudo nano project.conf
```
Change it to the following:
```
<VirtualHost *:80>

        ServerName local.project.com
        ServerAdmin admin@project.com
        DocumentRoot /var/www/html/api-bitly/public

        <Directory "/var/www/html/api-bitly/public“>
                AllowOverride All
        </Directory>

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined

</VirtualHost>
```

## Enable this new virtual host, disable the default one and reload Apache2:

```
sudo a2ensite project.conf
sudo a2dissite 000-default.conf
sudo service apache2 reload
```
## Configure the database
Input the database credentials in api-bitly/config/database.php
Perform migration by running:
```
php artisan migrate
```
## Note
If the id generated is not 8 digit, please copy hashids.php into the following directory:

```
mv hashids.php /var/www/html/api-bitly/vendor/vinkla/hashids/config
```

## Built With

* [Lumen](https://lumen.laravel.com/) - The web framework used


## Contributing


## Versioning

First version v1

## Authors

* **Kinson Leung** - *Initial work* - [kinsonleung](http://kinsonleung.com)


## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments
