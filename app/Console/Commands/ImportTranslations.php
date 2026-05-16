<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\TranslationLoader\LanguageLine;
use Illuminate\Support\Facades\File;

class ImportTranslations extends Command
{
    protected $signature = 'translations:import {locale=en}';
    protected $description = 'Import local translation files into the database';

    public function handle()
    {
        $locale = $this->argument('locale');
        $langPath = lang_path($locale);

        if (!File::isDirectory($langPath)) {
            $this->error("Directory not found: {$langPath}");
            return;
        }

        $files = File::files($langPath);

        foreach ($files as $file) {
            $group = $file->getBasename('.php');
            $translations = include $file->getRealPath();

            if (is_array($translations)) {
                $this->importArray($group, $translations, $locale);
            }
        }

        $this->info('Translations imported successfully.');
    }

    protected function importArray($group, $array, $locale, $prefix = '')
    {
        foreach ($array as $key => $value) {
            $fullKey = $prefix ? $prefix . '.' . $key : $key;

            if (is_array($value)) {
                $this->importArray($group, $value, $locale, $fullKey);
            } else {
                $line = LanguageLine::where('group', $group)
                    ->where('key', $fullKey)
                    ->first();

                if ($line) {
                    $text = $line->text;
                    $text[$locale] = $value;
                    $line->text = $text;
                    $line->save();
                } else {
                    LanguageLine::create([
                        'group' => $group,
                        'key' => $fullKey,
                        'text' => [$locale => $value],
                    ]);
                }
            }
        }
    }
}
