import { Link, Head } from '@inertiajs/react';
import AppLayout from '../../Components/Shared/AppLayout';
import ModelPlanTimeline from '../../Components/Domain/Cluster/ModelPlanTimeline';
import { formatDuration } from '../../utils/timeFormat';

export default function Detail({ modelPlan, suggestionSetUuid, generatedTravelTimeText }) {
    // ページタイトルとOGP用の情報を準備
    const pageTitle = modelPlan.cluster_name
        ? `${modelPlan.cluster_name}の日帰り旅行|日帰り地図帳`
        : '提案内容詳細|日帰り地図帳';

    const description = modelPlan.description || modelPlan.catchphrase || '日帰り地図帳 - AI が提案する、あなただけの日帰り旅行プラン';
    const ogImage = modelPlan.key_visual_url || '/ogp-default.jpg';
    const currentUrl = typeof window !== 'undefined' ? window.location.href : '';

    return (
        <AppLayout>
            <Head>
                <title>{pageTitle}</title>
                <meta name="description" content={description} />

                {/* OGP tags */}
                <meta property="og:title" content={pageTitle} />
                <meta property="og:description" content={description} />
                <meta property="og:image" content={ogImage} />
                <meta property="og:type" content="website" />
                {currentUrl && <meta property="og:url" content={currentUrl} />}
            </Head>
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

                            {/* モデルプラン名と出発地からの移動時間 */}
                            <div className="absolute inset-0 flex flex-col justify-end p-6 sm:p-8">
                                <h1 className="text-2xl sm:text-3xl lg:text-4xl font-bold text-white drop-shadow-lg mb-3">
                                    {modelPlan.name}
                                </h1>
                                {/* 出発地からの移動時間 */}
                                {generatedTravelTimeText && (
                                    <div className="inline-flex items-center text-white bg-white/20 backdrop-blur-sm px-4 py-2 rounded-lg border border-white/30 w-fit">
                                        <svg
                                            className="w-5 h-5 mr-2 flex-shrink-0"
                                            viewBox="0 0 512 512"
                                            fill="currentColor"
                                        >
                                            <path d="M500.325,211.661l-34.024-54.143c-11.508-18.302-31.61-29.402-53.216-29.402H254.645
                                                c-26.654,0-52.195,10.719-70.849,29.745l-45.216,46.107L30.738,228.933C12.733,233.11,0,249.147,0,267.615v42.348
                                                c0,9.122,7.406,16.538,16.538,16.538h57.336c-0.074,1.141-0.185,2.274-0.185,3.425c0,29.8,24.167,53.958,53.977,53.958
                                                c29.792,0,53.958-24.158,53.958-53.958c0-1.151-0.111-2.284-0.185-3.425h169.67c-0.074,1.141-0.185,2.274-0.185,3.425
                                                c0,29.8,24.166,53.958,53.958,53.958c29.81,0,53.958-24.158,53.958-53.958c0-1.151-0.092-2.284-0.166-3.425h36.789
                                                c9.132,0,16.538-7.416,16.538-16.538v-57.81C512,237.824,507.954,223.801,500.325,211.661z M127.666,351.43
                                                c-11.879,0-21.494-9.643-21.494-21.504c0-11.871,9.615-21.495,21.494-21.495c11.86,0,21.494,9.624,21.494,21.495
                                                C149.16,341.786,139.526,351.43,127.666,351.43z M264.13,215.754h-97.188l37.198-37.93c13.216-13.476,31.628-21.198,50.505-21.198
                                                h9.486V215.754z M374.998,215.754h-85.94v-59.128h85.94V215.754z M404.882,351.43c-11.86,0-21.494-9.643-21.494-21.504
                                                c0-11.871,9.634-21.495,21.494-21.495c11.879,0,21.494,9.624,21.494,21.495C426.376,341.786,416.761,351.43,404.882,351.43z
                                                M399.944,215.754v-59.128h13.142c11.879,0,22.756,6.004,29.067,16.065l27.062,43.063H399.944z" />
                                        </svg>
                                        <span className="font-semibold text-sm sm:text-base">{generatedTravelTimeText}</span>
                                    </div>
                                )}
                            </div>
                        </div>
                    ) : (
                        <div className="p-6 sm:p-8">
                            <h1 className="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-3">
                                {modelPlan.name}
                            </h1>
                            {/* 出発地からの移動時間（画像なし） */}
                            {generatedTravelTimeText && (
                                <div className="inline-flex items-center text-gray-600 bg-gradient-to-r from-warm-100/10 to-warm-200/10 px-4 py-2 rounded-lg border-l-4 border-primary">
                                    <svg
                                        className="w-5 h-5 mr-2 text-primary flex-shrink-0"
                                        viewBox="0 0 512 512"
                                        fill="currentColor"
                                    >
                                        <path d="M500.325,211.661l-34.024-54.143c-11.508-18.302-31.61-29.402-53.216-29.402H254.645
                                            c-26.654,0-52.195,10.719-70.849,29.745l-45.216,46.107L30.738,228.933C12.733,233.11,0,249.147,0,267.615v42.348
                                            c0,9.122,7.406,16.538,16.538,16.538h57.336c-0.074,1.141-0.185,2.274-0.185,3.425c0,29.8,24.167,53.958,53.977,53.958
                                            c29.792,0,53.958-24.158,53.958-53.958c0-1.151-0.111-2.284-0.185-3.425h169.67c-0.074,1.141-0.185,2.274-0.185,3.425
                                            c0,29.8,24.166,53.958,53.958,53.958c29.81,0,53.958-24.158,53.958-53.958c0-1.151-0.092-2.284-0.166-3.425h36.789
                                            c9.132,0,16.538-7.416,16.538-16.538v-57.81C512,237.824,507.954,223.801,500.325,211.661z M127.666,351.43
                                            c-11.879,0-21.494-9.643-21.494-21.504c0-11.871,9.615-21.495,21.494-21.495c11.86,0,21.494,9.624,21.494,21.495
                                            C149.16,341.786,139.526,351.43,127.666,351.43z M264.13,215.754h-97.188l37.198-37.93c13.216-13.476,31.628-21.198,50.505-21.198
                                            h9.486V215.754z M374.998,215.754h-85.94v-59.128h85.94V215.754z M404.882,351.43c-11.86,0-21.494-9.643-21.494-21.504
                                            c0-11.871,9.634-21.495,21.494-21.495c11.879,0,21.494,9.624,21.494,21.495C426.376,341.786,416.761,351.43,404.882,351.43z
                                            M399.944,215.754v-59.128h13.142c11.879,0,22.756,6.004,29.067,16.065l27.062,43.063H399.944z" />
                                    </svg>
                                    <span className="font-semibold text-sm sm:text-base">{generatedTravelTimeText}</span>
                                </div>
                            )}
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
                        {/* タイトルと総所要時間 */}
                        <div className="mb-6">
                            <h2 className="text-xl sm:text-2xl font-bold text-gray-900 mb-2">おすすめプラン</h2>
                            <div className="flex items-center text-sm text-gray-500">
                                <svg
                                    className="w-4 h-4 mr-1.5 flex-shrink-0"
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
                                <span>総所要時間: 約{formatDuration(modelPlan.total_duration_minutes)}</span>
                            </div>
                        </div>

                        {/* タイムライン */}
                        <ModelPlanTimeline items={modelPlan.items} />
                    </div>
                )}
            </div>
        </AppLayout>
    );
}
