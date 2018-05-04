# A Clone of Bit.ly

This is a simple project that perform url shortening service, like Bit.ly. The backend is built by Lumen PHP Framework. There is a simple frontend that let user input the url they want to shorten. The shortened url will be shown immediatly.

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
