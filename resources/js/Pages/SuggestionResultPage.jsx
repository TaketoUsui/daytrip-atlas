import React from 'react';
// ページ内遷移（SPA）のために Inertia の Link コンポーネントをインポートします
import { Link } from '@inertiajs/react';

/**
 * No.4 提案結果一覧ページ (FUNC-003)
 * Controller (SuggestionPageController) から props として 'suggestionSet' を受け取ります
 *
 */
export default function SuggestionResultPage({ suggestionSet }) {

    // suggestionSet とその中の items 配列を安全に取り出します
    const items = suggestionSet?.items || [];

    // --- スタイル定義 (最低限のデザイン) ---
    const styles = {
        pageContainer: {
            padding: '20px',
            fontFamily: 'sans-serif',
            backgroundColor: '#f9f9f9'
        },
        header: {
            borderBottom: '2px solid #eee',
            paddingBottom: '10px'
        },
        cardContainer: {
            display: 'flex',
            flexDirection: 'column',
            gap: '20px', // カード間の隙間
            marginTop: '20px'
        },
        cardLink: {
            display: 'block',
            textDecoration: 'none',
            color: '#333',
            border: '1px solid #ddd',
            borderRadius: '8px',
            backgroundColor: '#fff',
            boxShadow: '0 2px 4px rgba(0,0,0,0.05)',
            overflow: 'hidden', // 画像の角を丸くするため
            transition: 'box-shadow 0.2s'
        },
        cardImage: {
            width: '100%',
            height: '180px',
            objectFit: 'cover', // 画像をトリミングしてコンテナに合わせる
            borderBottom: '1px solid #eee'
        },
        cardContent: {
            padding: '15px'
        },
        cardTitle: { // キャッチコピー (FUNC-003)
            fontSize: '1.4em',
            margin: '0 0 10px 0',
            fontWeight: 'bold'
        },
        cardInfo: { // 場所名や移動時間
            fontSize: '0.9em',
            margin: '5px 0',
            color: '#555'
        }
    };

    return (
        <div style={styles.pageContainer}>
            <Link href="/" style={{ textDecoration: 'none' }}>
                &larr; トップページに戻る
            </Link>
            <h1 style={styles.header}>AIからの日帰り旅行プラン提案</h1>

            {/* 提案アイテム (items) がない場合の表示 */}
            {items.length === 0 ? (
                <p>提案が見つかりませんでした。トップページから再度お試しください。</p>
            ) : (
                <div style={styles.cardContainer}>
                    {/* suggestionSet.items をループ処理
                    */}
                    {items.map((item) => (
                        <Link
                            // 1. リンク先 (No.5 のURI)
                            // item.uuid を使って詳細ページのURLを生成します
                            href={`/suggested-cluster/${item.uuid}`}
                            key={item.uuid}
                            style={styles.cardLink}
                            // ホバー時に影を少し濃くする (見た目のみ)
                            onMouseOver={e => e.currentTarget.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)'}
                            onMouseOut={e => e.currentTarget.style.boxShadow = '0 2px 4px rgba(0,0,0,0.05)'}
                        >
                            {/* 2. キービジュアル画像 (FUNC-003) */}
                            {/* Controllerから渡される storage_path を利用
                              (このパスが公開URLとして解決可能である前提)
                            */}
                            <img
                                src={item.key_visual_image.storage_path}
                                alt={item.key_visual_image.alt_text}
                                style={styles.cardImage}
                            />

                            <div style={styles.cardContent}>
                                {/* 3. キャッチコピー (FUNC-003) */}
                                <h2 style={styles.cardTitle}>
                                    {item.catchphrase.content}
                                </h2>

                                {/* 4. 場所 (クラスター名) */}
                                <p style={styles.cardInfo}>
                                    <strong>場所:</strong> {item.cluster.name}
                                </p>

                                {/* 5. 移動時間 (FUNC-003) */}
                                <p style={styles.cardInfo}>
                                    <strong>移動目安:</strong> {item.travel_time_text}
                                </p>
                            </div>
                        </Link>
                    ))}
                </div>
            )}
        </div>
    );
}
