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
        <div className="space-y-6">
            {items.map((item, index) => (
                <div key={index} className="relative">
                    {/* スポット情報 */}
                    <div className="flex items-start">
                        {/* アイコン */}
                        <div className="flex-shrink-0 w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm z-10">
                            {index + 1}
                        </div>

                        {/* コンテンツ */}
                        <div className="ml-4 flex-1 bg-white rounded-lg shadow-md p-4">
                            <h4 className="font-bold text-lg text-gray-900 mb-2">
                                {item.spot_name}
                            </h4>

                            {item.spot_description && (
                                <p className="text-gray-700 text-sm mb-2">
                                    {item.spot_description}
                                </p>
                            )}

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
                                <span>滞在時間: {item.duration_minutes}分</span>
                            </div>
                        </div>
                    </div>

                    {/* 移動情報（最後のアイテム以外） */}
                    {index < items.length - 1 && item.travel_time_to_next_minutes > 0 && (
                        <div className="ml-5 mt-2 mb-2 flex items-center text-gray-600">
                            <div className="w-0.5 h-8 bg-gray-300 mr-4"></div>
                            <div className="flex items-center text-sm">
                                <span className="text-xl mr-2">
                                    {getTravelModeIcon(item.travel_mode)}
                                </span>
                                <span>{item.travel_time_to_next_minutes}分</span>
                            </div>
                        </div>
                    )}
                </div>
            ))}
        </div>
    );
}
