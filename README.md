# Laravel 6,7,8 Permission

Laravel Permission Package

[![Latest Stable Version](https://poser.pugx.org/jetbox/laravel-permission/v)](//packagist.org/packages/jetbox/laravel-permission)
[![Total Downloads](https://poser.pugx.org/jetbox/laravel-permission/downloads)](//packagist.org/packages/jetbox/laravel-permission)
[![Latest Unstable Version](https://poser.pugx.org/jetbox/laravel-permission/v/unstable)](//packagist.org/packages/jetbox/laravel-permission)
[![License](https://poser.pugx.org/jetbox/laravel-permission/license)](//packagist.org/packages/jetbox/laravel-permission)

[comment]: <> ([![Daily Downloads]&#40;https://poser.pugx.org/jetbox/laravel-permission/d/daily&#41;]&#40;//packagist.org/packages/jetbox/laravel-permission&#41;)
[comment]: <> ([![Monthly Downloads]&#40;https://poser.pugx.org/jetbox/laravel-permission/d/monthly&#41;]&#40;//packagist.org/packages/jetbox/laravel-permission&#41;)
[comment]: <> ([![Total Downloads]&#40;https://poser.pugx.org/jetbox/laravel-permission/downloads&#41;]&#40;//packagist.org/packages/jetbox/laravel-permission&#41;)

[![Issues](https://img.shields.io/github/issues/DavitMnacakanyan/laravel-permission)](https://github.com/DavitMnacakanyan/laravel-permission/issues)
[![Stars](https://img.shields.io/github/stars/DavitMnacakanyan/laravel-permission)](https://github.com/DavitMnacakanyan/laravel-permission/stargazers)
[![Forks](https://img.shields.io/github/forks/DavitMnacakanyan/laravel-permission)](https://github.com/DavitMnacakanyan/laravel-permission/network/members)

## Table of Contents

- <a href="#installation">Installation</a>
    - <a href="#composer">Composer</a>
- <a href="#methods">Methods</a>
- <a href="#usage">Usage</a>
	- <a href="#use-methods">Use methods</a>
- <a href="#directives">Blade Directives</a>

## Installation

### Composer

Execute the following command to get the latest version of the package:

```terminal
composer require jetbox/laravel-permission
```

### Permission
```terminal
php artisan permission:install
```

## Methods

### Role and Permission

- syncPermissions($permission)
- detachPermissions($permission)
- hasPermissions($permission): bool
- assignRole($role)
- detachRole($role)
- getPermissionNames()
- getRoleNames()
- abilities()
- hasRole($roles)
- hasAnyRole($roles)

## Usage

### User Model

```php
namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use JetBox\Permission\Traits\HasRoles;

class User extends Model {

    use HasRoles;
}
```

### Use methods

```php
$user = User::firstOrFail();
$user->assignRole('admin');
```

## directives
```php
@role('admin')
     Admin
@endrole

@hasRole('admin')
     Admin
@endhasRole

@hasAnyRole(['admin', 'moderator', 'writer'])
     Admin
@endhasAnyRole

@unlessRole('admin')
     Admin
@endunlessRole
```
