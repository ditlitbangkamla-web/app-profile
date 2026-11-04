<?php

namespace App\Models;

use Database\Factories\SettingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    /** @use HasFactory<SettingFactory> */
    use HasFactory;

    protected $fillable = [
        'group',
        'key',
        'label',
        'value',
        'type',
    ];

    protected static function booted(): void
    {
        static::saved(function (Setting $setting) {
            Cache::forget("setting_{$setting->key}");
            Cache::forget('all_settings');
        });

        static::deleted(function (Setting $setting) {
            Cache::forget("setting_{$setting->key}");
            Cache::forget('all_settings');
        });
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::rememberForever("setting_{$key}", function () use ($key, $default) {
            $setting = static::where('key', $key)->first();

            return $setting?->value ?? $default;
        });
    }

    public static function set(string $key, mixed $value, string $group = 'general', string $type = 'text', ?string $label = null): self
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'type' => $type,
                'label' => $label ?? ucwords(str_replace('_', ' ', $key)),
            ]
        );

        Cache::forget("setting_{$key}");
        Cache::forget('all_settings');

        return $setting;
    }

    /**
     * @return array<string, mixed>
     */
    public static function getAllGrouped(): array
    {
        return Cache::rememberForever('all_settings', function () {
            return static::all()->groupBy('group')->map(function ($items) {
                return $items->pluck('value', 'key');
            })->toArray();
        });
    }
}
