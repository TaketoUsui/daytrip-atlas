import { Link } from '@inertiajs/react';
import AppLayout from '../../Components/Shared/AppLayout';
import ModelPlanTimeline from '../../Components/Domain/Cluster/ModelPlanTimeline';

export default function Detail({ suggestionSetItem, modelPlan }) {
    return (
        <AppLayout>
            <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
                {/* 戻るリンク */}
                <Link
                    href={`/suggestions/${suggestionSetItem.suggestion_set_uuid}`}
                    className="inline-flex items-center text-blue-600 hover:text-blue-700 mb-6"
                >
                    <svg
                        className="w-5 h-5 mr-1"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            strokeLinecap="round"
                            strokeLinejoin="round"
                            strokeWidth={2}
                            d="M15 19l-7-7 7-7"
                        />
                    </svg>
                    提案一覧に戻る
                </Link>

                {/* 提案情報 */}
                <div className="bg-white rounded-lg shadow-md overflow-hidden mb-6 sm:mb-8">
                    {/* キービジュアル */}
                    {suggestionSetItem.key_visual_url && (
                        <div className="w-full h-48 sm:h-64 md:h-80 overflow-hidden">
                            <img
                                src={suggestionSetItem.key_visual_url}
                                alt={suggestionSetItem.cluster_name}
                                className="w-full h-full object-cover"
                            />
                        </div>
                    )}

                    <div className="p-6 sm:p-8">
                        <h1 className="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-3 sm:mb-4">
                            {suggestionSetItem.cluster_name}
                        </h1>

                        {/* キャッチコピー */}
                        {suggestionSetItem.catchphrase && (
                            <p className="text-gray-700 text-base sm:text-lg font-medium mb-4 leading-relaxed italic">
                                {suggestionSetItem.catchphrase}
                            </p>
                        )}

                        {/* 移動時間 */}
                        {suggestionSetItem.generated_travel_time_text && (
                            <div className="flex items-center text-gray-600 text-sm sm:text-base">
                                <svg
                                    className="w-5 h-5 mr-2 flex-shrink-0"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                                <span>{suggestionSetItem.generated_travel_time_text}</span>
                            </div>
                        )}
                    </div>
                </div>

                {/* モデルプラン */}
                {modelPlan && (
                    <div className="bg-white rounded-lg shadow-md p-6 sm:p-8">
                        <div className="mb-6 sm:mb-8">
                            <h2 className="text-xl sm:text-2xl font-bold text-gray-900 mb-2">
                                {modelPlan.name}
                            </h2>

                            {modelPlan.description && (
                                <p className="text-gray-700 mb-4">
                                    {modelPlan.description}
                                </p>
                            )}

                            <div className="flex items-center text-gray-600">
                                <svg
                                    className="w-5 h-5 mr-2"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                                <span>総所要時間: 約{modelPlan.total_duration_minutes}分</span>
                            </div>
                        </div>

                        {/* タイムライン */}
                        {modelPlan.items && modelPlan.items.length > 0 && (
                            <ModelPlanTimeline items={modelPlan.items} />
                        )}
                    </div>
                )}
            </div>
        </AppLayout>
    );
}
