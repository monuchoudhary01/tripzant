<?php

namespace App\Translation;

use Illuminate\Translation\Translator as BaseTranslator;
use Spatie\TranslationLoader\LanguageLine;

class AutoSavingTranslator extends BaseTranslator
{
    public function get($key, array $replace = [], $locale = null, $fallback = true)
    {
        $translation = parent::get($key, $replace, $locale, $fallback);

        // If the translation is the same as the key, it means it's missing
        if ($translation === $key) {
            $this->saveMissingKey($key);
        }

        return $translation;
    }

    protected function saveMissingKey($key)
    {
        // Prevent infinite loop if something goes wrong
        static $saved = [];
        if (isset($saved[$key])) return;
        $saved[$key] = true;

        $parts = explode('.', $key);
        $group = array_shift($parts);
        $item = implode('.', $parts);

        if (empty($item)) {
            $item = $group;
            $group = 'general';
        }

        // Check if exists in DB
        $exists = LanguageLine::where('group', $group)
            ->where('key', $item)
            ->exists();

        if (!$exists) {
            LanguageLine::create([
                'group' => $group,
                'key' => $item,
                'text' => ['en' => $item], // Default to key name
            ]);
        }
    }
}
