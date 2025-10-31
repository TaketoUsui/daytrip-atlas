import React, { useState, useEffect } from 'react';
// ページ遷移（リダイレクト）のために Inertia の router をインポートします
import { router } from '@inertiajs/react';
// API通信のために axios をインポートします
import axios from 'axios';

// ポーリングの間隔 (ミリ秒)
const POLLING_INTERVAL_MS = 3000; // 3秒ごと

/**
 * No.3 提案待機ページ (FUNC-002)
 * Controller (SuggestionPageController) から props として 'uuid' を受け取ります
 */
export default function SuggestionWaitPage({ uuid }) {

    // サーバーから取得した進捗状況を管理するState
    const [status, setStatus] = useState('pending'); // 'pending', 'analyzing_items', 'complete', 'failed' 等
    const [message, setMessage] = useState('提案のリクエストを受け付けました...');
    const [foundClusters, setFoundClusters] = useState([]);

    useEffect(() => {
        // ポーリング（定期実行）のタイマーID
        let intervalId = null;

        /**
         * No.6 提案ステータス取得APIを呼び出す関数
         */
        const fetchStatus = async () => {
            try {
                // API (No.6) へGETリクエスト
                const response = await axios.get(`/api/v1/suggestions/${uuid}/status`);

                // APIリソース (SuggestionStatusResource) は 'data' に格納されています
                const data = response.data.data;

                // 取得したデータでReactのStateを更新
                setStatus(data.status);
                setMessage(data.message);
                setFoundClusters(data.found_clusters || []); // API定義 (No.6)

                // 1. 提案が完了した場合 (FUNC-002 の要件)
                if (data.status === 'complete') {
                    // ポーリングを停止
                    clearInterval(intervalId);

                    // No.4 提案結果一覧ページへリダイレクト
                    router.visit(`/suggestions/${uuid}`);
                }

                // 2. 提案が失敗した場合 (FUNC-002 の要件)
                if (data.status === 'failed') {
                    // ポーリングを停止
                    clearInterval(intervalId);
                    // (エラー処理は下のJSXで行う)
                }

            } catch (error) {
                console.error('ステータスの取得に失敗しました:', error);
                // API自体が 404 や 500 を返した場合
                setStatus('failed');
                setMessage('提案の作成に失敗しました。サーバーエラーが発生しました。');
                clearInterval(intervalId);
            }
        };

        // ページが読み込まれたら、まず1回すぐに実行
        fetchStatus();

        // その後、POLLING_INTERVAL_MS ごとに定期実行
        intervalId = setInterval(fetchStatus, POLLING_INTERVAL_MS);

        // クリーンアップ関数: このコンポーネントが不要になったら（例: ページ遷移時）
        // 必ずタイマーを停止し、メモリリークを防ぎます。
        return () => {
            if (intervalId) {
                clearInterval(intervalId);
            }
        };

    }, [uuid]); // uuid が変わった場合にのみ useEffect を再実行 (通常は発生しない)

    // --- レンダリング ---

    // 失敗時 (FUNC-002 の要件)
    if (status === 'failed') {
        return (
            <div style={{ padding: '20px', fontFamily: 'sans-serif' }}>
                <h1>提案の作成に失敗しました</h1>
                <p style={{ color: 'red' }}>{message}</p>
                <a href="/">トップページへ戻る</a>
            </div>
        );
    }

    // 待機中
    return (
        <div style={{ padding: '20px', fontFamily: 'sans-serif' }}>
            <h1>AIがあなたへのおすすめを分析中...</h1>
            <p style={{ fontSize: '1.2em', fontWeight: 'bold' }}>{message}</p>

            {/*  */}
            <div style={{ margin: '20px 0', fontSize: '2em' }}>
                {/* 簡易的なローディングスピナー */}
                <div style={{
                    border: '4px solid #f3f3f3',
                    borderTop: '4px solid #3498db',
                    borderRadius: '50%',
                    width: '30px',
                    height: '30px',
                    animation: 'spin 1s linear infinite'
                }}></div>
                {/* CSSアニメーション用の@keyframesが別途必要ですが、最低限の表示として */}
            </div>

            {/* 中間生成物 (found_clusters) の表示 */}
            {foundClusters.length > 0 && (
                <div>
                    <h3>見つかった候補地:</h3>
                    <ul style={{ listStyle: 'none', paddingLeft: 0 }}>
                        {foundClusters.map((cluster) => (
                            <li key={cluster.id} style={{
                                background: '#eee',
                                padding: '5px',
                                margin: '5px',
                                borderRadius: '4px'
                            }}>
                                {cluster.name}
                            </li>
                        ))}
                    </ul>
                </div>
            )}
        </div>
    );
}

// 簡易ローディングスピナー用のアニメーションを <style> タグとして埋め込む
// (実際には app.css などに記述するのが望ましい)
const style = document.createElement('style');
style.innerHTML = `
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
`;
document.head.appendChild(style);
