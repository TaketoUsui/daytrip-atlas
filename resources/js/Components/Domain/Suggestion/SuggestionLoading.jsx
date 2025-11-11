import LoadingSpinner from '../../Shared/LoadingSpinner';

export default function SuggestionLoading({ statusMessage, processingDetails }) {
    const foundClusters = processingDetails?.found_clusters || [];

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
            <p className="text-xs sm:text-sm text-gray-500 text-center mb-6">しばらくお待ちください</p>

            {/* 見つかった旅行先案の表示 */}
            {foundClusters.length > 0 && (
                <div className="mt-4 sm:mt-6 max-w-md w-full">
                    <div className="bg-blue-50 rounded-lg p-4 sm:p-5 border border-blue-100">
                        <h3 className="text-sm font-semibold text-blue-900 mb-3 text-center">
                            候補の旅行先を見つけました
                        </h3>
                        <ul className="space-y-2">
                            {foundClusters.map((clusterName, index) => (
                                <li
                                    key={index}
                                    className="flex items-center text-sm text-blue-800"
                                >
                                    <svg
                                        className="w-4 h-4 mr-2 flex-shrink-0 text-blue-600"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fillRule="evenodd"
                                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                            clipRule="evenodd"
                                        />
                                    </svg>
                                    <span>{clusterName}</span>
                                </li>
                            ))}
                        </ul>
                        <p className="text-xs text-blue-700 mt-3 text-center">
                            最適なプランを選定しています...
                        </p>
                    </div>
                </div>
            )}
        </div>
    );
}
