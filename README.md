<h2 align="center">Golden West College Evaluation System</h2>
<hr>
<p>Installation on Windows with XAMPP:</p>

- Open windows powershell or windows terminal.
- Execute this on shell/terminal: ``` cd C:/xampp/htdocs ```
- Execute this on shell/terminal: ``` git clone https://github.com/yourname001/gwc-evaluation.git ```
- Execute this on shell/terminal: ``` cd gwc-evaluation ```
- Execute this on shell/terminal: ``` composer install ```
- Execute this on shell/terminal: ``` cp .env.example .env ```
- Create database on http://localhost/phpmyadmin
  - Database Name: ``` gwc_evaluation ```
  - Collation: ``` utf8mb4_unicode_ci ```
- Execute this on shell/terminal: ``` php artisan key:generate ```
- Execute this on shell/terminal: ``` php artisan config:cache ```
- Execute this on shell/terminal: ``` php artisan artisan install ```
- Execute this on shell/terminal: ``` php artisan config:cache ```
- Open ``` C:/xampp/apache/conf/extra/httpd-vhost.conf ``` and add these:
    ```
    <VirtualHost *:80>
        DocumentRoot "C:/xampp/htdocs/gwc-evaluation/public"
        ServerName gwc-evaluation.me
    </VirtualHost>
    ```
    and save.
- Launch notepad as administrator and open ``` C:/Windows/System32/drivers/etc/hosts ``` file and add these:
    ```
    127.0.0.1   gwc-evaluation.me
    ```
    and save
- Restart your Apache in XAMPP Control Panel.
- Open your browser and copy this link http://gwc-evaluation.me to access the Web Application. Your can login as System Administrator using the credential below:
  - Username: master
  - Password: admin