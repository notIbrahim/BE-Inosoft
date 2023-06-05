<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


## Backend Inosoft Testing


## Prerequisite
This app something must be follow of this prerequisite considering of Nature PHP using extension like php_mongodb on windows i don't know about Mac / Linux here 
- if you don't have the driver php_mongodb go to this link if your windows https://github.com/mongodb/mongo-php-driver/releases/
- so if i correctly first number are version mongo_db then second one PHP Version and Third One are Does this Version PHP Thread Safety or Not
- To Check Thread Safety or Not open your terminal / CMD / Whatever your terminal are on windows do php -i | findstr "Thread" on Linux / Mac php -i | grep "Thread" if Enabled then Use TS if not then Use NTS (Non Thread Safety)
- After finish download you find location ext usually inside php and put the file inside ext
- Last Step are config your php.ini / edit php.ini added this extension=php_mongodb 
- And Done

## Guide to Use App
In Order to use this App there something to make sure that depedency like composer are installed if not well go install composer (newest one)
So Guide to use app
- extract this app to whatever disk / folder you like to use
- use cmd to access file by that meant depend your operating system 
    - if Windows well use terminal / CMD / Powershell / Whatever your terminal then do navigate where your save folder and extract them by use dir <this-project>
    - if Linux / Mac well use terminal / Whatever your terminal then do navigate where your save folder and extract them by use ls <this-project>
- after you locate them then run composer install to some depedencies you needed for
- after done run.sh to run app (if don't wanna make complicated thing) if not then run php artisan serve (optional) --port="whatever your desire" --host="its IP" 
