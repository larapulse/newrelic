<?php

namespace Larapulse\NewRelic;

interface NewRelicInterface
{
    /**
     * Update app name
     *
     * @param string $name App name without
     * @param string $env  Environment, used as suffix for app name
     *
     * @return bool
     */
    public function setAppName(string $name, string $env) : bool;

    /**
     * Mark transaction as background job
     *
     * @return $this
     */
    public function enableBackgroundJob();

    /**
     * Mark transaction as web transaction
     *
     * @return $this
     */
    public function disableBackgroundJob();

    /**
     * Do not generate metrics for this transaction
     *
     * @return $this
     */
    public function ignoreTransaction();

    /**
     * Set the new of the transaction
     *
     * @param string $name
     *
     * @return bool     This function will return true if the transaction name was successfully changed
     */
    public function setTransactionName(string $name) : bool;

    /**
     * Start transaction after stopping them with endTransaction
     *
     * @param bool $reset   Reset current transaction
     *
     * @return bool     This function will return true if the transaction was successfully started
     */
    public function startTransaction(bool $reset = false) : bool;

    /**
     * End the current transaction and send all the data to the new relic daemon
     *
     * @return bool     This function will return true if the transaction was successfully ended and data was sent
     */
    public function endTransaction() : bool;

    /**
     * Add custom parameter to the current web transaction
     *
     * @param string $key           Parameter key
     * @param string|array $value   Parameter value, if type is array one parameter per key will be added
     *
     * @return bool     This function will return true if the parameter was added successfully
     */
    public function addCustomParameter(string $key, $value) : bool;

    /**
     * Add custom parameter to the current web transaction
     *
     * @see NewRelicInterface::addCustomParameter()
     *
     * @param array $array  Associative array of custom parameters
     *
     * @return bool         This function will return true if the parameter was added successfully
     */
    public function addCustomParameterArray(array $array) : bool;

    /**
     * Adds a custom metric with the specified name and value
     *
     * @param string $name
     * @param float $value
     *
     * @return bool     This function will return true if the metric was added successfully
     */
    public function addCustomMetric(string $name, float $value) : bool;

    /**
     * Report an error at this line of code, with a complete stack trace.
     *
     * @param string $message
     *
     * @return $this
     */
    public function noticeError(string $message);

    /**
     * Report an error at this line of code, with a complete stack trace.
     *
     * @param \Exception $e
     *
     * @return $this
     */
    public function noticeException(\Exception $e);

    /**
     * Records a New Relic Insights custom event
     *
     * @param string $name
     * @param array $attributes
     *
     * @return $this
     */
    public function recordCustomEvent(string $name, array $attributes);
}
