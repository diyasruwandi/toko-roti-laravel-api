@extends('admin.layout')

@section('title', 'Kelola Produk Roti (CRUD)')
@section('page_title', 'Manajemen Katalog & Stok Roti')

@section('content')
<div class="space-y-6">

    <!-- Header Actions & Search -->
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <form action="{{ route('admin.products') }}" method="GET" class="flex items-center gap-2 flex-1 max-w-md">
            <div class="relative w-full">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau deskripsi roti..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-gray-400 text-sm"></i>
            </div>
            <button type="submit" class="bg-brand-800 text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-brand-900 transition-colors">
                Cari
            </button>
            @if(request('search'))
            <a href="{{ route('admin.products') }}" class="text-xs text-gray-500 hover:text-gray-700 underline">Reset</a>
            @endif
        </form>

        <button onclick="openCreateModal()" class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-400 text-brand-900 font-bold px-5 py-2.5 rounded-xl transition-all shadow-md shadow-amber-500/20 text-sm">
            <i class="fa-solid fa-plus-circle text-base"></i> Tambah Roti Baru
        </button>
    </div>

    <!-- Products Table Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="py-3.5 px-6">ID</th>
                        <th class="py-3.5 px-6">Foto Roti</th>
                        <th class="py-3.5 px-6">Nama Produk</th>
                        <th class="py-3.5 px-6">Harga</th>
                        <th class="py-3.5 px-6">Status Stok</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-6 font-bold text-gray-400">#{{ $product->id }}</td>
                        <td class="py-4 px-6">
                            @if($product->image)
                                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-12 h-12 rounded-xl object-cover border border-gray-200 shadow-sm" onerror="this.onerror=null; this.src='https://placehold.co/100x100?text=Roti';">
                            @else
                                <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center font-bold text-lg">
                                    <i class="fa-solid fa-bread-slice"></i>
                                </div>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <h4 class="font-bold text-brand-800">{{ $product->name }}</h4>
                            <p class="text-xs text-gray-500 line-clamp-1 max-w-xs">{{ $product->description ?? 'Tidak ada deskripsi' }}</p>
                        </td>
                        <td class="py-4 px-6 font-bold text-emerald-700">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>
                        <td class="py-4 px-6">
                            @if($product->stock > 0)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                    Stok: {{ $product->stock }} Pcs
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-red-100 text-red-800 border border-red-300">
                                    Stok Habis
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right space-x-2">
                            <button onclick="openEditModal({{ json_encode($product) }})" class="inline-flex items-center gap-1 text-xs bg-blue-50 text-blue-700 hover:bg-blue-100 font-bold px-3 py-1.5 rounded-lg transition-colors border border-blue-200">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </button>
                            <button onclick="openDeleteModal({{ $product->id }}, '{{ addslashes($product->name) }}')" class="inline-flex items-center gap-1 text-xs bg-red-50 text-red-700 hover:bg-red-100 font-bold px-3 py-1.5 rounded-lg transition-colors border border-red-200">
                                <i class="fa-solid fa-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-gray-400">
                            <i class="fa-solid fa-bread-slice text-4xl text-gray-300 mb-2"></i>
                            <p class="text-sm">Belum ada produk roti di katalog.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Links -->
        <div class="p-4 border-t border-gray-100">
            {{ $products->links() }}
        </div>
    </div>

</div>

<!-- Modal Form Create / Edit Product -->
<div id="productModal" class="fixed inset-0 bg-brand-900/60 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden border border-gray-100 animate-scale-up">
        
        <!-- Modal Header -->
        <div class="bg-brand-800 text-white px-6 py-4 flex items-center justify-between">
            <h3 id="modalTitle" class="font-heading font-bold text-lg">Tambah Roti Baru</h3>
            <button onclick="closeProductModal()" class="text-emerald-200 hover:text-white font-bold text-xl">&times;</button>
        </div>

        <!-- Modal Form -->
        <form id="productForm" method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Roti <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="prodName" required placeholder="Contoh: Croissant Cokelat Keju" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="price" id="prodPrice" required placeholder="25000" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Stok (Pcs) <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" id="prodStock" required placeholder="10" value="10" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Deskripsi Roti</label>
                <textarea name="description" id="prodDescription" rows="2" placeholder="Roti croissant renyah dengan isian lelehan cokelat keju..." class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none"></textarea>
            </div>

            <!-- Metode Sumber Gambar Roti -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Metode Gambar Roti</label>
                <div class="grid grid-cols-2 gap-2 mb-3">
                    <label class="flex items-center justify-center gap-2 p-2.5 rounded-xl border border-gray-200 cursor-pointer hover:bg-gray-50 text-xs font-bold transition-all text-gray-700" id="labelOptionFile">
                        <input type="radio" name="image_type" value="file" id="radioFile" checked onchange="toggleImageType('file')" class="text-brand-800 focus:ring-brand-500">
                        <i class="fa-solid fa-upload text-brand-800"></i> Upload Galeri
                    </label>
                    <label class="flex items-center justify-center gap-2 p-2.5 rounded-xl border border-gray-200 cursor-pointer hover:bg-gray-50 text-xs font-bold transition-all text-gray-700" id="labelOptionUrl">
                        <input type="radio" name="image_type" value="url" id="radioUrl" onchange="toggleImageType('url')" class="text-brand-800 focus:ring-brand-500">
                        <i class="fa-solid fa-link text-brand-800"></i> Link URL Gambar
                    </label>
                </div>

                <!-- Input Upload File Galeri -->
                <div id="wrapperFile" class="space-y-1">
                    <input type="file" name="image_file" id="prodImageFile" accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-brand-800 file:text-white hover:file:bg-brand-900 border border-gray-200 rounded-xl p-1">
                    <p class="text-[10px] text-gray-400">Pilih file foto dari galeri/penyimpanan (JPG, PNG, WEBP, maks 4MB).</p>
                </div>

                <!-- Input Link URL Gambar -->
                <div id="wrapperUrl" class="hidden space-y-1">
                    <input type="url" name="image" id="prodImage" placeholder="https://images.unsplash.com/photo-..." class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    <p class="text-[10px] text-gray-400">Masukkan tautan URL publik gambar roti dari internet.</p>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100">
                <button type="button" onclick="closeProductModal()" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-100">Batal</button>
                <button type="submit" id="submitBtn" class="px-6 py-2.5 rounded-xl text-sm font-bold bg-amber-500 hover:bg-amber-400 text-brand-900 shadow-md">Simpan Produk</button>
            </div>
        </form>

    </div>
