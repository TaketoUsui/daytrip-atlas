import { Link } from '@inertiajs/react';
import Card from '../../Shared/Card';

export default function SuggestionCard({ item }) {
    return (
        <Link href={`/suggestions/detail/${item.uuid}`} className="block h-full group">
            <Card hover className="h-full flex flex-col overflow-hidden transition-all duration-300 relative aspect-[3/4]">
                {/* 背景画像 */}
                {item.key_visual_url && (
                    <div className="absolute inset-0 bg-gray-200">
                        <img
                            src={item.key_visual_url}
                            alt={item.cluster_name}
                            className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                        />
                        {/* グラデーションオーバーレイ（可読性向上） */}
                        <div className="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-black/20 group-hover:from-black/80 group-hover:via-black/40 group-hover:to-black/30 transition-all duration-300"></div>
                    </div>
                )}

                {/* テキストコンテンツ（画像の上） */}
                <div className="relative z-10 h-full p-4 sm:p-5 flex flex-col justify-end text-white">
                    {/* キャッチコピー（メイン） */}
                    {item.catchphrase_content && (
                        <h3 className="text-lg sm:text-xl font-bold mb-3 line-clamp-3 leading-relaxed drop-shadow-lg">
                            {item.catchphrase_content}
                        </h3>
                    )}

                    {/* サブ情報（クラスター名と移動時間） */}
                    <div className="space-y-2">
                        {/* クラスター名（市区町村） */}
                        <p className="text-xs sm:text-sm font-medium drop-shadow-md opacity-90">
                             @ {item.cluster_name}
                        </p>

                        {/* 移動時間 */}
                        {item.generated_travel_time_text && (
                            <div className="flex items-center text-xs sm:text-sm bg-white/20 backdrop-blur-sm px-3 py-2 rounded-lg border border-white/30">
                                <svg
                                    className="w-4 h-4 mr-1.5 flex-shrink-0"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                                <span className="font-medium">{item.generated_travel_time_text}</span>
                            </div>
                        )}
                    </div>
                </div>
            </Card>
        </Link>
    );
}
