{{-- filepath: /c:/spindo/WebPKL/resources/views/filament/modals/image-preview-with-caption.blade.php --}}
<div class="clean-preview">
    <style>
        .clean-preview {
            --primary-color: #3b82f6;
            --primary-light: #dbeafe;
            --accent-color: #8b5cf6;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --border-light: #e5e7eb;
        }

        .preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 1.5rem;
            padding: 0.5rem;
        }

        .clean-card {
            background: white;
            border-radius: 16px;
            border: 1px solid var(--border-light);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: all 0.3s ease;
            animation: cardSlide 0.5s ease-out both;
        }

        .clean-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-light);
        }

        .image-container {
            position: relative;
            overflow: hidden;
            background: #f8fafc;
        }

        .clean-image {
            width: 100%;
            height: 240px;
            object-fit: contain;
            transition: transform 0.4s ease;
            display: block;
        }

        .clean-card:hover .clean-image {
            transform: scale(1.03);
        }

        .caption-section {
            padding: 1.25rem;
            border-top: 1px solid var(--border-light);
            background: white;
        }

        .caption-header {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .caption-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 1.1rem;
            flex-shrink: 0;
            margin-top: 0.125rem;
        }

        .caption-content {
            flex: 1;
        }

        .caption-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--primary-color);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.375rem;
        }

        .caption-text {
            font-size: 0.9rem;
            color: var(--text-primary);
            line-height: 1.5;
            margin: 0;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-icon {
            font-size: 3rem;
            color: var(--primary-light);
            margin-bottom: 1rem;
            opacity: 0.7;
        }

        .empty-text {
            font-size: 1.125rem;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .empty-subtext {
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        /* Animations */
        @keyframes cardSlide {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Stagger delay */
        .clean-card:nth-child(1) { animation-delay: 0.1s; }
        .clean-card:nth-child(2) { animation-delay: 0.15s; }
        .clean-card:nth-child(3) { animation-delay: 0.2s; }
        .clean-card:nth-child(4) { animation-delay: 0.25s; }

        /* Responsive */
        @media (max-width: 768px) {
            .preview-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .clean-image {
                height: 200px;
            }

            .caption-section {
                padding: 1rem;
            }
        }
    </style>

    @if(count($images) > 0)
        <div class="preview-grid">
            @foreach($images as $index => $image)
                <div class="clean-card">
                    <div class="image-container">
                        <img src="{{ $image['url'] }}"
                             alt="{{ $image['caption'] ?? 'Laporan Packing' }}"
                             class="clean-image"
                             onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjI0MCIgdmlld0JveD0iMCAwIDQwMCAyNDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iMjQwIiBmaWxsPSIjRjhGQUZDIi8+CjxjaXJjbGUgY3g9IjIwMCIgY3k9IjEwMCIgcj0iNDAiIGZpbGw9IiNERkVCRjYiLz4KPHJlY3QgeD0iMTYwIiB5PSIxNDAiIHdpZHRoPSI4MCIgaGVpZ2h0PSI2MCIgcng9IjgiIGZpbGw9IiNERkVCRjYiLz4KPC9zdmc+'">
                    </div>

                    @if($image['caption'])
                        <div class="caption-section">
                            <div class="caption-header">
                                <div class="caption-icon">
                                    <i class="bi bi-card-text"></i>
                                </div>
                                <div class="caption-content">
                                    <div class="caption-label">Keterangan</div>
                                    <p class="caption-text">{{ $image['caption'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="bi bi-image"></i>
            </div>
            <div class="empty-text">Tidak Ada Lampiran</div>
            <div class="empty-subtext">Upload gambar untuk melihat preview di sini</div>
        </div>
    @endif
</div>