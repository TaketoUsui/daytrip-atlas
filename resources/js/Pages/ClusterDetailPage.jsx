import React from 'react';
import { Link } from '@inertiajs/react';
// 子コンポーネントとして SpotInterestButton をインポートします
// (このファイルは次のステップで作成します)
import SpotInterestButton from '@/Components/SpotInterestButton';

/**
 * No.5 観光地域詳細ページ (FUNC-004, FUNC-005)
 * Controller (SuggestionItemPageController) から props として 'item' を受け取ります
 */
export default function ClusterDetailPage({ item }) {

    // Controller から渡された Props を安全に展開
    const { catchphrase, cluster, modelPlan } = item;
    const modelPlanItems = modelPlan?.items || [];

    // --- スタイル定義 (最低限のデザイン) ---
    const styles = {
        pageContainer: {
            padding: '20px',
            fontFamily: 'sans-serif',
            maxWidth: '800px',
            margin: '0 auto'
        },
        header: {
            borderBottom: '2px solid #eee',
            paddingBottom: '10px'
        },
        catchphrase: {
            fontSize: '1.8em',
            margin: '0 0 10px 0',
            fontWeight: 'bold'
        },
        clusterName: {
            fontSize: '1.2em',
            color: '#555',
            marginBottom: '20px'
        },
        planTitle: {
            fontSize: '1.5em',
            marginTop: '30px',
            borderLeft: '5px solid #3498db',
            paddingLeft: '10px'
        },
        timelineContainer: {
            marginTop: '20px'
        },
        timelineItem: {
            borderLeft: '2px solid #ddd',
            padding: '15px 20px 30px 20px',
            position: 'relative'
        },
        timelineDot: { // タイムラインの丸
            position: 'absolute',
            left: '-9px', // (dot width / 2) + border width
            top: '18px',
            width: '16px',
            height: '16px',
            backgroundColor: '#fff',
            border: '3px solid #3498db',
            borderRadius: '50%'
        },
        spotName: {
            fontSize: '1.2em',
            fontWeight: 'bold'
        },
        spotInfo: {
            color: '#666',
            fontSize: '0.9em'
        }
    };

    return (
        <div style={styles.pageContainer}>
            {/* 戻るリンク */}
            <Link href="/" style={{ textDecoration: 'none' }}>
                &larr; トップページに戻る
            </Link>

            {/* 1. ヘッダー情報 (キャッチコピー, クラスター名) [cite: MVP_API設計改] */}
            <header style={styles.header}>
                <h1 style={styles.catchphrase}>{catchphrase.content}</h1>
                <p style={styles.clusterName}>{cluster.name}</p>
            </header>

            {/* 2. モデルプランのタイムライン (FUNC-004) [cite: MVP要件定義書] */}
            <h2 style={styles.planTitle}>{modelPlan?.name}</h2>
            <div style={styles.timelineContainer}>
                {modelPlanItems.length > 0 ? (
                    modelPlanItems.map((planItem) => (
                        <div key={planItem.id} style={styles.timelineItem}>
                            <div style={styles.timelineDot}></div>

                            <h3 style={styles.spotName}>
                                {planItem.spot.name}
                            </h3>

                            <p style={styles.spotInfo}>
                                <strong>滞在目安:</strong> {planItem.spot.min_duration_minutes}分
                                <br />
                                <strong>住所:</strong> {planItem.spot.address_detail}
                            </p>

                            {/* 3. 明示的フィードバック (FUNC-005) [cite: MVP要件定義書] */}
                            {/* 子コンポーネントを呼び出し、spot.id を渡す */}
                            <SpotInterestButton spotId={planItem.spot.id} />
                        </div>
                    ))
                ) : (
                    <p>このプランにはスポットが登録されていません。</p>
                )}
            </div>
        </div>
    );
}
