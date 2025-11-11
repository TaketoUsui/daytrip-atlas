import { Link } from '@inertiajs/react';
import Card from '../../Shared/Card';

export default function SuggestionCard({ item }) {
    return (
        <Link href={`/suggestions/detail/${item.uuid}`} className="block h-full group">
            <Card hover className="h-full flex flex-col transition-all duration-300">
                {/* キービジュアル */}
                {item.key_visual_url && (
                    <div className="aspect-[16/9] bg-gray-200 overflow-hidden relative">
                        <img
                            src={item.key_visual_url}
                            alt={item.cluster_name}
                            className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                        />
                        {/* グラデーションオーバーレイ */}
                        <div className="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                )}

                {/* カード本文 */}
                <div className="p-4 sm:p-5 flex-1 flex flex-col">
                    {/* クラスター名 */}
                    <h3 className="text-lg sm:text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors duration-200">
                        {item.cluster_name}
                    </h3>

                    {/* キャッチコピー */}
                    {item.catchphrase_content && (
                        <p className="text-sm sm:text-base text-gray-700 mb-4 line-clamp-2 flex-1">
                            {item.catchphrase_content}
                        </p>
                    )}

                    {/* 移動時間 */}
                    {item.generated_travel_time_text && (
                        <div className="flex items-center text-xs sm:text-sm text-gray-600 mt-auto">
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
                            <span>{item.generated_travel_time_text}</span>
                        </div>
                    )}
                </div>
            </Card>
        </Link>
    );
}
