<x-filament-panels::page>
    @php
        $record = $this->record;
        $items = $this->getPackageItems();

        $mainImageUrl = null;

        if ($record->main_image) {
            $mainImageUrl = \Illuminate\Support\Str::startsWith($record->main_image, ['http://', 'https://'])
                ? $record->main_image
                : \Illuminate\Support\Facades\Storage::url($record->main_image);
        }

        $rawGalleryImages = $record->images;

        if (is_string($rawGalleryImages)) {
            $decodedGalleryImages = json_decode($rawGalleryImages, true);
            $rawGalleryImages = is_array($decodedGalleryImages) ? $decodedGalleryImages : [];
        }

        $galleryImages = collect(is_array($rawGalleryImages) ? $rawGalleryImages : [])
            ->filter()
            ->map(function ($image) {
                return \Illuminate\Support\Str::startsWith($image, ['http://', 'https://'])
                    ? $image
                    : \Illuminate\Support\Facades\Storage::url($image);
            })
            ->values();

        $statusLabel = $record->is_active ? 'Aktif' : 'Nonaktif';
        $popularLabel = $record->is_popular ? 'Ya' : 'Tidak';
        $typeLabel = $record->type === 'custom' ? 'Custom' : 'Fixed';
        $typeClass = $record->type === 'custom' ? 'didin-badge-success' : 'didin-badge-info';
    @endphp

    <style>
        .didin-package-page {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .didin-card {
            overflow: hidden;
            border: 1px solid rgba(148, 163, 184, 0.18);
            border-radius: 22px;
            background: rgba(24, 24, 27, 0.82);
            box-shadow: 0 20px 55px rgba(0, 0, 0, 0.24);
        }

        .didin-hero {
            display: grid;
            grid-template-columns: minmax(0, 1.05fr) minmax(320px, 0.95fr);
            gap: 0;
        }

        .didin-hero-content {
            padding: 30px;
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .didin-eyebrow {
            color: #60a5fa;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        .didin-title {
            margin: 0;
            color: #ffffff;
            font-size: clamp(28px, 4vw, 46px);
            line-height: 1.05;
            font-weight: 900;
            letter-spacing: -0.04em;
        }

        .didin-description {
            max-width: 760px;
            color: #cbd5e1;
            font-size: 15px;
            line-height: 1.75;
        }

        .didin-hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 4px;
        }

        .didin-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-radius: 12px;
            padding: 10px 14px;
            font-size: 13px;
            font-weight: 800;
            text-decoration: none;
            transition: 0.18s ease;
        }

        .didin-button-primary {
            color: #ffffff;
            background: #2563eb;
        }

        .didin-button-primary:hover {
            background: #1d4ed8;
        }

        .didin-button-success {
            color: #ffffff;
            background: #16a34a;
        }

        .didin-button-success:hover {
            background: #15803d;
        }

        .didin-button-muted {
            color: #e5e7eb;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        .didin-button-muted:hover {
            background: rgba(255, 255, 255, 0.13);
        }

        .didin-hero-media {
            position: relative;
            min-height: 380px;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.28), rgba(16, 185, 129, 0.14));
        }

        .didin-main-image {
            width: 100%;
            height: 100%;
            min-height: 380px;
            max-height: 460px;
            display: block;
            object-fit: cover;
        }

        .didin-image-placeholder {
            height: 100%;
            min-height: 380px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            font-weight: 800;
        }

        .didin-floating-price {
            position: absolute;
            left: 22px;
            bottom: 22px;
            padding: 14px 16px;
            border-radius: 16px;
            color: #ffffff;
            background: rgba(15, 23, 42, 0.84);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        .didin-floating-price small {
            display: block;
            color: #cbd5e1;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.09em;
        }

        .didin-floating-price strong {
            display: block;
            margin-top: 3px;
            font-size: 22px;
            font-weight: 900;
        }

        .didin-stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
        }

        .didin-stat {
            padding: 18px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.055);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .didin-stat-label {
            color: #94a3b8;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .didin-stat-value {
            margin-top: 6px;
            color: #ffffff;
            font-size: 18px;
            font-weight: 900;
        }

        .didin-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 22px 26px;
            border-bottom: 1px solid rgba(148, 163, 184, 0.18);
        }

        .didin-card-title {
            margin: 0;
            color: #ffffff;
            font-size: 18px;
            font-weight: 900;
        }

        .didin-card-subtitle {
            margin-top: 4px;
            color: #94a3b8;
            font-size: 13px;
        }

        .didin-detail-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
            padding: 24px 26px;
        }

        .didin-detail-item {
            padding: 16px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.045);
            border: 1px solid rgba(255, 255, 255, 0.075);
        }

        .didin-detail-item-full {
            grid-column: 1 / -1;
        }

        .didin-detail-label {
            margin-bottom: 7px;
            color: #94a3b8;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .didin-detail-value {
            color: #f8fafc;
            font-size: 14px;
            line-height: 1.65;
            word-break: break-word;
        }

        .didin-badge {
            display: inline-flex;
            align-items: center;
            width: fit-content;
            border-radius: 999px;
            padding: 5px 10px;
            font-size: 12px;
            font-weight: 900;
            line-height: 1;
        }

        .didin-badge-info {
            color: #93c5fd;
            background: rgba(37, 99, 235, 0.16);
            border: 1px solid rgba(59, 130, 246, 0.35);
        }

        .didin-badge-success {
            color: #86efac;
            background: rgba(22, 163, 74, 0.16);
            border: 1px solid rgba(34, 197, 94, 0.35);
        }

        .didin-badge-warning {
            color: #facc15;
            background: rgba(202, 138, 4, 0.16);
            border: 1px solid rgba(234, 179, 8, 0.35);
        }

        .didin-badge-danger {
            color: #fca5a5;
            background: rgba(220, 38, 38, 0.16);
            border: 1px solid rgba(248, 113, 113, 0.35);
        }

        .didin-color-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .didin-color-box {
            width: 30px;
            height: 30px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.18);
        }

        .didin-gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            padding: 0 26px 24px;
        }

        .didin-gallery img {
            width: 96px;
            height: 96px;
            border-radius: 16px;
            object-fit: cover;
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        .didin-items-wrap {
            padding: 0 26px 24px;
        }

        .didin-table-wrap {
            overflow: hidden;
            border-radius: 18px;
            border: 1px solid rgba(148, 163, 184, 0.16);
        }

        .didin-table-scroll {
            overflow-x: auto;
        }

        .didin-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 960px;
        }

        .didin-table thead {
            background: rgba(255, 255, 255, 0.055);
        }

        .didin-table th {
            padding: 14px 16px;
            color: #cbd5e1;
            font-size: 12px;
            font-weight: 900;
            text-align: left;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            border-bottom: 1px solid rgba(148, 163, 184, 0.16);
        }

        .didin-table td {
            padding: 15px 16px;
            color: #f8fafc;
            font-size: 14px;
            border-bottom: 1px solid rgba(148, 163, 184, 0.11);
            vertical-align: middle;
        }

        .didin-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.035);
        }

        .didin-table tbody tr:last-child td {
            border-bottom: none;
        }

        .didin-item-name {
            font-weight: 900;
            color: #ffffff;
        }

        .didin-muted {
            color: #94a3b8;
        }

        .didin-empty {
            padding: 34px 20px;
            text-align: center;
            color: #94a3b8;
            font-weight: 700;
        }

        .didin-footer-link {
            display: inline-flex;
            margin-top: 14px;
            color: #60a5fa;
            font-size: 14px;
            font-weight: 800;
            text-decoration: none;
        }

        .didin-footer-link:hover {
            color: #93c5fd;
        }

        .didin-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .didin-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            padding: 7px 10px;
            font-size: 12px;
            font-weight: 900;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: 0.15s ease;
        }

        .didin-action-view {
            color: #93c5fd;
            background: rgba(37, 99, 235, 0.16);
            border: 1px solid rgba(59, 130, 246, 0.28);
        }

        .didin-action-view:hover {
            background: rgba(37, 99, 235, 0.26);
        }

        .didin-action-edit {
            color: #facc15;
            background: rgba(202, 138, 4, 0.16);
            border: 1px solid rgba(234, 179, 8, 0.28);
        }

        .didin-action-edit:hover {
            background: rgba(202, 138, 4, 0.26);
        }

        .didin-action-delete {
            color: #fca5a5;
            background: rgba(220, 38, 38, 0.16);
            border: 1px solid rgba(248, 113, 113, 0.28);
        }

        .didin-action-delete:hover {
            background: rgba(220, 38, 38, 0.26);
        }

        @media (max-width: 1100px) {
            .didin-hero {
                grid-template-columns: 1fr;
            }

            .didin-hero-media {
                min-height: 300px;
            }

            .didin-main-image {
                min-height: 300px;
                max-height: 360px;
            }

            .didin-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 720px) {
            .didin-hero-content,
            .didin-card-header,
            .didin-detail-grid,
            .didin-items-wrap {
                padding-left: 18px;
                padding-right: 18px;
            }

            .didin-detail-grid {
                grid-template-columns: 1fr;
            }

            .didin-stats {
                grid-template-columns: 1fr;
            }

            .didin-card-header {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>

    <div class="didin-package-page">
        <section class="didin-card didin-hero">
            <div class="didin-hero-content">
                <div>
                    <div class="didin-eyebrow">Detail Paket Dekorasi</div>

                    <h1 class="didin-title">
                        {{ $record->name }}
                    </h1>
                </div>

                <div class="didin-description">
                    {{ $record->description ?: $record->short_description ?: 'Belum ada deskripsi untuk paket ini.' }}
                </div>

                <div class="didin-hero-actions">
                    <a href="{{ $this->getCreatePackageItemUrl() }}" class="didin-button didin-button-success">
                        + Tambah Item
                    </a>

                    <a href="{{ $this->getPackageItemsIndexUrl() }}" class="didin-button didin-button-primary">
                        Lihat Semua Item
                    </a>
                </div>

                <div class="didin-stats">
                    <div class="didin-stat">
                        <div class="didin-stat-label">Tipe</div>
                        <div class="didin-stat-value">{{ $typeLabel }}</div>
                    </div>

                    <div class="didin-stat">
                        <div class="didin-stat-label">Harga</div>
                        <div class="didin-stat-value">
                            Rp {{ number_format((int) $record->price, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="didin-stat">
                        <div class="didin-stat-label">Item</div>
                        <div class="didin-stat-value">
                            {{ $items->count() }} Item
                        </div>
                    </div>

                    <div class="didin-stat">
                        <div class="didin-stat-label">Status</div>
                        <div class="didin-stat-value">{{ $statusLabel }}</div>
                    </div>
                </div>
            </div>

            <div class="didin-hero-media">
                @if ($mainImageUrl)
                    <img src="{{ $mainImageUrl }}" alt="{{ $record->name }}" class="didin-main-image">
                @else
                    <div class="didin-image-placeholder">
                        Tidak ada gambar utama
                    </div>
                @endif

                <div class="didin-floating-price">
                    <small>Total Harga Paket</small>
                    <strong>Rp {{ number_format((int) $record->price, 0, ',', '.') }}</strong>
                </div>
            </div>
        </section>

        <section class="didin-card">
            <div class="didin-card-header">
                <div>
                    <h2 class="didin-card-title">Informasi Paket</h2>
                    <div class="didin-card-subtitle">
                        Ringkasan data utama paket dekorasi.
                    </div>
                </div>
            </div>

            <div class="didin-detail-grid">
                <div class="didin-detail-item">
                    <div class="didin-detail-label">Nama Paket</div>
                    <div class="didin-detail-value">{{ $record->name }}</div>
                </div>

                <div class="didin-detail-item">
                    <div class="didin-detail-label">Slug</div>
                    <div class="didin-detail-value">{{ $record->slug }}</div>
                </div>

                <div class="didin-detail-item">
                    <div class="didin-detail-label">Tipe</div>
                    <div class="didin-detail-value">
                        <span class="didin-badge {{ $typeClass }}">
                            {{ $typeLabel }}
                        </span>
                    </div>
                </div>

                <div class="didin-detail-item">
                    <div class="didin-detail-label">Harga</div>
                    <div class="didin-detail-value">
                        Rp {{ number_format((int) $record->price, 0, ',', '.') }} / {{ $record->price_unit ?: '-' }}
                    </div>
                </div>

                <div class="didin-detail-item didin-detail-item-full">
                    <div class="didin-detail-label">Deskripsi Singkat</div>
                    <div class="didin-detail-value">
                        {{ $record->short_description ?: '-' }}
                    </div>
                </div>

                <div class="didin-detail-item didin-detail-item-full">
                    <div class="didin-detail-label">Deskripsi Lengkap</div>
                    <div class="didin-detail-value">
                        {{ $record->description ?: '-' }}
                    </div>
                </div>

                <div class="didin-detail-item">
                    <div class="didin-detail-label">Badge</div>
                    <div class="didin-detail-value">
                        @if ($record->badge)
                            <span class="didin-badge didin-badge-warning">
                                {{ $record->badge }}
                            </span>
                        @else
                            <span class="didin-muted">-</span>
                        @endif
                    </div>
                </div>

                <div class="didin-detail-item">
                    <div class="didin-detail-label">Warna</div>
                    <div class="didin-detail-value">
                        @if ($record->color)
                            <div class="didin-color-row">
                                <span class="didin-color-box" style="background-color: {{ $record->color }}"></span>
                                <span>{{ $record->color }}</span>
                            </div>
                        @else
                            <span class="didin-muted">-</span>
                        @endif
                    </div>
                </div>

                <div class="didin-detail-item">
                    <div class="didin-detail-label">Popular</div>
                    <div class="didin-detail-value">
                        @if ($record->is_popular)
                            <span class="didin-badge didin-badge-success">
                                {{ $popularLabel }}
                            </span>
                        @else
                            <span class="didin-badge didin-badge-info">
                                {{ $popularLabel }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="didin-detail-item">
                    <div class="didin-detail-label">Active</div>
                    <div class="didin-detail-value">
                        @if ($record->is_active)
                            <span class="didin-badge didin-badge-success">Aktif</span>
                        @else
                            <span class="didin-badge didin-badge-danger">Nonaktif</span>
                        @endif
                    </div>
                </div>

                <div class="didin-detail-item">
                    <div class="didin-detail-label">Sort Order</div>
                    <div class="didin-detail-value">
                        {{ $record->sort_order }}
                    </div>
                </div>

                <div class="didin-detail-item">
                    <div class="didin-detail-label">Dibuat</div>
                    <div class="didin-detail-value">
                        {{ optional($record->created_at)->format('d M Y H:i') ?: '-' }}
                    </div>
                </div>
            </div>

            @if ($galleryImages->isNotEmpty())
                <div class="didin-gallery">
                    @foreach ($galleryImages as $imageUrl)
                        <img src="{{ $imageUrl }}" alt="Gallery {{ $record->name }}">
                    @endforeach
                </div>
            @endif
        </section>

        <section class="didin-card">
            <div class="didin-card-header">
                <div>
                    <h2 class="didin-card-title">Package Items</h2>
                    <div class="didin-card-subtitle">
                        Daftar item atau fasilitas yang termasuk dalam paket ini.
                    </div>
                </div>

                <a href="{{ $this->getCreatePackageItemUrl() }}" class="didin-button didin-button-success">
                    Tambah Item
                </a>
            </div>

            <div class="didin-items-wrap">
                <div class="didin-table-wrap">
                    <div class="didin-table-scroll">
                        <table class="didin-table">
                            <thead>
                                <tr>
                                    <th>Nama Item</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Description</th>
                                    <th>Sort</th>
                                    <th>Active</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($items as $item)
                                    <tr>
                                        <td>
                                            <div class="didin-item-name">
                                                {{ $item->name }}
                                            </div>
                                        </td>

                                        <td>
                                            {{ $item->quantity ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $item->unit ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $item->description ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $item->sort_order }}
                                        </td>

                                        <td>
                                            @if ($item->is_active)
                                                <span class="didin-badge didin-badge-success">Aktif</span>
                                            @else
                                                <span class="didin-badge didin-badge-danger">Nonaktif</span>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="didin-actions">
                                                <a
                                                    href="{{ $this->getPackageItemViewUrl($item->getKey()) }}"
                                                    class="didin-action didin-action-view"
                                                >
                                                    View
                                                </a>

                                                <a
                                                    href="{{ $this->getPackageItemEditUrl($item->getKey()) }}"
                                                    class="didin-action didin-action-edit"
                                                >
                                                    Edit
                                                </a>

                                                <button
                                                    type="button"
                                                    wire:click="deletePackageItem({{ $item->getKey() }})"
                                                    wire:confirm="Yakin ingin menghapus item {{ $item->name }}?"
                                                    class="didin-action didin-action-delete"
                                                >
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">
                                            <div class="didin-empty">
                                                Belum ada item untuk package ini.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <a href="{{ $this->getPackageItemsIndexUrl() }}" class="didin-footer-link">
                    Lihat semua item package ini →
                </a>
            </div>
        </section>
    </div>
</x-filament-panels::page>