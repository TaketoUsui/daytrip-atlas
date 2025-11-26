import { formatDuration } from '../../../utils/timeFormat';

export default function ModelPlanTimeline({ items }) {
    const getTravelModeIcon = (travelMode) => {
        const icons = {
            walk: '🚶',
            car: '🚗',
            train: '🚃',
            bus: '🚌',
            other: '➡️',
        };
        return icons[travelMode] || icons.other;
    };

    return (
        <div className="relative">
            {items.map((item, index) => (
                <div key={index} className="relative pb-6 sm:pb-8 last:pb-0">
                    {/* 縦線（最後の要素以外に表示） */}
                    {index < items.length - 1 && (
                        <div className="absolute left-5 top-10 bottom-0 w-0.5 bg-gradient-to-b from-warm-200 to-gray-300" aria-hidden="true"></div>
                    )}

                    {/* スポット情報 */}
                    <div className="flex items-start gap-3 sm:gap-4">
                        {/* 番号アイコン */}
                        <div className="flex-shrink-0 w-10 h-10 rounded-full bg-gradient-to-br from-primary to-primary-hover text-white flex items-center justify-center font-bold text-sm shadow-md relative z-10 ring-4 ring-white">
                            {index + 1}
                        </div>

                        {/* コンテンツカード */}
                        <div className="flex-1 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 p-4 sm:p-5 border border-primary/10">
                            <h4 className="font-bold text-base sm:text-lg text-accent mb-2">
                                {item.spot_name}
                            </h4>

                            {item.spot_description && (
                                <p className="text-gray-700 text-sm sm:text-base mb-3">
                                    {item.spot_description}
                                </p>
                            )}

                            <div className="flex items-center text-xs sm:text-sm text-gray-600 bg-gradient-to-r from-warm-100/10 to-warm-200/10 px-3 py-2 rounded-lg">
                                <svg
                                    className="w-4 h-4 mr-1.5 flex-shrink-0 text-primary"
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
                                <span className="font-medium">滞在時間: {formatDuration(item.duration_minutes)}</span>
                            </div>
                        </div>
                    </div>

                    {/* 移動情報（最後のアイテム以外） */}
                    {index < items.length - 1 && item.travel_time_to_next_minutes > 0 && (
                        <div className="ml-[3.25rem] mt-3 sm:mt-4 mb-1 sm:mb-2 flex items-center gap-2 text-gray-600 relative z-10">
                            <div className="flex items-center gap-2 bg-secondary rounded-full px-3 py-1.5 border border-warm-100/50 shadow-sm">
                                <span className="text-base sm:text-lg" role="img" aria-label={`${item.travel_mode}で移動`}>
                                    {getTravelModeIcon(item.travel_mode)}
                                </span>
                                <span className="text-xs sm:text-sm font-medium">{formatDuration(item.travel_time_to_next_minutes)}</span>
                            </div>
                        </div>
                    )}
                </div>
            ))}
        </div>
    );
}
