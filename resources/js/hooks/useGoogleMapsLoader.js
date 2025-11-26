import { useEffect, useState } from 'react';

const POLL_INTERVAL = 50;
const TIMEOUT_DURATION = 10000;

const isGoogleMapsReady = () =>
    window.google?.maps?.importLibrary !== undefined;

/**
 * Google Maps JavaScript APIを動的にロードするカスタムフック
 */
export const useGoogleMapsLoader = () => {
    const [isLoaded, setIsLoaded] = useState(false);
    const [loadError, setLoadError] = useState(null);

    useEffect(() => {
        if (isGoogleMapsReady()) {
            setIsLoaded(true);
            return;
        }

        if (document.querySelector('script[src*="maps.googleapis.com"]')) {
            const checkLoaded = setInterval(() => {
                if (isGoogleMapsReady()) {
                    setIsLoaded(true);
                    clearInterval(checkLoaded);
                }
            }, POLL_INTERVAL);
            return () => clearInterval(checkLoaded);
        }

        const apiKey = import.meta.env.VITE_GOOGLE_MAPS_API_KEY;
        if (!apiKey) {
            setLoadError(new Error('Google Maps API key is not configured'));
            return;
        }

        const script = document.createElement('script');
        script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&language=ja&region=JP&loading=async`;
        script.async = true;
        script.defer = true;

        script.onload = () => {
            const checkImportLibrary = setInterval(() => {
                if (isGoogleMapsReady()) {
                    setIsLoaded(true);
                    clearInterval(checkImportLibrary);
                }
            }, POLL_INTERVAL);

            setTimeout(() => {
                clearInterval(checkImportLibrary);
                if (!isGoogleMapsReady()) {
                    setLoadError(new Error('Google Maps importLibrary not available'));
                }
            }, TIMEOUT_DURATION);
        };

        script.onerror = () => {
            setLoadError(new Error('Failed to load Google Maps API'));
        };

        document.head.appendChild(script);
    }, []);

    return { isLoaded, loadError };
};
