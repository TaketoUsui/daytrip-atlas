import { Link } from '@inertiajs/react';
import AppLayout from '../../Components/Shared/AppLayout';
import ModelPlanTimeline from '../../Components/Domain/Cluster/ModelPlanTimeline';
import { formatDuration } from '../../utils/timeFormat';

export default function Detail({ modelPlan, suggestionSetUuid }) {
    return (
        <AppLayout>
            <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
                {/* 戻るリンク */}
                {suggestionSetUuid && (
                    <Link
                        href={`/suggestions/${suggestionSetUuid}`}
                        className="inline-flex items-center text-ocean hover:text-sky mb-6 font-medium transition-all duration-200 transform hover:scale-105"
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
                )}

                {/* 提案情報 */}
                <div className="bg-white rounded-2xl shadow-xl overflow-hidden mb-6 sm:mb-8 border-2 border-primary/10">
                    {/* キービジュアル with オーバーレイ */}
                    {modelPlan.key_visual_url ? (
                        <div className="relative w-full h-64 sm:h-80 md:h-96 overflow-hidden">
                            {/* 背景画像 */}
                            <img
                                src={modelPlan.key_visual_url}
                                alt={modelPlan.cluster_name}
                                className="w-full h-full object-cover"
                            />

                            {/* グラデーションオーバーレイ */}
                            <div className="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>

                            {/* テキストオーバーレイ */}
                            <div className="absolute inset-0 flex flex-col justify-end p-6 sm:p-8">
                                <h1 className="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-3 sm:mb-4 drop-shadow-lg">
                                    {modelPlan.cluster_name}
                                </h1>

                                {/* キャッチコピー */}
                                {modelPlan.catchphrase && (
                                    <p className="text-white text-base sm:text-lg font-medium mb-4 leading-relaxed italic drop-shadow-md">
                                        {modelPlan.catchphrase}
                                    </p>
                                )}
                            </div>
                        </div>
                    ) : (
                        <div className="p-6 sm:p-8">
                            <h1 className="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-3 sm:mb-4">
                                {modelPlan.cluster_name}
                            </h1>

                            {/* キャッチコピー */}
                            {modelPlan.catchphrase && (
                                <p className="text-gray-700 text-base sm:text-lg font-medium mb-4 leading-relaxed italic">
                                    {modelPlan.catchphrase}
                                </p>
                            )}
                        </div>
                    )}
                </div>

                {/* モデルプラン */}
                {modelPlan && (
                    <div className="bg-white rounded-2xl shadow-xl p-6 sm:p-8 border-2 border-primary/10">
                        <div className="mb-6 sm:mb-8">
                            <h2 className="text-xl sm:text-2xl font-bold text-accent mb-2">
                                {modelPlan.name}
                            </h2>

                            {modelPlan.description && (
                                <p className="text-gray-700 mb-4 leading-relaxed">
                                    {modelPlan.description}
                                </p>
                            )}

                            <div className="flex items-center text-gray-600 bg-gradient-to-r from-warm-100/10 to-warm-200/10 px-4 py-2 rounded-lg border-l-4 border-primary">
                                <svg
                                    className="w-5 h-5 mr-2 text-primary"
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
                                <span className="font-semibold">総所要時間: 約{formatDuration(modelPlan.total_duration_minutes)}</span>
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
