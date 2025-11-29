<?php

return [
    /*
    |--------------------------------------------------------------------------
    | AI非同期分析の有効化
    |--------------------------------------------------------------------------
    |
    | true: 非同期AI分析が有効（バックグラウンドでAI分析を実行）
    | false: 非同期AI分析が無効（レガシー動作）
    |
    */
    'async_analysis_enabled' => env('AI_ASYNC_ANALYSIS_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | タスク選定設定
    |--------------------------------------------------------------------------
    |
    | 非同期AI分析タスクの選定ロジック設定
    |
    */
    'task_selection' => [
        // Aタイプ（スポット詳細分析）とBタイプ（モデルプラン生成）の比率
        'a_type_probability' => env('AI_TASK_A_TYPE_PROBABILITY', 0.5), // 50%

        // 同時実行制御: 同じタイプのタスクを同時に実行する最大数
        'max_concurrent_tasks_per_type' => env('AI_MAX_CONCURRENT_TASKS_PER_TYPE', 3),

        // タスクロックのタイムアウト（分）
        'task_lock_timeout_minutes' => env('AI_TASK_LOCK_TIMEOUT_MINUTES', 30),

        // スポット詳細分析の失敗カウント閾値
        // この回数以上失敗したスポットはタスク選択対象から除外される
        'spot_detail_max_failure_count' => env('AI_SPOT_DETAIL_MAX_FAILURE_COUNT', 5),
    ],

    /*
    |--------------------------------------------------------------------------
    | キャッシュTTL設定
    |--------------------------------------------------------------------------
    |
    | AI分析結果の有効期限（秒）
    |
    */
    'cache_ttl' => [
        // スポットリストアップ結果
        'spot_listing' => env('AI_CACHE_TTL_SPOT_LISTING', 60 * 60 * 24 * 30), // 30日

        // スポット優先度付け結果
        'spot_priority' => env('AI_CACHE_TTL_SPOT_PRIORITY', 60 * 60 * 24 * 30), // 30日

        // メインスポット選定結果
        'main_spot' => env('AI_CACHE_TTL_MAIN_SPOT', 60 * 60 * 24 * 30), // 30日

        // 画像選定結果
        'image_selection' => env('AI_CACHE_TTL_IMAGE', 60 * 60 * 24 * 30), // 30日

        // スポット詳細分析結果
        'spot_detail' => env('AI_CACHE_TTL_SPOT_DETAIL', 60 * 60 * 24 * 90), // 90日

        // キャッチフレーズ生成結果
        'catchphrase' => env('AI_CACHE_TTL_CATCHPHRASE', 60 * 60 * 24 * 7), // 7日

        // モデルプラン生成結果
        'model_plan' => env('AI_CACHE_TTL_MODEL_PLAN', 60 * 60 * 24 * 30), // 30日
    ],

    /*
    |--------------------------------------------------------------------------
    | AIモデル選択設定
    |--------------------------------------------------------------------------
    |
    | AIモデルの選択と実行制御に関する設定
    |
    */
    'model_selection' => [
        // モデル実行間隔の安全マージン（モデルのinterval_minutesに対する倍率）
        'interval_safety_margin' => env('AI_MODEL_INTERVAL_SAFETY_MARGIN', 1.2), // 20%の余裕

        // モデル選択時に過去何時間分の実行履歴を確認するか
        'execution_history_hours' => env('AI_MODEL_EXECUTION_HISTORY_HOURS', 24),

        // Gemini API日次上限のリセットタイムゾーン
        // Gemini APIは太平洋時間（PT）の午前0時にリセット
        // 標準時（PST）: UTC-8, JST 17:00にリセット
        // 夏時間（PDT）: UTC-7, JST 16:00にリセット
        'api_reset_timezone' => env('AI_API_RESET_TIMEZONE', 'America/Los_Angeles'),
    ],

    /*
    |--------------------------------------------------------------------------
    | リトライ設定
    |--------------------------------------------------------------------------
    |
    | AI分析ジョブのリトライ制御
    |
    */
    'retry' => [
        // 最大リトライ回数
        'max_attempts' => env('AI_RETRY_MAX_ATTEMPTS', 3),

        // リトライ間隔（秒）
        'backoff_seconds' => env('AI_RETRY_BACKOFF_SECONDS', 60),
    ],

    /*
    |--------------------------------------------------------------------------
    | デバッグ設定
    |--------------------------------------------------------------------------
    */
    'debug' => [
        // AI分析ジョブの詳細ログを出力するか
        'log_job_execution' => env('AI_DEBUG_LOG_JOB_EXECUTION', false),

        // タスク選定ロジックのログを出力するか
        'log_task_selection' => env('AI_DEBUG_LOG_TASK_SELECTION', false),
    ],
];
