import { useEffect, useState } from 'react';

/**
 * Google Maps JavaScript APIを動的にロードするカスタムフック
 *
 * @returns {Object} { isLoaded: boolean, loadError: Error|null }
 */
export const useGoogleMapsLoader = () => {
    const [isLoaded, setIsLoaded] = useState(false);
    const [loadError, setLoadError] = useState(null);

    useEffect(() => {
        // 既にロード済みの場合
        if (window.google && window.google.maps) {
            setIsLoaded(true);
            return;
        }

        // 既にロード中の場合は待機
        if (document.querySelector('script[src*="maps.googleapis.com"]')) {
            const checkLoaded = setInterval(() => {
                if (window.google && window.google.maps) {
                    setIsLoaded(true);
                    clearInterval(checkLoaded);
                }
            }, 100);
            return () => clearInterval(checkLoaded);
        }

        // APIキーの取得
        const apiKey = import.meta.env.VITE_GOOGLE_MAPS_API_KEY;

        if (!apiKey) {
            setLoadError(new Error('Google Maps API key is not configured'));
            return;
        }

        // Google Maps JavaScript APIスクリプトを動的に追加
        const script = document.createElement('script');
        script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&libraries=places&language=ja&region=JP`;
        script.async = true;
        script.defer = true;

        script.onload = () => {
            setIsLoaded(true);
        };

        script.onerror = () => {
            setLoadError(new Error('Failed to load Google Maps API'));
        };

        document.head.appendChild(script);

        return () => {
            // クリーンアップ（スクリプトは削除しない - 他のコンポーネントでも使用される可能性）
        };
    }, []);

    return { isLoaded, loadError };
};
