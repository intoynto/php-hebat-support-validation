<?php

namespace Intoy\HebatSupport\Validation\Traits;

trait TranslationsTrait
{
    /**
     * @var array 
     */     
    protected $translations=[];

    /**
     * Set $translation by $key
     * @param mixed $key
     * @param mixed $translation
     * @return void
     */
    public function setTranslation($key,$translation)
    {
        $this->translations[$key]=$translation;
    }


    /**
     *et multiple translations     
     * @param array $translations
     * @return void
     */
    public function setTranslations($translations)
    {
        $this->translations = array_merge($this->translations, $translations);
    }

    /**
     * Get translation from given $key     
     * @param string $key
     * @return string
     */
    public function getTranslation($key)
    {
        return array_key_exists($key, $this->translations) ? $this->translations[$key] : $key;
    }

    /**
     * Get all $translations     
     * @return array
     */
    public function getTranslations()
    {
        return $this->translations;
    }
}