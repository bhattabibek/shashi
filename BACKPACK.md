Installation:
- php artisan backpack:user

# Themes Installation [here](https://github.com/Laravel-Backpack/theme-coreuiv2)

***Install via artisan***
- php artisan backpack:require:theme-coreuiv2

***Install via composer***
- composer require backpack/theme-coreuiv2
- php artisan vendor:publish --tag="theme-coreuiv2-config"


***Remove Backpack***
- composer remove backpack/theme-coreuiv2
- rm -rf config/backpack/theme-coreuiv2.php
- php artisan backpack:require:theme-coreuiv4

***Overriding***
- mkdir -p resources/views/vendor/backpack/theme-coreuiv2
- cp -i vendor/backpack/theme-coreuiv2/src/resources/views/dashboard.blade.php resources/views/vendor/backpack/theme-coreuiv2/dashboard.blade.php
