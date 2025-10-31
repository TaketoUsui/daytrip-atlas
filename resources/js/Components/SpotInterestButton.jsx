import React, { useState } from 'react';
import axios from 'axios';

/**
 * FUNC-005 明示的フィードバック機能 を担当する子コンポーネント
 * [cite: MVP要件定義書]
 */
export default function SpotInterestButton({ spotId }) {

    // null: 未選択, 'interested': 気になる, 'dismissed': 興味なし
    const [interestStatus, setInterestStatus] = useState(null);
    const [isLoading, setIsLoading] = useState(false);

    /**
     * ボタンクリック時の処理 (API No.7) [cite: MVP_API設計改]
     */
    const handleInterestClick = async (status) => {
        // すでに同じ状態が選択されているか、ローディング中なら何もしない
        if (isLoading || interestStatus === status) return;

        setIsLoading(true);

        // 楽観的更新 (FUNC-005: UI上で即座にフィードバック) [cite: MVP要件定義書]
        const previousStatus = interestStatus;
        setInterestStatus(status);

        try {
            // API (No.7) へPOSTリクエスト
            await axios.post(`/api/v1/spots/${spotId}/interest`, {
                status: status, // 'interested' または 'dismissed'
            });
            // 成功時は楽観的更新の状態 (status) を維持
        } catch (error) {
            console.error('フィードバックの送信に失敗しました:', error);
            // 失敗時はUIを元に戻す (ロールバック)
            setInterestStatus(previousStatus);
        } finally {
            setIsLoading(false);
        }
    };

    // --- スタイル定義 ---
    // (Tailwind CSSが使えるなら className で切り替える方が望ましいですが、
    //  ここでは最低限のインラインスタイルで実装します)
    const getButtonStyle = (status) => {
        const isSelected = (interestStatus === status);
        return {
            padding: '8px 12px',
            marginRight: '10px',
            border: '1px solid',
            borderColor: isSelected ? (status === 'interested' ? '#3498db' : '#e74c3c') : '#ccc',
            backgroundColor: isSelected ? (status === 'interested' ? '#eaf5fd' : '#fdeded') : '#fff',
            color: isSelected ? (status === 'interested' ? '#3498db' : '#e74c3c') : '#555',
            borderRadius: '20px',
            cursor: isLoading ? 'wait' : 'pointer',
            opacity: isLoading ? 0.7 : 1,
            transition: 'all 0.2s'
        };
    };

    return (
        <div style={{ marginTop: '15px' }}>
            <button
                style={getButtonStyle('interested')}
                onClick={() => handleInterestClick('interested')}
                disabled={isLoading}
            >
                ❤️ 気になる
            </button>
            <button
                style={getButtonStyle('dismissed')}
                onClick={() => handleInterestClick('dismissed')}
                disabled={isLoading}
            >
                🗑️ 興味なし
            </button>
        </div>
    );
}
