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

                {/* キービジュアル */}
                <div className="bg-white rounded-2xl shadow-xl overflow-hidden mb-6 sm:mb-8 border-2 border-primary/10">
                    {modelPlan.key_visual_url ? (
                        <div className="relative w-full h-64 sm:h-80 md:h-96 overflow-hidden">
                            {/* 背景画像 */}
                            <img
                                src={modelPlan.key_visual_url}
                                alt={modelPlan.name}
                                className="w-full h-full object-cover"
                            />

                            {/* グラデーションオーバーレイ */}
                            <div className="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>

                            {/* モデルプラン名と総所要時間 */}
                            <div className="absolute inset-0 flex flex-col justify-end p-6 sm:p-8">
                                <h1 className="text-2xl sm:text-3xl lg:text-4xl font-bold text-white drop-shadow-lg mb-3">
                                    {modelPlan.name}
                                </h1>
                                {/* 総所要時間 */}
                                <div className="inline-flex items-center text-white bg-white/20 backdrop-blur-sm px-4 py-2 rounded-lg border border-white/30 w-fit">
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
                                    <span className="font-semibold text-sm sm:text-base">総所要時間: 約{formatDuration(modelPlan.total_duration_minutes)}</span>
                                </div>
                            </div>
                        </div>
                    ) : (
                        <div className="p-6 sm:p-8">
                            <h1 className="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-3">
                                {modelPlan.name}
                            </h1>
                            {/* 総所要時間（画像なし） */}
                            <div className="inline-flex items-center text-gray-600 bg-gradient-to-r from-warm-100/10 to-warm-200/10 px-4 py-2 rounded-lg border-l-4 border-primary">
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
                                <span className="font-semibold text-sm sm:text-base">総所要時間: 約{formatDuration(modelPlan.total_duration_minutes)}</span>
                            </div>
                        </div>
                    )}
                </div>

                {/* メタデータカード */}
                {(modelPlan.cluster_name || modelPlan.catchphrase || modelPlan.description) && (
                    <div className="bg-white rounded-2xl shadow-xl p-6 sm:p-8 border-2 border-primary/10 mb-6 sm:mb-8">
                        <div className="space-y-4">
                            {/* クラスター名 */}
                            {modelPlan.cluster_name && (
                                <div className="flex items-start">
                                    <svg
                                        className="w-5 h-5 mr-3 mt-0.5 text-ocean flex-shrink-0"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth={2}
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                        />
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth={2}
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                        />
                                    </svg>
                                    <div>
                                        <p className="text-xs text-gray-500 mb-1">エリア</p>
                                        <p className="text-sm sm:text-base text-gray-800 font-medium">{modelPlan.cluster_name}</p>
                                    </div>
                                </div>
                            )}

                            {/* キャッチコピー */}
                            {modelPlan.catchphrase && (
                                <div className="flex items-start">
                                    <svg
                                        className="w-5 h-5 mr-3 mt-0.5 text-ocean flex-shrink-0"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth={2}
                                            d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"
                                        />
                                    </svg>
                                    <div>
                                        <p className="text-xs text-gray-500 mb-1">キャッチコピー</p>
                                        <p className="text-sm sm:text-base text-gray-800 italic leading-relaxed">{modelPlan.catchphrase}</p>
                                    </div>
                                </div>
                            )}

                            {/* モデルプラン説明 */}
                            {modelPlan.description && (
                                <div className="flex items-start">
                                    <svg
                                        className="w-5 h-5 mr-3 mt-0.5 text-ocean flex-shrink-0"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth={2}
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                        />
                                    </svg>
                                    <div>
                                        <p className="text-xs text-gray-500 mb-1">プランについて</p>
                                        <p className="text-sm sm:text-base text-gray-800 leading-relaxed">{modelPlan.description}</p>
                                    </div>
                                </div>
                            )}
                        </div>
                    </div>
                )}

                {/* モデルプラン */}
                {modelPlan && modelPlan.items && modelPlan.items.length > 0 && (
                    <div className="bg-white rounded-2xl shadow-xl p-6 sm:p-8 border-2 border-primary/10">
                        <ModelPlanTimeline items={modelPlan.items} />
                    </div>
                )}
            </div>
        </AppLayout>
    );
}
