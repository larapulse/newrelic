<?php

namespace Larapulse\NewRelic;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class NewRelic implements NewRelicInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    protected $appName;

    protected $env;

    // TODO: license

    protected $hiddenEnv = ['prod', 'production', 'productive'];

    /**
     * Initialize new relic client with app name
     *
     * @param string     $name       App name without env postfix
     * @param string     $env        Env suffix for app name
     * @param array|null $hiddenEnvs List of env's to not to append to the app name
     */
    public function __construct(string $name = null, string $env = 'prod', array $hiddenEnvs = [])
    {
        $hiddenEnvs && $this->setHiddenEnvs($hiddenEnvs);
        $name = $name ?: ini_get('newrelic.appname');

        $this->setAppName($name, $env);
    }

    /**
     * @inheritDoc
     */
    public function setAppName(string $name, string $env) : bool
    {
        $this->appName = $name;
        $this->env = $env;

        return newrelic_set_appname($this->getFullAppName());
    }

    /**
     * Set list of env's to not to append to app name
     * default is production and productive
     *
     * @param string[] $envs
     *
     * @return $this
     */
    public function setHiddenEnvs(array $envs) : self
    {
        $this->hiddenEnv = $envs;

        return $this;
    }

    /**
     * Return app name without env
     *
     * @return string
     */
    public function getAppName() : string
    {
        return $this->appName;
    }

    /**
     * Return env name
     *
     * @return string
     */
    public function getEnv() : string
    {
        return $this->env;
    }

    /**
     * Get app name with env suffix
     *
     * @return string
     */
    public function getFullAppName() : string
    {
        if (in_array($this->env, $this->hiddenEnv, true)) {
            return $this->getAppName();
        }

        return $this->getAppName() . '_' . $this->getEnv();
    }

    /**
     * @inheritDoc
     * @codeCoverageIgnore
     */
    public function enableBackgroundJob() : self
    {
        newrelic_background_job(true);

        return $this;
    }

    /**
     * @inheritDoc
     * @codeCoverageIgnore
     */
    public function disableBackgroundJob() : self
    {
        newrelic_background_job(false);

        return $this;
    }

    /**
     * @inheritDoc
     * @codeCoverageIgnore
     */
    public function ignoreTransaction() : self
    {
        newrelic_ignore_transaction();

        return $this;
    }

    /**
     * @inheritDoc
     * @codeCoverageIgnore
     */
    public function setTransactionName(string $name) : bool
    {
        return newrelic_name_transaction($name);
    }

    /**
     * @inheritDoc
     * @codeCoverageIgnore
     */
    public function startTransaction(bool $reset = false) : bool
    {
        $reset && $this->endTransaction();

        return newrelic_start_transaction($this->getFullAppName());
    }

    /**
     * @inheritDoc
     * @codeCoverageIgnore
     */
    public function endTransaction() : bool
    {
        return newrelic_end_transaction();
    }

    /**
     * @inheritDoc
     * @codeCoverageIgnore
     */
    public function addCustomParameter(string $key, $value) : bool
    {
        $success = true;

        if (is_array($value)) {
            /** @var array $value */
            foreach ($value as $k => $v) {
                $success = $this->addCustomParameter($key . '[' . $k . ']', $v) && $success;
            }
        } else {
            $success = newrelic_add_custom_parameter($key, $value);
        }

        return $success;
    }

    /**
     * @inheritDoc
     */
    public function addCustomParameterArray(array $array) : bool
    {
        $success = true;

        foreach ($array as $key => $value) {
            $success = $this->addCustomParameter($key, $value) && $success;
        }

        return $success;
    }

    /**
     * @inheritDoc
     * @codeCoverageIgnore
     */
    public function addCustomMetric(string $name, float $value) : bool
    {
        return newrelic_custom_metric($name, $value);
    }

    /**
     * @inheritDoc
     * @codeCoverageIgnore
     */
    public function noticeError(string $message) : self
    {
        newrelic_notice_error($message);

        return $this;
    }

    /**
     * @inheritDoc
     * @codeCoverageIgnore
     */
    public function noticeException(\Exception $e) : self
    {
        newrelic_notice_error(null, $e);

        return $this;
    }

    /**
     * @inheritDoc
     * @codeCoverageIgnore
     */
    public function recordCustomEvent(string $name, array $attributes) : self
    {
        newrelic_record_custom_event($name, $attributes);

        return $this;
    }
}
