<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index(): JsonResponse
    {
        $settings = Setting::all();

        $grouped = $settings->groupBy('group')->map(function ($items) {
            return $items->mapWithKeys(function (Setting $setting) {
                $value = $setting->value;

                if ($setting->type === 'image' && $value) {
                    $value = Storage::disk('public')->url($value);
                } elseif ($setting->type === 'boolean') {
                    $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                } elseif ($setting->type === 'json' && $value) {
                    $value = json_decode($value, true);
                }

                return [$setting->key => $value];
            });
        });

        return response()->json([
            'data' => $grouped,
        ]);
    }
}
