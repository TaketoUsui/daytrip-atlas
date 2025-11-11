/**
 * 逆ジオコーディング: 座標から地名を取得
 *
 * @param {number} lat - 緯度
 * @param {number} lng - 経度
 * @returns {Promise<string>} - 地名（住所）
 */
export const reverseGeocode = async (lat, lng) => {
    if (!window.google || !window.google.maps) {
        throw new Error('Google Maps API is not loaded');
    }

    return new Promise((resolve, reject) => {
        const geocoder = new window.google.maps.Geocoder();
        const latLng = new window.google.maps.LatLng(lat, lng);

        geocoder.geocode({ location: latLng }, (results, status) => {
            if (status === 'OK' && results && results.length > 0) {
                // 最初の結果から地名を取得
                // locality（市区町村）または administrative_area_level_1（都道府県）を優先
                const addressComponents = results[0].address_components;

                // 市区町村を探す
                const locality = addressComponents.find(
                    (component) => component.types.includes('locality')
                );

                if (locality) {
                    resolve(locality.long_name);
                    return;
                }

                // 都道府県を探す
                const prefecture = addressComponents.find(
                    (component) => component.types.includes('administrative_area_level_1')
                );

                if (prefecture) {
                    resolve(prefecture.long_name);
                    return;
                }

                // フォールバック: formatted_addressを使用
                resolve(results[0].formatted_address);
            } else {
                reject(new Error('Geocoding failed: ' + status));
            }
        });
    });
};

/**
 * ジオコーディング: 地名から座標を取得
 *
 * @param {string} address - 地名・住所
 * @returns {Promise<{lat: number, lng: number}>} - 座標
 */
export const geocode = async (address) => {
    if (!window.google || !window.google.maps) {
        throw new Error('Google Maps API is not loaded');
    }

    return new Promise((resolve, reject) => {
        const geocoder = new window.google.maps.Geocoder();

        geocoder.geocode(
            {
                address: address,
                componentRestrictions: { country: 'JP' }, // 日本に限定
            },
            (results, status) => {
                if (status === 'OK' && results && results.length > 0) {
                    const location = results[0].geometry.location;
                    resolve({
                        lat: location.lat(),
                        lng: location.lng(),
                    });
                } else {
                    reject(new Error('Geocoding failed: ' + status));
                }
            }
        );
    });
};
