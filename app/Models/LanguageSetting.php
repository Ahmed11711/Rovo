<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class LanguageSetting extends Model
{
    protected $guarded = ['id'];

    const LANGUAGES_TRANS = [
        'en' => 'English',
        'ar' => 'عربي',
        'de' => 'Deutsch',
        'es' => 'Español',
        'et' => 'eesti keel',
        'fa' => 'فارسی',
        'fr' => 'français',
        'gr' => 'Ελληνικά',
        'it' => 'Italiano',
        'nl' => 'Nederlands',
        'pl' => 'Polski',
        'pt' => 'Português',
        'pt-br' => 'Português (Brasil)',
        'ro' => 'Română',
        'ru' => 'Русский',
        'tr' => 'Türk',
        'zh-CN' => '中国人',
        'zh-TW' => '中國人'
    ];

    const LANGUAGES = [
        [
            'language_code' => 'en',
            'flag_code' => 'gb',
            'language_name' => 'English',
            'active' => 1,
        ],
        [
            'language_code' => 'ar',
            'flag_code' => 'sa',
            'language_name' => 'Arabic',
            'active' => 0,

        ],
        [
            'language_code' => 'de',
            'flag_code' => 'de',
            'language_name' => 'German',
            'active' => 0,

        ],
        [
            'language_code' => 'es',
            'flag_code' => 'es',
            'language_name' => 'Spanish',
            'active' => 0,

        ],
        [
            'language_code' => 'et',
            'flag_code' => 'et',
            'language_name' => 'Estonian',
            'active' => 0,

        ],
        [
            'language_code' => 'fa',
            'flag_code' => 'ir',
            'language_name' => 'Farsi',
            'active' => 0,

        ],
        [
            'language_code' => 'fr',
            'flag_code' => 'fr',
            'language_name' => 'French',
            'active' => 0,

        ],
        [
            'language_code' => 'gr',
            'flag_code' => 'gr',
            'language_name' => 'Greek',
            'active' => 0,

        ],
        [
            'language_code' => 'it',
            'flag_code' => 'it',
            'language_name' => 'Italian',
            'active' => 0,

        ],
        [
            'language_code' => 'nl',
            'flag_code' => 'nl',
            'language_name' => 'Dutch',
            'active' => 0,

        ],
        [
            'language_code' => 'pl',
            'flag_code' => 'pl',
            'language_name' => 'Polish',
            'active' => 0,

        ],
        [
            'language_code' => 'pt',
            'flag_code' => 'pt',
            'language_name' => 'Portuguese',
            'active' => 0,

        ],
        [
            'language_code' => 'pt-br',
            'flag_code' => 'br',
            'language_name' => 'Portuguese (Brazil)',
            'active' => 0,

        ],
        [
            'language_code' => 'ro',
            'flag_code' => 'ro',
            'language_name' => 'Romanian',
            'active' => 0,

        ],
        [
            'language_code' => 'ru',
            'flag_code' => 'ru',
            'language_name' => 'Russian',
            'active' => 0,

        ],
        [
            'language_code' => 'tr',
            'flag_code' => 'tr',
            'language_name' => 'Turkish',
            'active' => 0,

        ],
        [
            'language_code' => 'zh-CN',
            'flag_code' => 'cn',
            'language_name' => 'Chinese (S)',
            'active' => 0,

        ],
        [
            'language_code' => 'zh-TW',
            'flag_code' => 'cn',
            'language_name' => 'Chinese (T)',
            'active' => 0,

        ],
    ];


    public function flagUrl(): Attribute
    {
        return Attribute::get(function (): string {
            return asset('flags/1x1/' . strtolower($this->flag_code) . '.svg');
        });
    }

}
