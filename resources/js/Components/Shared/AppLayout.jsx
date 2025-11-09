import { Link } from '@inertiajs/react';

export default function AppLayout({ children }) {
    return (
        <div className="min-h-screen flex flex-col bg-gray-50">
            {/* ヘッダー */}
            <header className="bg-white shadow-sm" role="banner">
                <nav className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4" aria-label="メインナビゲーション">
                    <Link
                        href="/"
                        className="inline-block text-xl sm:text-2xl font-bold text-blue-600 hover:text-blue-700 transition-colors"
                        aria-label="日帰り地図帳 ホームページに戻る"
                    >
                        日帰り地図帳
                    </Link>
                </nav>
            </header>

            {/* メインコンテンツ */}
            <main className="flex-1" role="main">
                {children}
            </main>

            {/* フッター */}
            <footer className="bg-gray-800 text-white mt-auto" role="contentinfo">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    <p className="text-center text-xs sm:text-sm text-gray-400">
                        &copy; {new Date().getFullYear()} 日帰り地図帳. All rights reserved.
                    </p>
                </div>
            </footer>
        </div>
    );
}
