import { Link } from '@inertiajs/react';
import Card from '../../Shared/Card';

export default function SuggestionCard({ item }) {
    return (
        <Link href={`/clusters/${item.cluster_uuid}`}>
            <Card hover className="h-full">
                {/* キービジュアル */}
                {item.key_visual_url && (
                    <div className="aspect-[16/9] bg-gray-200 overflow-hidden">
                        <img
                            src={item.key_visual_url}
                            alt={item.cluster_name}
                            className="w-full h-full object-cover"
                        />
                    </div>
                )}

                {/* カード本文 */}
                <div className="p-5">
                    {/* クラスター名 */}
                    <h3 className="text-xl font-bold text-gray-900 mb-2">
                        {item.cluster_name}
                    </h3>

                    {/* キャッチコピー */}
                    {item.catchphrase_content && (
                        <p className="text-gray-700 mb-4 line-clamp-2">
                            {item.catchphrase_content}
                        </p>
                    )}

                    {/* 移動時間 */}
                    {item.generated_travel_time_text && (
                        <div className="flex items-center text-sm text-gray-600">
                            <svg
                                className="w-4 h-4 mr-1"
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
                            <span>{item.generated_travel_time_text}</span>
                        </div>
                    )}
                </div>
            </Card>
        </Link>
    );
}
