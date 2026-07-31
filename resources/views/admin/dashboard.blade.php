@extends('admin.layout')

@section('title', 'Dashboard Overview')
@section('page_title', 'Ringkasan Performa Toko Roti')

@section('content')
<div class="space-y-8">

    <!-- Overview Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Total Omset -->
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Omset</span>
                <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-wallet"></i>
                </div>
            </div>
            <h3 class="font-heading text-2xl font-bold text-gray-900">Rp {{ number_format($totalOmset, 0, ',', '.') }}</h3>
            <p class="text-xs text-emerald-600 font-medium mt-1">
                <i class="fa-solid fa-arrow-trend-up mr-1"></i> Dari pesanan selesai
            </p>
        </div>

        <!-- Total Pesanan -->
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Pesanan</span>
                <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-bag-shopping"></i>
                </div>
            </div>
            <h3 class="font-heading text-2xl font-bold text-gray-900">{{ $totalOrders }} Pesanan</h3>
            <p class="text-xs text-gray-500 font-medium mt-1">
                {{ $completedOrders->count() }} selesai diproses
            </p>
        </div>

        <!-- Varian Produk -->
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Varian Roti</span>
                <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-bread-slice"></i>
                </div>
            </div>
            <h3 class="font-heading text-2xl font-bold text-gray-900">{{ $totalProducts }} Varian</h3>
            <p class="text-xs text-amber-600 font-medium mt-1">
                Aktif dalam katalog
            </p>
        </div>

        <!-- Total Stok -->
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Stok Roti</span>
                <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
            </div>
            <h3 class="font-heading text-2xl font-bold text-gray-900">{{ number_format($totalStock, 0, ',', '.') }} Pcs</h3>
            <p class="text-xs text-purple-600 font-medium mt-1">
                Tersedia di oven / toko
            </p>
        </div>

    </div>

    <!-- Recent Orders Table -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="font-heading font-bold text-lg text-gray-900">5 Pesanan Terbaru</h3>
                <p class="text-xs text-gray-500">Transaksi pesanan pelanggan terbaru yang baru masuk.</p>
            </div>
            <a href="{{ route('admin.orders') }}" class="text-xs font-bold text-brand-800 hover:text-brand-500">
                Lihat Semua <i class="fa-solid fa-arrow-right ml-1"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="py-3.5 px-6">ID Order</th>
                        <th class="py-3.5 px-6">Pelanggan</th>
                        <th class="py-3.5 px-6">No. HP</th>
                        <th class="py-3.5 px-6">Total Bayar</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($recentOrders as $order)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-6 font-bold text-brand-800">#{{ $order->id }}</td>
                        <td class="py-4 px-6 font-medium text-gray-900">{{ $order->customer_name }}</td>
                        <td class="py-4 px-6 text-gray-500">{{ $order->phone }}</td>
                        <td class="py-4 px-6 font-bold text-emerald-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="py-4 px-6">
                            @php
                                $status = strtolower($order->status);
                                $badgeClass = match($status) {
                                    'completed', 'selesai' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                                    'processing', 'diproses' => 'bg-blue-100 text-blue-800 border-blue-300',
                                    'cancelled', 'batal' => 'bg-red-100 text-red-800 border-red-300',
                                    default => 'bg-amber-100 text-amber-800 border-amber-300',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold border {{ $badgeClass }}">
                                {{ strtoupper($order->status) }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-xs text-gray-400">{{ $order->created_at ? $order->created_at->format('d M Y H:i') : '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-400 text-sm">Belum ada transaksi pesanan masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
