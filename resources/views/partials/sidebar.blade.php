<div class="fixed top-0 left-0 h-full w-64 bg-white dark:bg-slate-900 shadow-md z-10 transition-all duration-300 ease-in-out">
    <!-- Sidebar -->
    <aside class="w-64 min-h-screen px-6 py-10">
        <h2 class="text-xl font-semibold mb-6 text-gray-800 dark:text-gray-100 transition duration-300">Manajer Gudang</h2>
        <nav class="space-y-2">
            <a href="{{ route('manager.dashboard') }}" class="block px-4 py-2 rounded transition duration-200 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">Dashboard</a>
            <a href="{{ route('manager.categories.index') }}" class="block px-4 py-2 rounded transition duration-200 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">Kategori</a>
            <a href="{{ route('manager.products.index') }}" class="block px-4 py-2 rounded transition duration-200 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">Produk</a>
            <a href="{{ route('manager.stock.index') }}" class="block px-4 py-2 rounded transition duration-200 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">Transaksi Stok</a>
            <a href="{{ route('manager.opname.index') }}" class="block px-4 py-2 rounded transition duration-200 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">Stok Opname</a>
            <a href="{{ route('manager.suppliers.index') }}" class="block px-4 py-2 rounded transition duration-200 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">Supplier</a>
            <a href="{{ route('manager.report.stock') }}" class="block px-4 py-2 rounded transition duration-200 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">Laporan Stok</a>
        </nav>
    </aside>
</div>
