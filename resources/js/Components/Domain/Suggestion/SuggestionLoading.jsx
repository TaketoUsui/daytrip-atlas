import LoadingSpinner from '../../Shared/LoadingSpinner';

export default function SuggestionLoading({ statusMessage, processingDetails }) {
    const foundClusters = processingDetails?.found_clusters || [];

    return (
        <div className="flex flex-col items-center justify-center py-12 sm:py-20 px-4">
            {/* ローディングスピナー with 多重アニメーション */}
            <div className="relative mb-6 sm:mb-8">
                <LoadingSpinner size="xl" className="text-ocean" />
                {/* パルス効果1 */}
                <div className="absolute inset-0 animate-ping opacity-20">
                    <LoadingSpinner size="xl" className="text-sky" />
                </div>
                {/* パルス効果2（遅延） */}
                <div className="absolute inset-0 animate-pulse opacity-30" style={{ animationDelay: '0.5s' }}>
                    <LoadingSpinner size="xl" className="text-nature-light" />
                </div>
            </div>

            {/* ステータスメッセージ - フローティング効果 */}
            <div className="animate-float">
                <h2 className="text-lg sm:text-xl text-accent font-bold text-center mb-2 drop-shadow-sm">
                    {statusMessage || '提案を生成しています...'}
                </h2>
                <p className="text-xs sm:text-sm text-gray-600 text-center mb-6 font-medium">
                    あなたにぴったりの旅行先を探しています
                </p>
            </div>

            {/* 見つかった旅行先案の表示 */}
            {foundClusters.length > 0 && (
                <div className="mt-4 sm:mt-6 max-w-md w-full animate-fadeIn">
                    <div className="bg-gradient-to-br from-sky-light/20 to-nature-light/20 rounded-2xl p-4 sm:p-5 border-2 border-sky/30 shadow-lg">
                        <h3 className="text-sm font-bold text-accent mb-3 text-center">
                            候補の旅行先を見つけました
                        </h3>
                        <ul className="space-y-2">
                            {foundClusters.map((clusterName, index) => (
                                <li
                                    key={index}
                                    className="flex items-center text-sm text-gray-800 animate-slideIn"
                                    style={{ animationDelay: `${index * 0.1}s` }}
                                >
                                    <svg
                                        className="w-5 h-5 mr-2 flex-shrink-0 text-nature"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fillRule="evenodd"
                                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                            clipRule="evenodd"
                                        />
                                    </svg>
                                    <span className="font-medium">{clusterName}</span>
                                </li>
                            ))}
                        </ul>
                        <p className="text-xs text-gray-700 mt-4 text-center font-medium bg-white/50 rounded-lg py-2 px-3">
                            最適なプランを選定しています...
                        </p>
                    </div>
                </div>
            )}
        </div>
    );
}
