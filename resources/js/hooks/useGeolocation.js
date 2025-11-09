import { useState } from 'react';

/**
 * Geolocation APIを使用して現在地を取得するカスタムフック
 *
 * @returns {Object} { getCurrentPosition: Function, loading: boolean, error: string|null }
 */
export const useGeolocation = () => {
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);

    /**
     * 現在地を取得
     *
     * @param {Function} onSuccess - 成功時のコールバック (lat, lng) => void
     */
    const getCurrentPosition = (onSuccess) => {
        setLoading(true);
        setError(null);

        if (!navigator.geolocation) {
            setError('お使いのブラウザは位置情報取得に対応していません');
            setLoading(false);
            return;
        }

        navigator.geolocation.getCurrentPosition(
            (position) => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                setLoading(false);
                if (onSuccess) {
                    onSuccess(lat, lng);
                }
            },
            (err) => {
                setLoading(false);

                switch (err.code) {
                    case err.PERMISSION_DENIED:
                        setError('位置情報の取得が拒否されました。ブラウザの設定を確認してください。');
                        break;
                    case err.POSITION_UNAVAILABLE:
                        setError('位置情報を取得できませんでした。');
                        break;
                    case err.TIMEOUT:
                        setError('位置情報の取得がタイムアウトしました。もう一度お試しください。');
                        break;
                    default:
                        setError('位置情報の取得中にエラーが発生しました。');
                        break;
                }
            },
            {
                enableHighAccuracy: true, // 高精度モード
                timeout: 10000, // 10秒でタイムアウト
                maximumAge: 0, // キャッシュを使用しない
            }
        );
    };

    return { getCurrentPosition, loading, error };
};
