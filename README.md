# Processmaker Package Skeleton
This package provides the necessary base code to start the developing a package in ProcessMaker 4.

## Development
If you need to create a new ProcessMaker package run the following commands:

```
git clone https://github.com/ProcessMaker/business-rules.git
cd business-rules
php rename-project.php business-rules
composer install
npm install
npm run dev
```

## Installation
* Use `composer require processmaker/business-rules` to install the package.
* Use `php artisan business-rules:install` to install generate the dependencies.

## Navigation and testing
* Navigate to administration tab in your ProcessMaker 4
* Select `Skeleton Package` from the administrative sidebar

## Uninstall
* Use `php artisan business-rules:uninstall` to uninstall the package
* Use `composer remove processmaker/business-rules` to remove the package completely
