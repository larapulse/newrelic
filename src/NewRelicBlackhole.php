<?php

namespace Larapulse\NewRelic;

class NewRelicBlackhole implements NewRelicInterface
{
    /**
     * @inheritDoc
     */
    public function setAppName(string $name, string $env) : bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function enableBackgroundJob() : self
    {
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function disableBackgroundJob() : self
    {
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function ignoreTransaction() : self
    {
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setTransactionName(string $name) : bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function startTransaction(bool $reset = false) : bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function endTransaction() : bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function addCustomParameter(string $key, $value) : bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function addCustomParameterArray(array $array) : bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function addCustomMetric(string $name, float $value) : bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function noticeError(string $message) : self
    {
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function noticeException(\Exception $e) : self
    {
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function recordCustomEvent(string $name, array $attributes) : self
    {
        return $this;
    }
}
