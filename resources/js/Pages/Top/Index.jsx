import { useState } from 'react';
import { router } from '@inertiajs/react';
import AppLayout from '../../Components/Shared/AppLayout';
import Button from '../../Components/Shared/Button';

export default function Index() {
    const [latitude, setLatitude] = useState('');
    const [longitude, setLongitude] = useState('');
    const [loading, setLoading] = useState(false);
    const [errors, setErrors] = useState({});

    const handleSubmit = (e) => {
        e.preventDefault();
        setErrors({});

        // バリデーション
        const newErrors = {};
        if (!latitude) newErrors.latitude = '緯度を入力してください';
        if (!longitude) newErrors.longitude = '経度を入力してください';

        const lat = parseFloat(latitude);
        const lon = parseFloat(longitude);

        if (latitude && (isNaN(lat) || lat < -90 || lat > 90)) {
            newErrors.latitude = '緯度は-90から90の範囲で入力してください';
        }
        if (longitude && (isNaN(lon) || lon < -180 || lon > 180)) {
            newErrors.longitude = '経度は-180から180の範囲で入力してください';
        }

        if (Object.keys(newErrors).length > 0) {
            setErrors(newErrors);
            return;
        }

        setLoading(true);

        // Inertia.jsでPOSTリクエスト
        router.post('/suggestions', {
            input_latitude: lat,
            input_longitude: lon,
        }, {
            onError: (errors) => {
                setErrors(errors);
                setLoading(false);
            },
            onSuccess: () => {
                setLoading(false);
            },
        });
    };

    // デモ用のサンプル座標ボタン
    const setSampleLocation = (sampleLat, sampleLon, locationName) => {
        setLatitude(sampleLat.toString());
        setLongitude(sampleLon.toString());
    };

    return (
        <AppLayout>
            <div className="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
                {/* ヘッダー */}
                <div className="text-center mb-8 sm:mb-12">
                    <h1 className="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-3 sm:mb-4">
                        日帰り旅行の目的地を探しましょう
                    </h1>
                    <p className="text-base sm:text-lg text-gray-600 px-2">
                        出発地の緯度・経度を入力して、おすすめの日帰り旅行先を見つけましょう
                    </p>
                    <p className="text-xs sm:text-sm text-gray-500 mt-2">
                        ※Phase 5でGoogle Places/GPS機能を統合予定
                    </p>
                </div>

                {/* フォーム */}
                <form onSubmit={handleSubmit} className="bg-white rounded-lg shadow-md p-6 sm:p-8" aria-label="出発地入力フォーム">
                    {/* 緯度入力 */}
                    <div className="mb-6">
                        <label htmlFor="latitude" className="block text-sm font-medium text-gray-700 mb-2">
                            緯度 <span className="text-red-500" aria-label="必須">*</span>
                        </label>
                        <input
                            type="text"
                            id="latitude"
                            name="latitude"
                            value={latitude}
                            onChange={(e) => setLatitude(e.target.value)}
                            className={`w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent ${
                                errors.latitude ? 'border-red-500' : 'border-gray-300'
                            }`}
                            placeholder="例: 35.6812"
                            aria-required="true"
                            aria-invalid={!!errors.latitude}
                            aria-describedby={errors.latitude ? 'latitude-error' : undefined}
                        />
                        {errors.latitude && (
                            <p id="latitude-error" className="mt-1 text-sm text-red-600" role="alert">
                                {errors.latitude}
                            </p>
                        )}
                    </div>

                    {/* 経度入力 */}
                    <div className="mb-6">
                        <label htmlFor="longitude" className="block text-sm font-medium text-gray-700 mb-2">
                            経度 <span className="text-red-500" aria-label="必須">*</span>
                        </label>
                        <input
                            type="text"
                            id="longitude"
                            name="longitude"
                            value={longitude}
                            onChange={(e) => setLongitude(e.target.value)}
                            className={`w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent ${
                                errors.longitude ? 'border-red-500' : 'border-gray-300'
                            }`}
                            placeholder="例: 139.7671"
                            aria-required="true"
                            aria-invalid={!!errors.longitude}
                            aria-describedby={errors.longitude ? 'longitude-error' : undefined}
                        />
                        {errors.longitude && (
                            <p id="longitude-error" className="mt-1 text-sm text-red-600" role="alert">
                                {errors.longitude}
                            </p>
                        )}
                    </div>

                    {/* サンプル座標ボタン */}
                    <div className="mb-6">
                        <p className="text-sm font-medium text-gray-700 mb-2">サンプル座標:</p>
                        <div className="grid grid-cols-3 gap-2 sm:flex sm:flex-wrap">
                            <button
                                type="button"
                                onClick={() => setSampleLocation(34.6937, 135.5023, '大阪')}
                                className="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded-md transition-colors"
                            >
                                大阪
                            </button>
                            <button
                                type="button"
                                onClick={() => setSampleLocation(35.0116, 135.7681, '京都')}
                                className="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded-md transition-colors"
                            >
                                京都
                            </button>
                            <button
                                type="button"
                                onClick={() => setSampleLocation(35.6812, 139.7671, '東京')}
                                className="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded-md transition-colors"
                            >
                                東京
                            </button>
                        </div>
                    </div>

                    {/* 送信ボタン */}
                    <Button
                        type="submit"
                        variant="primary"
                        size="lg"
                        loading={loading}
                        className="w-full"
                    >
                        おすすめの旅行先を探す
                    </Button>
                </form>
            </div>
        </AppLayout>
    );
}
