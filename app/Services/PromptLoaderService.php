<?php

namespace App\Services;

use Exception;

/**
 * プロンプトファイルの読み込みと変数置換を行うサービス
 */
class PromptLoaderService
{
    /**
     * プロンプトファイルを読み込み、変数を置換する
     *
     * @param  string  $promptFileName  プロンプトファイル名（例: "spot_listing.txt"）
     * @param  array<string, mixed>  $variables  置換する変数の連想配列（例: ["cluster_name" => "神戸市"]）
     * @return string 変数置換後のプロンプト文字列
     *
     * @throws Exception プロンプトファイルが存在しない場合
     */
    public function load(string $promptFileName, array $variables = []): string
    {
        $promptPath = storage_path("prompts/{$promptFileName}");

        if (! file_exists($promptPath)) {
            throw new Exception("Prompt file not found: {$promptFileName}");
        }

        $promptTemplate = file_get_contents($promptPath);

        if ($promptTemplate === false) {
            throw new Exception("Failed to read prompt file: {$promptFileName}");
        }

        // 変数を置換（{{variable_name}} → 実際の値）
        return $this->replaceVariables($promptTemplate, $variables);
    }

    /**
     * プロンプトテンプレート内の変数を置換
     *
     * @param  string  $template  プロンプトテンプレート
     * @param  array<string, mixed>  $variables  置換する変数の連想配列
     * @return string 置換後の文字列
     */
    private function replaceVariables(string $template, array $variables): string
    {
        foreach ($variables as $key => $value) {
            // 配列や複雑なデータ構造の場合はJSON形式に変換
            if (is_array($value) || is_object($value)) {
                $value = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            }

            // {{key}} を実際の値に置換
            $template = str_replace("{{{$key}}}", (string) $value, $template);
        }

        return $template;
    }
}
