<?php

namespace App\Exceptions;

use Exception;

/**
 * 並行分析実行時の例外
 *
 * 複数のワーカーが同じタスクを同時に実行しようとした場合にスローされる
 */
class ConcurrentAnalysisException extends Exception
{
    /**
     * エラーメッセージをカスタマイズ
     */
    public function __construct(string $message = 'Concurrent analysis execution detected', int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * 例外をログに記録するかどうか
     *
     * この例外は正常な並行制御の一部なので、通常のログレベルで記録
     */
    public function report(): bool
    {
        return true;
    }

    /**
     * HTTP レスポンスのステータスコード
     *
     * この例外がHTTPリクエスト中に発生した場合のステータスコード
     */
    public function getStatusCode(): int
    {
        return 409; // Conflict
    }
}
