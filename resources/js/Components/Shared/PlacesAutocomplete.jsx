import { useEffect, useRef, useState } from 'react';

/**
 * Google Places Autocomplete コンポーネント
 *
 * @param {Object} props
 * @param {string} props.value - 入力値
 * @param {Function} props.onChange - 入力値変更時のコールバック
 * @param {Function} props.onPlaceSelected - 場所選択時のコールバック (place, lat, lng) => void
 * @param {boolean} props.isGoogleMapsLoaded - Google Maps APIのロード状態
 * @param {string} props.placeholder - プレースホルダー
 * @param {string} props.error - エラーメッセージ
 * @param {string} props.className - 追加のCSSクラス
 */
export default function PlacesAutocomplete({
    value,
    onChange,
    onPlaceSelected,
    isGoogleMapsLoaded,
    placeholder = '地名を入力してください',
    error = null,
    className = '',
}) {
    const inputRef = useRef(null);
    const autocompleteRef = useRef(null);
    const [isReady, setIsReady] = useState(false);

    useEffect(() => {
        if (!isGoogleMapsLoaded || !inputRef.current) {
            return;
        }

        // Places Autocompleteの初期化
        try {
            autocompleteRef.current = new window.google.maps.places.Autocomplete(
                inputRef.current,
                {
                    componentRestrictions: { country: 'jp' }, // 日本に限定
                    fields: ['name', 'formatted_address', 'geometry'], // 取得する情報
                    types: ['(regions)'], // 地域・都市に限定（住所は除外）
                }
            );

            // 場所選択時のイベントリスナー
            autocompleteRef.current.addListener('place_changed', () => {
                const place = autocompleteRef.current.getPlace();

                if (!place.geometry || !place.geometry.location) {
                    console.warn('Place selected but no geometry available');
                    return;
                }

                const lat = place.geometry.location.lat();
                const lng = place.geometry.location.lng();
                const placeName = place.name || place.formatted_address;

                // コールバック実行
                if (onPlaceSelected) {
                    onPlaceSelected(placeName, lat, lng);
                }
            });

            setIsReady(true);
        } catch (error) {
            console.error('Failed to initialize Places Autocomplete:', error);
        }

        return () => {
            // クリーンアップ
            if (autocompleteRef.current) {
                window.google.maps.event.clearInstanceListeners(autocompleteRef.current);
            }
        };
    }, [isGoogleMapsLoaded, onPlaceSelected]);

    return (
        <div className="relative">
            <input
                ref={inputRef}
                type="text"
                value={value}
                onChange={(e) => onChange(e.target.value)}
                placeholder={isReady ? placeholder : 'Google Mapsを読み込み中...'}
                disabled={!isReady}
                className={`w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent disabled:bg-gray-100 disabled:cursor-not-allowed ${
                    error ? 'border-red-500' : 'border-gray-300'
                } ${className}`}
                aria-required="true"
                aria-invalid={!!error}
                aria-describedby={error ? 'location-error' : undefined}
            />
            {error && (
                <p id="location-error" className="mt-1 text-sm text-red-600" role="alert">
                    {error}
                </p>
            )}
        </div>
    );
}
