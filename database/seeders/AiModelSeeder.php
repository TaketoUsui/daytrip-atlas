<?php

namespace Database\Seeders;

use App\Models\AiModel;
use Illuminate\Database\Seeder;

class AiModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $models = [
            [
                'model_name' => 'gemini-2.5-pro',
                'provider' => 'google',
                'performance_priority' => 500,
                'daily_limit' => 40,
                'enabled' => true,
            ],
            [
                'model_name' => 'gemini-2.5-flash',
                'provider' => 'google',
                'performance_priority' => 400,
                'daily_limit' => 240,
                'enabled' => true,
            ],
            [
                'model_name' => 'gemini-2.5-flash-lite',
                'provider' => 'google',
                'performance_priority' => 300,
                'daily_limit' => 780,
                'enabled' => true,
            ],
            [
                'model_name' => 'gemini-2.0-flash',
                'provider' => 'google',
                'performance_priority' => 200,
                'daily_limit' => 190,
                'enabled' => true,
            ],
            [
                'model_name' => 'gemini-2.0-flash-lite',
                'provider' => 'google',
                'performance_priority' => 100,
                'daily_limit' => 190,
                'enabled' => true,
            ],
        ];

        foreach ($models as $model) {
            AiModel::create($model);
        }
    }
}
