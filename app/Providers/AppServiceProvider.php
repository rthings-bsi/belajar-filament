<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Global styles untuk elegant auth pages
        FilamentView::registerRenderHook(
            PanelsRenderHook::HEAD_START,
            fn (): string => Blade::render(<<<'BLADE'
                <style>
                    /* Elegant Background Gradient */
                    .fi-body-auth {
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
                        background-attachment: fixed !important;
                        min-height: 100vh !important;
                    }

                    /* Elegant Card Styling */
                    .fi-simple-card {
                        background: rgba(255, 255, 255, 0.95) !important;
                        backdrop-filter: blur(20px) !important;
                        border-radius: 24px !important;
                        border: 1px solid rgba(255, 255, 255, 0.2) !important;
                        box-shadow:
                            0 20px 40px rgba(0, 0, 0, 0.1),
                            0 8px 32px rgba(102, 126, 234, 0.1) !important;
                        overflow: hidden !important;
                    }

                    /* Elegant Form Elements */
                    .fi-simple-card input[type="email"],
                    .fi-simple-card input[type="password"],
                    .fi-simple-card input[type="text"] {
                        border-radius: 12px !important;
                        border: 2px solid #e2e8f0 !important;
                        padding: 0.75rem 1rem !important;
                        transition: all 0.3s ease !important;
                        background: white !important;
                    }

                    .fi-simple-card input[type="email"]:focus,
                    .fi-simple-card input[type="password"]:focus,
                    .fi-simple-card input[type="text"]:focus {
                        border-color: #667eea !important;
                        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1) !important;
                        transform: translateY(-2px) !important;
                    }

                    /* Elegant Button Styling */
                    .fi-simple-card button[type="submit"] {
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
                        border: none !important;
                        border-radius: 12px !important;
                        padding: 0.75rem 2rem !important;
                        font-weight: 600 !important;
                        transition: all 0.3s ease !important;
                        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3) !important;
                    }

                    .fi-simple-card button[type="submit"]:hover {
                        transform: translateY(-2px) !important;
                        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4) !important;
                    }

                    /* Elegant Link Styling */
                    .fi-simple-card a {
                        color: #667eea !important;
                        text-decoration: none !important;
                        font-weight: 500 !important;
                        transition: all 0.3s ease !important;
                    }

                    .fi-simple-card a:hover {
                        color: #764ba2 !important;
                        text-decoration: underline !important;
                    }

                    /* Elegant Header Styling */
                    .fi-simple-card h2 {
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
                        -webkit-background-clip: text !important;
                        -webkit-text-fill-color: transparent !important;
                        background-clip: text !important;
                        font-weight: 700 !important;
                        font-size: 1.75rem !important;
                        text-align: center !important;
                        margin-bottom: 2rem !important;
                    }

                    /* Elegant Checkbox Styling */
                    .fi-simple-card input[type="checkbox"] {
                        border-radius: 6px !important;
                        border: 2px solid #e2e8f0 !important;
                        transition: all 0.3s ease !important;
                    }

                    .fi-simple-card input[type="checkbox"]:checked {
                        background-color: #667eea !important;
                        border-color: #667eea !important;
                    }

                    /* Elegant Loading Animation */
                    .fi-simple-card button[type="submit"]:disabled {
                        opacity: 0.7 !important;
                        cursor: not-allowed !important;
                    }

                    /* Elegant Error Styling */
                    .fi-simple-card .text-danger-600 {
                        color: #e53e3e !important;
                        font-weight: 500 !important;
                    }

                    /* Elegant Success Message */
                    .fi-simple-card .bg-success-50 {
                        background: rgba(72, 187, 120, 0.1) !important;
                        border: 1px solid rgba(72, 187, 120, 0.2) !important;
                        border-radius: 12px !important;
                        padding: 1rem !important;
                    }

                    /* Elegant Logo/Header Area */
                    .fi-simple-header {
                        text-align: center !important;
                        margin-bottom: 2rem !important;
                    }

                    .fi-simple-header .fi-logo {
                        font-size: 2.5rem !important;
                        font-weight: 700 !important;
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
                        -webkit-background-clip: text !important;
                        -webkit-text-fill-color: transparent !important;
                        background-clip: text !important;
                    }

                    /* Elegant Footer */
                    .fi-simple-footer {
                        text-align: center !important;
                        margin-top: 2rem !important;
                        color: rgba(255, 255, 255, 0.8) !important;
                        font-size: 0.875rem !important;
                    }

                    /* Elegant Animation */
                    .fi-simple-card {
                        animation: cardEntrance 0.6s cubic-bezier(0.23, 1, 0.32, 1) both;
                    }

                    @keyframes cardEntrance {
                        0% {
                            opacity: 0;
                            transform: translateY(30px) scale(0.95);
                        }
                        100% {
                            opacity: 1;
                            transform: translateY(0) scale(1);
                        }
                    }

                    /* Responsive Design */
                    @media (max-width: 768px) {
                        .fi-simple-card {
                            margin: 1rem !important;
                            border-radius: 20px !important;
                        }

                        .fi-body-auth {
                            padding: 1rem !important;
                        }
                    }
                </style>
            BLADE)
        );

        // Additional elegant background pattern
        FilamentView::registerRenderHook(
            PanelsRenderHook::BODY_START,
            fn (): string => Blade::render(<<<'BLADE'
                <div style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: -1; opacity: 0.1;">
                    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0;
                                background-image: radial-gradient(circle at 25% 25%, #667eea 0%, transparent 50%),
                                                radial-gradient(circle at 75% 75%, #764ba2 0%, transparent 50%);">
                    </div>
                </div>
            BLADE)
        );
    }
}