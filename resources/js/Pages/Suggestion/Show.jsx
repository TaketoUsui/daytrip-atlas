import { useEffect } from 'react';
import { router } from '@inertiajs/react';
import AppLayout from '../../Components/Shared/AppLayout';
import SuggestionLoading from '../../Components/Domain/Suggestion/SuggestionLoading';
import SuggestionCard from '../../Components/Domain/Suggestion/SuggestionCard';

export default function Show({ suggestionSet }) {
    const isProcessing = [
        'pending',
        'processing_clusters',
        'listing_spots',
        'analyzing_spots',
        'generating_content',
        'evaluating_clusters',
        'analyzing_items'  // 旧形式との互換性のため残す
    ].includes(suggestionSet.status);
    const isComplete = suggestionSet.status === 'complete';
    const isFailed = suggestionSet.status === 'failed';

    // ポーリングロジック
    useEffect(() => {
        if (!isProcessing) {
            return;
        }

        // 3秒ごとにページをリロード（Inertia.js partial reload）
        const timer = setTimeout(() => {
            router.reload({
                only: ['suggestionSet'],
                preserveState: true,
                preserveScroll: true,
            });
        }, 3000);

        return () => clearTimeout(timer);
    }, [isProcessing, suggestionSet]);

    return (
        <AppLayout>
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
                {/* 処理中 */}
                {isProcessing && (
                    <SuggestionLoading
                        statusMessage={suggestionSet.status_message}
                        processingDetails={suggestionSet.processing_details}
                    />
                )}

                {/* 完了 */}
                {isComplete && (
                    <div>
                        {suggestionSet.items && suggestionSet.items.length > 0 ? (
                            <>
                                <div className="text-center mb-8 sm:mb-12">
                                    <h1 className="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-3 sm:mb-4">
                                        おすすめの日帰り旅行先
                                    </h1>
                                    <p className="text-base sm:text-lg text-gray-600 px-2">
                                        あなたにぴったりの旅行先を見つけました
                                    </p>
                                </div>

                                {/* 提案カードのグリッド */}
                                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                                    {suggestionSet.items.map((item) => (
                                        <SuggestionCard key={item.uuid} item={item} />
                                    ))}
                                </div>
                            </>
                        ) : (
                            /* 提案0件の場合 */
                            <div className="text-center py-12 sm:py-20">
                                <div className="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-yellow-100 mb-4 sm:mb-6">
                                    <svg
                                        className="w-8 h-8 sm:w-10 sm:h-10 text-yellow-600"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        aria-hidden="true"
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth={2}
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                                        />
                                    </svg>
                                </div>
                                <h2 className="text-xl sm:text-2xl font-bold text-gray-900 mb-3 sm:mb-4">
                                    おすすめの旅行先が見つかりませんでした
                                </h2>
                                <p className="text-sm sm:text-base text-gray-600 mb-6 sm:mb-8 px-4">
                                    申し訳ございません。指定された条件に合う旅行先が見つかりませんでした。<br className="hidden sm:block" />
                                    別の出発地で再度お試しください。
                                </p>
                                <a
                                    href="/"
                                    className="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors shadow-md hover:shadow-lg"
                                >
                                    <svg
                                        className="w-5 h-5 mr-2"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        aria-hidden="true"
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth={2}
                                            d="M15 19l-7-7 7-7"
                                        />
                                    </svg>
                                    別の出発地で検索する
                                </a>
                            </div>
                        )}
                    </div>
                )}

                {/* エラー */}
                {isFailed && (
                    <div className="text-center py-20">
                        <div className="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-100 mb-4">
                            <svg
                                className="w-8 h-8 text-red-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </div>
                        <h2 className="text-2xl font-bold text-gray-900 mb-2">
                            エラーが発生しました
                        </h2>
                        <p className="text-gray-600 mb-6">
                            申し訳ございません。提案の生成に失敗しました。
                        </p>
                        <a
                            href="/"
                            className="inline-block px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors"
                        >
                            トップページに戻る
                        </a>
                    </div>
                )}
            </div>
        </AppLayout>
    );
}
