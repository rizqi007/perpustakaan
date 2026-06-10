<div>
    <style>
        .captcha-input {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            border: 1px solid #d1d5db !important;
            background-color: #ffffff !important;
            color: #111827 !important;
        }
        .captcha-input::placeholder {
            color: #9ca3af !important;
        }
        .captcha-input:focus {
            border-color: #f59e0b !important;
            box-shadow: 0 0 0 1px #f59e0b;
        }

        /* Dark mode overrides */
        .dark .captcha-input {
            border-color: rgba(255, 255, 255, 0.2) !important;
            background-color: rgba(255, 255, 255, 0.05) !important;
            color: #ffffff !important;
        }
        .dark .captcha-input::placeholder {
            color: #9ca3af !important;
        }
        .dark .captcha-input:focus {
            border-color: #fbbf24 !important;
            box-shadow: 0 0 0 1px #fbbf24;
        }

        .captcha-refresh-btn {
            background: transparent;
            border: 1px solid rgba(251, 191, 36, 0.4);
            border-radius: 0.375rem;
            padding: 0.5rem;
            cursor: pointer;
            color: #f59e0b;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        .captcha-refresh-btn:hover {
            background: rgba(251, 191, 36, 0.1);
        }
    </style>

    <div style="margin-bottom: 0.5rem;">
        <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3" style="font-size: 0.875rem; font-weight: 500; color: var(--fi-fo-field-wrp-label-color);">
            Captcha
        </label>
    </div>

    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
        {{-- Captcha display --}}
        <div style="
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            padding: 0.625rem 1.25rem;
            border-radius: 0.5rem;
            font-family: 'Courier New', monospace;
            font-size: 1.75rem;
            font-weight: bold;
            letter-spacing: 0.75rem;
            color: #fbbf24;
            user-select: none;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
            border: 1px solid rgba(251, 191, 36, 0.3);
            position: relative;
            overflow: hidden;
            min-width: 120px;
            text-align: center;
        ">
            {{-- Decorative lines for anti-bot visual --}}
            <div style="position: absolute; top: 40%; left: 0; right: 0; height: 1px; background: rgba(251, 191, 36, 0.2); transform: rotate(-5deg);"></div>
            <div style="position: absolute; top: 60%; left: 0; right: 0; height: 1px; background: rgba(251, 191, 36, 0.15); transform: rotate(3deg);"></div>
            {{ session('login_captcha', '000') }}
        </div>

        {{-- Refresh button --}}
        <button
            type="button"
            wire:click="refreshCaptcha"
            class="captcha-refresh-btn"
            title="Refresh Captcha"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 1.25rem; height: 1.25rem;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182M2.985 19.644l3.181-3.183" />
            </svg>
        </button>
    </div>

    {{-- Captcha input --}}
    <input
        type="text"
        wire:model="data.captcha"
        class="captcha-input"
        maxlength="3"
        inputmode="numeric"
        pattern="[0-9]*"
        placeholder="Masukkan 3 angka di atas"
        required
    />

    @error('data.captcha')
        <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
    @enderror
</div>
