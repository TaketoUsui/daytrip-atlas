import { forwardRef, useCallback, useEffect, useImperativeHandle, useRef, useState } from 'react';

const DEBOUNCE_DELAY = 300;
const MIN_INPUT_LENGTH = 1;

/**
 * Google Places Autocomplete コンポーネント
 * Place Autocomplete Data APIを使用してカスタムUIを実装
 */
const PlacesAutocomplete = forwardRef(({
    value,
    onChange,
    onPlaceSelected,
    isGoogleMapsLoaded,
    placeholder = '地名を入力してください',
    error = null,
    className = '',
}, ref) => {
    const inputRef = useRef(null);
    const suggestionsRef = useRef(null);
    const sessionTokenRef = useRef(null);
    const isManualInputRef = useRef(true);
    const [isReady, setIsReady] = useState(false);
    const [suggestions, setSuggestions] = useState([]);
    const [showSuggestions, setShowSuggestions] = useState(false);
    const [selectedIndex, setSelectedIndex] = useState(-1);

    const closeSuggestions = useCallback(() => {
        setShowSuggestions(false);
        setSuggestions([]);
        setSelectedIndex(-1);
    }, []);

    useImperativeHandle(ref, () => ({
        setProgrammaticValue: (newValue) => {
            isManualInputRef.current = false;
            onChange(newValue);
        },
        focus: () => {
            inputRef.current?.focus();
        },
    }), [onChange]);

    useEffect(() => {
        if (!isGoogleMapsLoaded) return;

        const initializePlacesAPI = async () => {
            try {
                await window.google.maps.importLibrary('places');
                sessionTokenRef.current = new window.google.maps.places.AutocompleteSessionToken();
                setIsReady(true);
            } catch (error) {
                console.error('Failed to initialize Places API:', error);
            }
        };

        initializePlacesAPI();
    }, [isGoogleMapsLoaded]);

    const fetchSuggestions = useCallback(async (inputValue) => {
        if (!inputValue || inputValue.length < MIN_INPUT_LENGTH || !isReady) {
            closeSuggestions();
            return;
        }

        try {
            const { suggestions: fetchedSuggestions } =
                await window.google.maps.places.AutocompleteSuggestion.fetchAutocompleteSuggestions({
                    input: inputValue,
                    includedRegionCodes: ['JP'],
                    language: 'ja',
                    region: 'JP',
                    sessionToken: sessionTokenRef.current,
                });

            setSuggestions(fetchedSuggestions || []);
            setShowSuggestions(true);
            setSelectedIndex(-1);
        } catch (error) {
            console.error('Failed to fetch autocomplete suggestions:', error);
            setSuggestions([]);
        }
    }, [isReady, closeSuggestions]);

    useEffect(() => {
        if (!isManualInputRef.current) {
            isManualInputRef.current = true;
            return;
        }

        const timeoutId = setTimeout(() => fetchSuggestions(value), DEBOUNCE_DELAY);
        return () => clearTimeout(timeoutId);
    }, [value, fetchSuggestions]);

    const handleSelectSuggestion = useCallback(async (suggestion) => {
        try {
            const place = suggestion.placePrediction.toPlace();

            await place.fetchFields({
                fields: ['displayName', 'formattedAddress', 'location'],
            });

            if (!place.location) {
                console.warn('Place selected but no location available');
                return;
            }

            const placeName = place.displayName || place.formattedAddress || '';
            const lat = place.location.lat();
            const lng = place.location.lng();

            sessionTokenRef.current = new window.google.maps.places.AutocompleteSessionToken();
            isManualInputRef.current = false;
            onChange(placeName);
            closeSuggestions();

            onPlaceSelected?.(placeName, lat, lng);
        } catch (error) {
            console.error('Failed to select place:', error);
        }
    }, [onChange, onPlaceSelected, closeSuggestions]);

    const handleKeyDown = useCallback((e) => {
        if (!showSuggestions || suggestions.length === 0) return;

        const keyActions = {
            ArrowDown: () => setSelectedIndex((prev) => Math.min(prev + 1, suggestions.length - 1)),
            ArrowUp: () => setSelectedIndex((prev) => Math.max(prev - 1, -1)),
            Enter: () => selectedIndex >= 0 && handleSelectSuggestion(suggestions[selectedIndex]),
            Escape: closeSuggestions,
        };

        const action = keyActions[e.key];
        if (action) {
            e.preventDefault();
            action();
        }
    }, [showSuggestions, suggestions, selectedIndex, handleSelectSuggestion, closeSuggestions]);

    useEffect(() => {
        const handleClickOutside = (event) => {
            const isOutside = suggestionsRef.current &&
                !suggestionsRef.current.contains(event.target) &&
                !inputRef.current.contains(event.target);

            if (isOutside) closeSuggestions();
        };

        document.addEventListener('mousedown', handleClickOutside);
        return () => document.removeEventListener('mousedown', handleClickOutside);
    }, [closeSuggestions]);

    const handleFocus = useCallback(() => {
        if (value && value.length >= MIN_INPUT_LENGTH) {
            fetchSuggestions(value);
        }
    }, [value, fetchSuggestions]);

    return (
        <div className="relative">
            <input
                ref={inputRef}
                type="text"
                value={value}
                onChange={(e) => onChange(e.target.value)}
                onKeyDown={handleKeyDown}
                onFocus={handleFocus}
                placeholder={isReady ? placeholder : 'Google Mapsを読み込み中...'}
                disabled={!isReady}
                className={`w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent disabled:bg-gray-100 disabled:cursor-not-allowed ${
                    error ? 'border-red-500' : 'border-gray-300'
                } ${className}`}
                aria-required="true"
                aria-invalid={!!error}
                aria-describedby={error ? 'location-error' : undefined}
                autoComplete="off"
            />

            {/* サジェストリスト */}
            {showSuggestions && suggestions.length > 0 && (
                <div
                    ref={suggestionsRef}
                    className="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto"
                    role="listbox"
                >
                    {suggestions.map((suggestion, index) => {
                        const prediction = suggestion.placePrediction;
                        return (
                            <div
                                key={index}
                                onClick={() => handleSelectSuggestion(suggestion)}
                                className={`px-4 py-2 cursor-pointer hover:bg-gray-100 ${
                                    index === selectedIndex ? 'bg-blue-50' : ''
                                }`}
                                role="option"
                                aria-selected={index === selectedIndex}
                            >
                                <div className="text-sm font-medium text-gray-900">
                                    {prediction.text?.toString() || ''}
                                </div>
                            </div>
                        );
                    })}
                </div>
            )}

            {error && (
                <p id="location-error" className="mt-1 text-sm text-red-600" role="alert">
                    {error}
                </p>
            )}
        </div>
    );
});

PlacesAutocomplete.displayName = 'PlacesAutocomplete';

export default PlacesAutocomplete;
