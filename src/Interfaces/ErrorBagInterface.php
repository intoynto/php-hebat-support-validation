<?php
declare (strict_types=1);

namespace Intoy\HebatSupport\Validation\Interfaces;

interface ErrorBagInterface
{
     /**
     * Add message for given key and rule
     *
     * @param string $key
     * @param string $rule
     * @param string $message
     * @return void
     */
    public function add($key, $rule, $message);

    /**
     * Get messages count
     * @return int
     */
    public function count();

    /**
     * Check given key is existed
     *
     * @param string $key
     * @return bool
     */
    public function has($key);


    /**
     * Get the first value of array
     * @param string $key
     * @return mixed
     */
    public function first($key);


    /**
     * Get messages from given key, can be use custom format
     * @param string $key
     * @param string $format
     * @return array
     */
    public function get($key, $format = ':message');

    /**
     * Get all messages
     * @param string $format
     * @return array
     */
    public function all($format = ':message');


    /**
     * Get the first message from existing keys
     * @param string $format
     * @param boolean $dotNotation
     * @return array
     */
    public function firstOfAll($format = ':message', $dotNotation = false);


    /**
     * Get plain array messages
     * @return array
     */
    public function toArray();
}