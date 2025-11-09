import { Link } from '@inertiajs/react';

export default function AppLayout({ children }) {
    return (
        <div className="min-h-screen flex flex-col">
            {/* ヘッダー */}
            <header className="bg-white shadow-sm">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    <Link href="/" className="text-2xl font-bold text-blue-600 hover:text-blue-700 transition-colors">
                        日帰り地図帳
                    </Link>
                </div>
            </header>

            {/* メインコンテンツ */}
            <main className="flex-1">
                {children}
            </main>

            {/* フッター */}
            <footer className="bg-gray-800 text-white mt-auto">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    <p className="text-center text-sm text-gray-400">
                        &copy; {new Date().getFullYear()} 日帰り地図帳. All rights reserved.
                    </p>
                </div>
            </footer>
        </div>
    );
}
