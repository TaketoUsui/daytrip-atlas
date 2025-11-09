import { Link } from '@inertiajs/react';
import AppLayout from '../../Components/Shared/AppLayout';
import ModelPlanTimeline from '../../Components/Domain/Cluster/ModelPlanTimeline';

export default function Detail({ cluster, modelPlan }) {
    return (
        <AppLayout>
            <div className="max-w-4xl mx-auto px-4 py-12">
                {/* 戻るリンク */}
                <Link
                    href="/"
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
                    トップページに戻る
                </Link>

                {/* クラスター情報 */}
                <div className="bg-white rounded-lg shadow-md p-8 mb-8">
                    <h1 className="text-3xl font-bold text-gray-900 mb-4">
                        {cluster.name}
                    </h1>

                    {cluster.description && (
                        <p className="text-gray-700 mb-6">
                            {cluster.description}
                        </p>
                    )}
                </div>

                {/* モデルプラン */}
                {modelPlan && (
                    <div className="bg-white rounded-lg shadow-md p-8">
                        <div className="mb-8">
                            <h2 className="text-2xl font-bold text-gray-900 mb-2">
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