</div>

<!-- Modal Delete Confirmation -->
<div id="deleteModal" class="fixed inset-0 bg-brand-900/60 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full p-6 text-center border border-gray-100">
        <div class="w-14 h-14 bg-red-100 text-red-600 rounded-full flex items-center justify-center text-2xl mx-auto mb-4">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <h4 class="font-heading font-bold text-lg text-gray-900">Konfirmasi Hapus</h4>
        <p class="text-xs text-gray-500 mt-2">Apakah Anda yakin ingin menghapus produk <span id="delProdName" class="font-bold text-gray-800"></span> dari katalog?</p>
        
        <form id="deleteForm" method="POST" action="" class="mt-6 flex items-center justify-center gap-3">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 rounded-xl text-xs font-semibold text-gray-600 hover:bg-gray-100">Batal</button>
            <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold bg-red-600 hover:bg-red-700 text-white shadow-md">Ya, Hapus</button>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function toggleImageType(type) {
        if (type === 'file') {
            document.getElementById('wrapperFile').classList.remove('hidden');
            document.getElementById('wrapperUrl').classList.add('hidden');
            document.getElementById('radioFile').checked = true;
            document.getElementById('labelOptionFile').classList.add('border-brand-500', 'bg-brand-50');
            document.getElementById('labelOptionUrl').classList.remove('border-brand-500', 'bg-brand-50');
        } else {
            document.getElementById('wrapperUrl').classList.remove('hidden');
            document.getElementById('wrapperFile').classList.add('hidden');
            document.getElementById('radioUrl').checked = true;
            document.getElementById('labelOptionUrl').classList.add('border-brand-500', 'bg-brand-50');
            document.getElementById('labelOptionFile').classList.remove('border-brand-500', 'bg-brand-50');
        }
    }

    function openCreateModal() {
        document.getElementById('modalTitle').innerText = 'Tambah Roti Baru';
        document.getElementById('productForm').action = "{{ route('admin.products.store') }}";
        document.getElementById('formMethod').value = 'POST';
        
        document.getElementById('prodName').value = '';
        document.getElementById('prodPrice').value = '';
        document.getElementById('prodStock').value = '10';
        document.getElementById('prodDescription').value = '';
        document.getElementById('prodImage').value = '';
        document.getElementById('prodImageFile').value = '';
        
        toggleImageType('file');
        document.getElementById('productModal').classList.remove('hidden');
    }

    function openEditModal(product) {
        document.getElementById('modalTitle').innerText = 'Edit Produk Roti';
        document.getElementById('productForm').action = `/admin/products/${product.id}`;
        document.getElementById('formMethod').value = 'PUT';
        
        document.getElementById('prodName').value = product.name || '';
        document.getElementById('prodPrice').value = product.price || '';
        document.getElementById('prodStock').value = product.stock || 0;
        document.getElementById('prodDescription').value = product.description || '';
        document.getElementById('prodImage').value = product.image || '';
        document.getElementById('prodImageFile').value = '';
        
        if (product.image && product.image.startsWith('http')) {
            toggleImageType('url');
        } else {
            toggleImageType('file');
        }

        document.getElementById('productModal').classList.remove('hidden');
    }

    function closeProductModal() {
        document.getElementById('productModal').classList.add('hidden');
    }

    function openDeleteModal(id, name) {
        document.getElementById('delProdName').innerText = `"${name}"`;
        document.getElementById('deleteForm').action = `/admin/products/${id}`;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>
@endsection
