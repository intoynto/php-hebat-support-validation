<?php

namespace Intoy\HebatSupport\Validation\Traits;

trait MessagesTrait
{
    /**
     * @var array 
     */
    protected $messages=[];

    /**
     * Set $key and $message to set messages
     * @param mixed $key
     * @paream mixed $message
     * @return void
     */
    public function setMessage($key,$message)
    {
        $this->messages[$key]=$message;
    }

    /**
     * Set multiple messages to messages
     * @param array $messages
     * @return void
     */
    public function setMessages($messages)
    {
        $this->messages=array_merge($this->messages,$messages);
    }

    /**
     * Get message attribut key
     * @param string $key
     * @return mixed
     */
    public function getMessage($key)
    {
        return array_key_exists($key,$this->messages)?$this->messages[$key]:$key;
    }

    /**
     * Get all messages
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }
}