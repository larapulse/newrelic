<?php

namespace Larapulse\NewRelic;

use Larapulse\NewRelic\Exceptions\ExtensionNotLoadedException;

class NewRelicFactory
{
    /**
     * @var NewRelicInterface
     */
    protected static $instance;

    /**
     * Set new relic instance to singleton
     *
     * @param NewRelicInterface $newRelic
     *
     * @return NewRelicInterface
     */
    public static function setInstance(NewRelicInterface $newRelic) : NewRelicInterface
    {
        static::$instance = $newRelic;

        return $newRelic;
    }

    /**
     * Return new relic instance, if no instance is set a blackhole instance will be returned
     *
     * @return NewRelicInterface
     * @throws \Larapulse\NewRelic\Exceptions\ExtensionNotLoadedException
     */
    public static function getInstance() : NewRelicInterface
    {
        return static::$instance instanceof NewRelicInterface
            ? static::$instance
            : self::initialize(
                ini_get('newrelic.appname') ?: 'NewRelic App',
                getenv('APP_ENV') ?: 'test'
            );
    }

    /**
     * Create a new relic instance and set them
     * If new relic extension is loaded a new relic instance will be created
     * Otherwise a blackhole instance will be created
     *
     * @param string $appName
     * @param string $env
     * @param bool   $throwException
     *
     * @return NewRelicInterface
     * @throws \Larapulse\NewRelic\Exceptions\ExtensionNotLoadedException
     * @codeCoverageIgnore
     */
    public static function initialize(string $appName, string $env, bool $throwException = true) : NewRelicInterface
    {
        switch (true) {
            case extension_loaded('newrelic'):
                static::$instance = new NewRelic($appName, $env);
                break;
            case $throwException:
                throw new ExtensionNotLoadedException();
            default:
                static::$instance = new NewRelicBlackhole();
        }

        return static::$instance;
    }
}
