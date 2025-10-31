import React, { useRef } from 'react';
import { useForm } from '@inertiajs/react';
// Google Maps API 関連をインポート
import { Autocomplete, useJsApiLoader } from '@react-google-maps/api';

/**
 * Google Maps API のライブラリとして 'places' を指定
 */
const libraries = ['places'];

/**
 * No.1 トップページ (FUNC-001)
 * Google Places Autocomplete API を利用
 */
export default function TopPage({ tags }) {

    const { data, setData, post, processing, errors } = useForm({
        // 緯度・経度はフォームデータとして保持します
        latitude: '',
        longitude: '',
        tags: [],
    });

    /**
     * Autocomplete コンポーネントのインスタンスを保持するための Ref
     */
    const autocompleteRef = useRef(null);

    /**
     * Google Maps JavaScript API の読み込み
     */
    const { isLoaded } = useJsApiLoader({
        // .env ファイルから API キーを読み込む
        googleMapsApiKey: import.meta.env.VITE_GOOGLE_MAPS_API_KEY,
        libraries: libraries,
    });

    /**
     * Autocomplete がロードされたときのハンドラ
     */
    const onLoad = (autocomplete) => {
        autocompleteRef.current = autocomplete;
    };

    /**
     * Autocomplete で場所が選択されたときのハンドラ
     */
    const onPlaceChanged = () => {
        if (autocompleteRef.current !== null) {
            // 選択された場所の情報を取得
            const place = autocompleteRef.current.getPlace();

            if (place.geometry && place.geometry.location) {
                const lat = place.geometry.location.lat();
                const lng = place.geometry.location.lng();

                // フォームデータを更新
                setData(data => ({
                    ...data,
                    latitude: lat,
                    longitude: lng
                }));
            } else {
                // 場所が正しく選択されなかった場合 (例: Enterキーのみ押下)
                console.warn("場所情報が取得できませんでした。");
                // 必要に応じて緯度経度をクリアする
                setData(data => ({
                    ...data,
                    latitude: '',
                    longitude: ''
                }));
            }
        }
    };

    /**
     * タグのチェックボックスが変更されたときのハンドラ
     */
    const handleTagChange = (e) => {
        const tagId = parseInt(e.target.value, 10);
        let newSelectedTags;

        if (e.target.checked) {
            newSelectedTags = [...data.tags, tagId];
        } else {
            newSelectedTags = data.tags.filter((id) => id !== tagId);
        }
        setData('tags', newSelectedTags);
    };

    /**
     * フォーム送信時のハンドラ
     */
    const submit = (e) => {
        e.preventDefault();
        // '/suggestions' へPOST
        post('/suggestions');
    };

    // APIロード中の表示
    if (!isLoaded) {
        return <div>地図情報を読み込んでいます...</div>;
    }

    // 見た目はこだわらず、機能性を重視した最低限のJSX
    return (
        <div style={{ padding: '20px', fontFamily: 'sans-serif' }}>
            <h1>日帰り地図帳</h1>
            <p>出発地と興味のあるタグを選んでください。</p>

            <form onSubmit={submit}>
                {/* 1. 出発地入力 (Google Places Autocomplete API) */}
                <div style={{ marginBottom: '15px' }}>
                    <label htmlFor="departure" style={{ display: 'block' }}>出発地:</label>
                    <Autocomplete
                        onLoad={onLoad}
                        onPlaceChanged={onPlaceChanged}
                        // 国を日本に限定する（任意）
                        options={{ componentRestrictions: { country: 'jp' } }}
                    >
                        <input
                            id="departure"
                            type="text"
                            placeholder="例: 東京駅, 大阪城公園"
                            style={{ width: '300px' }}
                        />
                    </Autocomplete>
                    {/* 緯度・経度のエラーはここ（または別の場所）に表示できます。
                      StoreSuggestionRequest は緯度・経度を必須としているため、
                      場所が選択されないとエラーになります。
                    */}
                    {errors.latitude && <div style={{ color: 'red' }}>出発地をリストから選択してください。</div>}
                    {errors.longitude && <div style={{ color: 'red' }}>{errors.longitude}</div>}
                </div>

                {/* 2. タグ選択 */}
                <div style={{ marginBottom: '15px' }}>
                    <p style={{ fontWeight: 'bold' }}>興味のあるタグ (複数選択可):</p>
                    {tags && tags.length > 0 ? (
                        tags.map((tag) => (
                            <div key={tag.id}>
                                <input
                                    type="checkbox"
                                    id={`tag-${tag.id}`}
                                    value={tag.id}
                                    onChange={handleTagChange}
                                    checked={data.tags.includes(tag.id)}
                                />
                                <label htmlFor={`tag-${tag.id}`} style={{ marginLeft: '5px' }}>
                                    {tag.name}
                                </label>
                            </div>
                        ))
                    ) : (
                        <p>タグが登録されていません。</p>
                    )}
                    {errors.tags && <div style={{ color: 'red' }}>{errors.tags}</div>}
                </div>

                {/* 3. 送信ボタン */}
                <button
                    type="submit"
                    disabled={processing}
                    style={{ padding: '10px 15px', fontSize: '16px' }}
                >
                    {processing ? '提案を作成中...' : '提案を開始する'}
                </button>
            </form>
        </div>
    );
}
