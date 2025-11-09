import { useEffect } from 'react';
import { router } from '@inertiajs/react';
import AppLayout from '../../Components/Shared/AppLayout';
import SuggestionLoading from '../../Components/Domain/Suggestion/SuggestionLoading';
import SuggestionCard from '../../Components/Domain/Suggestion/SuggestionCard';

export default function Show({ suggestionSet }) {
    const isProcessing = ['pending', 'processing_clusters', 'analyzing_items'].includes(suggestionSet.status);
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

    console.log(suggestionSet);
    console.log(suggestionSet.status);
    console.log(isProcessing);
    console.log(isComplete);
    console.log(isFailed);

    return (
        <AppLayout>
            <div className="max-w-7xl mx-auto px-4 py-12">
                {/* 処理中 */}
                {isProcessing && (
                    <SuggestionLoading statusMessage={suggestionSet.status_message} />
                )}

                {/* 完了 */}
                {isComplete && (
                    <div>
                        <div className="text-center mb-12">
                            <h1 className="text-3xl font-bold text-gray-900 mb-4">
                                おすすめの日帰り旅行先
                            </h1>
                            <p className="text-lg text-gray-600">
                                あなたにぴったりの旅行先を見つけました
                            </p>
                        </div>

                        {/* 提案カードのグリッド */}
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            {suggestionSet.items && suggestionSet.items.map((item) => (
                                <SuggestionCard key={item.uuid} item={item} />
                            ))}
                        </div>
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
