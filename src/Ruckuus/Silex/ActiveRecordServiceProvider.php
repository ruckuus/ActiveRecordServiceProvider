<?php

/*
 * Author: Dwi Sasongko S <ruckuus@gmail.com>
 */

namespace Ruckuus\Silex;

use Silex\Application;
use Silex\ServiceProviderInterface;

class ActiveRecordServiceProvider implements ServiceProviderInterface
{
    private $app;

    public function register(Application $app)
    {
        $this->app = $app;

        $app['ar.model_dir'] = $app['base_dir'] . '/App/Model';        
        $app['ar.connections'] = array(
            'development' => 'mysql://root:password@localhost/database_name'
        );
        $app['default_connection'] = 'development';

        $app['ar.init'] = $app->share(function (Application $app) {
            \ActiveRecord\Config::initialize(function ($cfg) use ($app) {
                $cfg->set_model_directory($app['ar.model_dir']);
                $cfg->set_connections($app['ar.connections']);
                $cfg->set_default_connection($app['ar.default_connection']);
            });
        }); 

    }

    public function boot(Application $app)
    {
        $this->app['ar.init'];
    }
}
