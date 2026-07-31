@extends('admin.layout')

@section('title', 'Kelola Pesanan Pelanggan')
@section('page_title', 'Manajemen Transaksi & Pesanan')

@section('content')
<div class="space-y-6">

    <!-- Filters & Search Bar -->
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        
        <!-- Status Filter Buttons -->
        <div class="flex items-center gap-2 overflow-x-auto pb-2 md:pb-0">
            <a href="{{ route('admin.orders', ['status' => 'all', 'search' => request('search')]) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all {{ request('status', 'all') == 'all' ? 'bg-brand-800 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Semua Pesanan
            </a>
            <a href="{{ route('admin.orders', ['status' => 'pending', 'search' => request('search')]) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all {{ request('status') == 'pending' ? 'bg-amber-500 text-brand-900 shadow-md' : 'bg-amber-50 text-amber-800 hover:bg-amber-100' }}">
                Pending
            </a>
            <a href="{{ route('admin.orders', ['status' => 'completed', 'search' => request('search')]) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all {{ request('status') == 'completed' ? 'bg-emerald-600 text-white shadow-md' : 'bg-emerald-50 text-emerald-800 hover:bg-emerald-100' }}">
                Selesai
            </a>
        </div>

        <!-- Search Input -->
        <form action="{{ route('admin.orders') }}" method="GET" class="flex items-center gap-2 max-w-sm w-full">
            <input type="hidden" name="status" value="{{ request('status', 'all') }}">
            <div class="relative w-full">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pemesan / no HP..." class="w-full pl-9 pr-3 py-2 rounded-xl border border-gray-200 text-xs focus:outline-none focus:ring-2 focus:ring-brand-500">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-gray-400 text-xs"></i>
            </div>
            <button type="submit" class="bg-brand-800 text-white px-3.5 py-2 rounded-xl text-xs font-semibold hover:bg-brand-900">
                Cari
            </button>
        </form>

    </div>

    <!-- Orders Management Table -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="py-3.5 px-6">ID Order</th>
                        <th class="py-3.5 px-6">Informasi Pemesan</th>
                        <th class="py-3.5 px-6">Alamat & GPS</th>
                        <th class="py-3.5 px-6">Detail Roti Dipesan</th>
                        <th class="py-3.5 px-6">Total Bayar</th>
                        <th class="py-3.5 px-6">Ubah Status</th>
                        <th class="py-3.5 px-6">Waktu Transaksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-6 font-bold text-brand-800">#{{ $order->id }}</td>
                        <td class="py-4 px-6">
                            <h4 class="font-bold text-gray-900">{{ $order->customer_name }}</h4>
                            <p class="text-xs text-gray-500"><i class="fa-solid fa-phone text-xs mr-1"></i> {{ $order->phone }}</p>
                        </td>
                        <td class="py-4 px-6 max-w-xs">
                            <p class="text-xs text-gray-700 font-medium line-clamp-2">{{ $order->address }}</p>
                            @if($order->latitude && $order->longitude)
                            <a href="https://maps.google.com/?q={{ $order->latitude }},{{ $order->longitude }}" target="_blank" class="inline-flex items-center text-[10px] text-blue-600 hover:underline mt-1 font-bold">
                                <i class="fa-solid fa-location-dot mr-1"></i> {{ number_format($order->latitude, 4) }}, {{ number_format($order->longitude, 4) }}
                            </a>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <div class="space-y-1">
                                @foreach($order->orderItems as $item)
                                <div class="text-xs bg-cream-50 p-2 rounded-lg border border-amber-100 flex justify-between gap-3">
                                    <span class="font-medium text-brand-800">{{ $item->product ? $item->product->name : 'Roti' }}</span>
                                    <span class="font-bold text-amber-700">x{{ $item->qty }}</span>
                                </div>
                                @endforeach
                            </div>
                        </td>
                        <td class="py-4 px-6 font-bold text-emerald-700 text-base">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </td>
                        <td class="py-4 px-6">
                            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="flex items-center gap-1.5">
                                @csrf
                                @php
                                    $st = strtolower($order->status);
                                @endphp
                                <select name="status" onchange="this.form.submit()" class="text-xs font-bold rounded-lg border border-gray-200 px-2.5 py-1.5 focus:ring-2 focus:ring-brand-500 focus:outline-none shadow-sm cursor-pointer
                                    {{ in_array($st, ['completed', 'selesai']) ? 'bg-emerald-50 text-emerald-800 border-emerald-300' : '' }}
                                    {{ in_array($st, ['pending']) ? 'bg-amber-50 text-amber-800 border-amber-300' : '' }}
                                ">
                                    <option value="pending" {{ in_array($st, ['pending']) ? 'selected' : '' }}>PENDING</option>
                                    <option value="completed" {{ in_array($st, ['completed', 'selesai']) ? 'selected' : '' }}>SELESAI</option>
                                </select>
                            </form>
                        </td>
                        <td class="py-4 px-6 text-xs text-gray-400">
                            {{ $order->created_at ? $order->created_at->format('d M Y H:i') : '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-gray-400">
                            <i class="fa-solid fa-receipt text-4xl text-gray-300 mb-2"></i>
                            <p class="text-sm">Tidak ada transaksi pesanan yang sesuai dengan filter.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="p-4 border-t border-gray-100">
            {{ $orders->links() }}
        </div>
    </div>

</div>
@endsection