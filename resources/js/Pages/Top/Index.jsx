import { useRef, useState } from 'react';
import { router } from '@inertiajs/react';
import AppLayout from '../../Components/Shared/AppLayout';
import Button from '../../Components/Shared/Button';
import PlacesAutocomplete from '../../Components/Shared/PlacesAutocomplete';
import { useGoogleMapsLoader } from '../../hooks/useGoogleMapsLoader';
import { useGeolocation } from '../../hooks/useGeolocation';
import { reverseGeocode } from '../../utils/geocoding';

export default function Index() {
    const placesAutocompleteRef = useRef(null);
    const [locationName, setLocationName] = useState('');
    const [latitude, setLatitude] = useState(null);
    const [longitude, setLongitude] = useState(null);
    const [loading, setLoading] = useState(false);
    const [errors, setErrors] = useState({});

    const { isLoaded: isGoogleMapsLoaded, loadError: googleMapsLoadError } = useGoogleMapsLoader();
    const { getCurrentPosition, loading: geoLoading, error: geoError } = useGeolocation();

    const handleSubmit = (e) => {
        e.preventDefault();
        setErrors({});

        // バリデーション
        const newErrors = {};
        if (!locationName) {
            newErrors.location = '出発地を入力してください';
        }
        if (!latitude || !longitude) {
            newErrors.location = '場所を選択してください（サジェストから選択するか、現在地ボタンを使用してください）';
        }

        if (Object.keys(newErrors).length > 0) {
            setErrors(newErrors);
            return;
        }

        setLoading(true);

        // Inertia.jsでPOSTリクエスト
        router.post('/suggestions', {
            input_latitude: latitude,
            input_longitude: longitude,
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

    // Places Autocompleteで場所が選択された時
    const handlePlaceSelected = (placeName, lat, lng) => {
        setLocationName(placeName);
        setLatitude(lat);
        setLongitude(lng);
        setErrors({});
    };

    const handleGetCurrentLocation = () => {
        getCurrentPosition(async (lat, lng) => {
            setLatitude(lat);
            setLongitude(lng);

            try {
                const placeName = await reverseGeocode(lat, lng);
                placesAutocompleteRef.current?.setProgrammaticValue(placeName);
                setErrors({});
            } catch (error) {
                console.error('Reverse geocoding failed:', error);
                const fallbackName = `緯度: ${lat.toFixed(6)}, 経度: ${lng.toFixed(6)}`;
                placesAutocompleteRef.current?.setProgrammaticValue(fallbackName);
            }
        });
    };

    const setSampleLocation = async (sampleLat, sampleLon, locationName) => {
        setLatitude(sampleLat);
        setLongitude(sampleLon);
        placesAutocompleteRef.current?.setProgrammaticValue(locationName);
        setErrors({});
    };

    return (
        <AppLayout>
            <div className="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
                {/* ヘッダー */}
                <div className="text-center mb-8 sm:mb-12">
                    <h1 className="text-3xl sm:text-4xl lg:text-5xl font-bold text-accent mb-3 sm:mb-4 drop-shadow-sm">
                        日帰り旅行の目的地を探しましょう
                    </h1>
                    <p className="text-base sm:text-lg text-gray-700 px-2 font-medium">
                        出発地を入力して、おすすめの日帰り旅行先を見つけましょう
                    </p>
                </div>

                {/* Google Maps API読み込みエラー */}
                {googleMapsLoadError && (
                    <div className="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg shadow-md">
                        <p className="text-sm text-red-700 font-medium">
                            Google Maps APIの読み込みに失敗しました。ページを再読み込みしてください。
                        </p>
                    </div>
                )}

                {/* フォーム */}
                <form onSubmit={handleSubmit} className="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border-2 border-primary/20 p-6 sm:p-8 hover:shadow-2xl transition-shadow duration-300" aria-label="出発地入力フォーム">
                    {/* 出発地入力 */}
                    <div className="mb-6">
                        <label htmlFor="location" className="block text-sm font-medium text-gray-700 mb-2">
                            出発地 <span className="text-red-500" aria-label="必須">*</span>
                        </label>
                        <PlacesAutocomplete
                            ref={placesAutocompleteRef}
                            value={locationName}
                            onChange={setLocationName}
                            onPlaceSelected={handlePlaceSelected}
                            isGoogleMapsLoaded={isGoogleMapsLoaded}
                            placeholder="例: 東京都渋谷区"
                            error={errors.location}
                        />
                    </div>

                    {/* 現在地取得ボタン */}
                    <div className="mb-6">
                        <button
                            type="button"
                            onClick={handleGetCurrentLocation}
                            disabled={geoLoading || !isGoogleMapsLoaded}
                            className="w-full sm:w-auto px-5 py-2.5 bg-nature hover:bg-forest disabled:bg-gray-400 text-white rounded-lg transition-all duration-200 flex items-center justify-center gap-2 shadow-md hover:shadow-lg transform hover:scale-105 active:scale-95 font-medium"
                        >
                            <svg
                                className="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                />
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                />
                            </svg>
                            {geoLoading ? '現在地を取得中...' : '現在地を使用'}
                        </button>
                        {geoError && (
                            <p className="mt-2 text-sm text-red-700 font-medium" role="alert">
                                {geoError}
                            </p>
                        )}
                    </div>

                    {/* 選択中の座標表示 */}
                    {latitude && longitude && (
                        <div className="mb-6 p-4 bg-gradient-to-r from-warm-100/20 to-warm-200/20 border-l-4 border-primary rounded-lg shadow-sm">
                            <p className="text-sm text-gray-800">
                                <span className="font-bold text-primary">選択中:</span> {locationName}
                            </p>
                            <p className="text-xs text-gray-600 mt-1">
                                緯度: {latitude.toFixed(6)}, 経度: {longitude.toFixed(6)}
                            </p>
                        </div>
                    )}

                    {/* サンプル地点ボタン */}
                    <div className="mb-6">
                        <p className="text-sm font-medium text-gray-700 mb-3">または、サンプル地点から選択:</p>
                        <div className="grid grid-cols-3 gap-2 sm:flex sm:flex-wrap sm:gap-3">
                            <button
                                type="button"
                                onClick={() => setSampleLocation(34.6937, 135.5023, '大阪')}
                                disabled={!isGoogleMapsLoaded}
                                className="px-4 py-2 text-sm font-medium bg-white hover:bg-sky-light/20 disabled:bg-gray-50 disabled:cursor-not-allowed rounded-lg transition-all duration-200 border border-sky/40 hover:border-sky shadow-sm hover:shadow-md transform hover:scale-105 active:scale-95 text-sky-900"
                            >
                                大阪
                            </button>
                            <button
                                type="button"
                                onClick={() => setSampleLocation(35.0116, 135.7681, '京都')}
                                disabled={!isGoogleMapsLoaded}
                                className="px-4 py-2 text-sm font-medium bg-white hover:bg-sky-light/20 disabled:bg-gray-50 disabled:cursor-not-allowed rounded-lg transition-all duration-200 border border-sky/40 hover:border-sky shadow-sm hover:shadow-md transform hover:scale-105 active:scale-95 text-sky-900"
                            >
                                京都
                            </button>
                            <button
                                type="button"
                                onClick={() => setSampleLocation(35.6812, 139.7671, '東京')}
                                disabled={!isGoogleMapsLoaded}
                                className="px-4 py-2 text-sm font-medium bg-white hover:bg-sky-light/20 disabled:bg-gray-50 disabled:cursor-not-allowed rounded-lg transition-all duration-200 border border-sky/40 hover:border-sky shadow-sm hover:shadow-md transform hover:scale-105 active:scale-95 text-sky-900"
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
                        disabled={!latitude || !longitude || !isGoogleMapsLoaded}
                        className="w-full"
                    >
                        おすすめの旅行先を探す
                    </Button>
                </form>
            </div>
        </AppLayout>
    );
}
