import LoadingSpinner from '../../Shared/LoadingSpinner';

export default function SuggestionLoading({ statusMessage }) {
    return (
        <div className="flex flex-col items-center justify-center py-20">
            <LoadingSpinner size="xl" className="text-blue-600 mb-6" />
            <p className="text-lg text-gray-700 font-medium">{statusMessage}</p>
            <p className="text-sm text-gray-500 mt-2">しばらくお待ちください...</p>
        </div>
    );
}
