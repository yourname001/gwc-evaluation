<p>Golden West College Evaluation System</p>
<hr>
<p>Installation on Windows with XAMPP:</p>

- Open windows powershell or windows terminal.
- Execute this on shell/terminal: <code>cd C:/xampp/htdocs</code>
- Execute this on shell/terminal: <code>git clone https://github.com/yourname001/gwc-evaluation.git</code>
- Execute this on shell/terminal: <code>cd gwc-evaluation</code>
- Execute this on shell/terminal: <code>composer install</code>
- Execute this on shell/terminal: <code>cp .env.example .env</code>
- Create database on http://localhost/phpmyadmin
  - Database Name: <code>gwc_evaluation</code>
  - Collation: <code>utf8mb4_unicode_ci</code>
- Execute this on shell/terminal: <code>php artisan key:generate</code>
- Execute this on shell/terminal: <code>php artisan config:cache</code>
- Execute this on shell/terminal: <code>php artisan artisan install</code>
- Execute this on shell/terminal: <code>php artisan config:cache</code>
- Open <code>C:/xampp/apache/conf/extra/httpd-vhost.conf</code> and add these:
    ```
    <VirtualHost *:80>
        DocumentRoot "C:/xampp/htdocs/gwc-evaluation/public"
        ServerName gwc-evaluation.me
    </VirtualHost>
    ```
    and save.
- Launch notepad as administrator and open <code>C:/Windows/System32/drivers/etc/hosts</code> file and add these:
    ```
    127.0.0.1   gwc-evaluation.me
    ```
    and save
- Restart your Apache in XAMPP Control Panel.
- Open your browser and copy this link http://gwc-evaluation.me to access the Web Application. Your can login as System Administrator using the credential below:
  - Username: master
  - Password: admin