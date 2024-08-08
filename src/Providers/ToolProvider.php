<?php

namespace Nerow\Tools\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class ToolProvider extends ServiceProvider
{
    public function boot(): void
    {
        $loader = AliasLoader::getInstance();
        //$loader->alias('AuthorizationServer', 'LucaDegasperi\OAuth2Server\Facades\AuthorizationServerFacade');
    }
}