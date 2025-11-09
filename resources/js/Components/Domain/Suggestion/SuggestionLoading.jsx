import LoadingSpinner from '../../Shared/LoadingSpinner';

export default function SuggestionLoading({ statusMessage }) {
    return (
        <div className="flex flex-col items-center justify-center py-12 sm:py-20 px-4">
            <div className="relative mb-6 sm:mb-8">
                <LoadingSpinner size="xl" className="text-blue-600" />
                {/* パルス効果 */}
                <div className="absolute inset-0 animate-ping opacity-20">
                    <LoadingSpinner size="xl" className="text-blue-400" />
                </div>
            </div>
            <h2 className="text-lg sm:text-xl text-gray-700 font-medium text-center mb-2">
                {statusMessage || '提案を生成しています...'}
            </h2>
            <p className="text-xs sm:text-sm text-gray-500 text-center">しばらくお待ちください</p>
        </div>
    );
}
