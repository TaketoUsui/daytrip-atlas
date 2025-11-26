/**
 * 分数を「〇時間〇分」形式にフォーマットする
 * @param {number} minutes - 分数
 * @returns {string} フォーマットされた時間文字列
 */
export function formatDuration(minutes) {
    if (minutes == null || minutes < 0) {
        return '0分';
    }

    const hours = Math.floor(minutes / 60);
    const remainingMinutes = minutes % 60;

    if (hours === 0) {
        return `${remainingMinutes}分`;
    }

    if (remainingMinutes === 0) {
        return `${hours}時間`;
    }

    return `${hours}時間${remainingMinutes}分`;
}
