## Install
Run this commands:
- composer install
- php artisan queue:table
- php artisan migrate
- php artisan db:seed
- php artisan queue:work (for sending mails. End not close console)

## Admin 

Seeding will make admin user.

Credential:
 - admin@exapmle.com
 - password

Create new admin user in DB with your real email or edit this admin for getting emails when users will send comments 

## Mails

You must use your credential for emails or use my for test

MAIL_MAILER=smtp

MAIL_HOST=smtp.gmail.com

MAIL_PORT=465

MAIL_USERNAME=vova.banudz@gmail.com

MAIL_PASSWORD=pztpfrarkfvyhdxu

## Other

Command for check NEW label:

 - php artisan articles:check

Logs write in storage/logs/crud.log
