ActiveRecordServiceProvider
===========================

A PHP ActiveRecord ServiceProvider for Silex. 

## History

I was about to use [Available ActiveRecord Extension] (https://github.com/RafalFilipek/ActiveRecordExtension/blob/master/ActiveRecordExtension.php), but then I realised that registerNamespace() is deprecated in later version of Silex. This work is experimental, it has a minimum functionality to "work".

## Fetch

The recommended way to install ActiveRecordServiceProvider is [through composer](http://getcomposer.org).

Just create a composer.json file for your project:

```JSON
{
    "require": {
        "ruckuus/php-activerecord-service-provider": "dev-master",
        "silex/silex": "1.0.*@dev"
    }
}
```

## Parameters

* *ar.model_dir* - Path to where model folder is located ( without trailing slash )
* *ar.connections* - Array of connections (`name => connection`). Connections examples:
    * `mysql://username:password@localhost/database_name`
    * `pgsql://username:password@localhost/development`
    * `sqlite://my_database.db`
    * `oci://username:passsword@localhost/xe`
* *ar.default_connection* - default models connection.

## Register

```PHP
use Silex\Application;
use Ruckuus\Silex\ActiveRecordServiceProvider;

$app = new Application();

$app->register(new ActiveRecordServiceProvider(), array(
    'ar.model_dir' => __DIR__ . '/App/Model',
    'ar.connections' =>  array ('development' => 'mysql://root@localhost/database_name'),
    'ar.default_connection' => 'development',
));

```

## Usage

Create your model in `__DIR__ . '/app/Model'`. Eg.

```PHP
namespace App\Model;

class User extends \ActiveRecord\Model {
    static $has_many = array (
        array('problem'),
        array('luck')
    )
}
```
In your application:

```PHP
use App\Model\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class UserProvider implements UserProviderInterface
{
    public function loadUserByUsername($username)
    {
        $user = User::find_by_username(strtolower($username));
        
        if ($user->dirty_attributes()) {
            throw new UnsupportedUserException(sprintf('Bad credentials for "%s"'), $username);
        }
    }
}

```

For more informations check the website of [PHP ActiveRecord](http://phpactiverecord.org/). Its [wiki](http://www.phpactiverecord.org/projects/main/wiki).
