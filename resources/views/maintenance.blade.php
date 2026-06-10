<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance - {{ $siteName ?? 'Website' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0a0e1a;
            color: #e2e8f0;
            padding: 2rem;
            overflow: hidden;
            position: relative;
        }

        /* Animated background */
        body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(ellipse at 30% 50%, rgba(245, 158, 11, 0.08) 0%, transparent 50%),
                        radial-gradient(ellipse at 70% 50%, rgba(59, 130, 246, 0.06) 0%, transparent 50%),
                        radial-gradient(ellipse at 50% 20%, rgba(168, 85, 247, 0.05) 0%, transparent 50%);
            animation: bgShift 8s ease-in-out infinite alternate;
            z-index: 0;
        }

        @keyframes bgShift {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(-2%, 2%) rotate(1deg); }
        }

        /* Floating particles */
        .particles {
            position: absolute;
            inset: 0;
            overflow: hidden;
            z-index: 0;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: rgba(245, 158, 11, 0.3);
            animation: float linear infinite;
        }

        .particle:nth-child(1) { left: 10%; animation-duration: 12s; animation-delay: 0s; width: 3px; height: 3px; }
        .particle:nth-child(2) { left: 25%; animation-duration: 15s; animation-delay: 2s; width: 5px; height: 5px; background: rgba(59, 130, 246, 0.2); }
        .particle:nth-child(3) { left: 40%; animation-duration: 10s; animation-delay: 4s; }
        .particle:nth-child(4) { left: 55%; animation-duration: 18s; animation-delay: 1s; width: 6px; height: 6px; background: rgba(168, 85, 247, 0.2); }
        .particle:nth-child(5) { left: 70%; animation-duration: 14s; animation-delay: 3s; width: 3px; height: 3px; }
        .particle:nth-child(6) { left: 85%; animation-duration: 16s; animation-delay: 5s; background: rgba(59, 130, 246, 0.25); }
        .particle:nth-child(7) { left: 50%; animation-duration: 20s; animation-delay: 6s; width: 2px; height: 2px; }
        .particle:nth-child(8) { left: 15%; animation-duration: 13s; animation-delay: 7s; width: 4px; height: 4px; background: rgba(168, 85, 247, 0.15); }

        @keyframes float {
            0% { transform: translateY(100vh) scale(0); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100vh) scale(1); opacity: 0; }
        }

        .container {
            text-align: center;
            max-width: 480px;
            position: relative;
            z-index: 1;
        }

        /* Logo */
        .logo-wrapper {
            margin-bottom: 2rem;
            animation: fadeInDown 0.8s ease-out;
        }

        .logo-wrapper img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            filter: drop-shadow(0 0 20px rgba(245, 158, 11, 0.3));
            animation: logoFloat 3s ease-in-out infinite;
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Wrench icon */
        .icon-ring {
            width: 72px;
            height: 72px;
            margin: 0 auto 1.5rem;
            position: relative;
            animation: fadeIn 1s ease-out 0.3s both;
        }

        .icon-ring::before {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            border: 2px solid transparent;
            border-top-color: #f59e0b;
            border-right-color: rgba(245, 158, 11, 0.3);
            animation: spin 3s linear infinite;
        }

        .icon-ring::after {
            content: '';
            position: absolute;
            inset: -10px;
            border-radius: 50%;
            border: 1px solid transparent;
            border-bottom-color: rgba(59, 130, 246, 0.4);
            animation: spin 5s linear infinite reverse;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        .icon-ring .inner {
            width: 100%;
            height: 100%;
            background: rgba(245, 158, 11, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-ring svg {
            width: 32px;
            height: 32px;
            color: #f59e0b;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }

        h1 {
            font-size: 1.6rem;
            font-weight: 800;
            margin-bottom: 0.75rem;
            color: #f8fafc;
            letter-spacing: -0.025em;
            animation: fadeIn 1s ease-out 0.5s both;
        }

        .message {
            font-size: 1rem;
            line-height: 1.7;
            color: #94a3b8;
            margin-bottom: 2.5rem;
            animation: fadeIn 1s ease-out 0.7s both;
        }

        /* Progress bar */
        .progress-section {
            margin-bottom: 2rem;
            animation: fadeIn 1s ease-out 0.9s both;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.6rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .progress-label span:last-child {
            color: #f59e0b;
            font-size: 0.85rem;
        }

        .progress-track {
            width: 100%;
            height: 8px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 999px;
            overflow: hidden;
            position: relative;
        }

        .progress-fill {
            height: 100%;
            width: 75%;
            background: linear-gradient(90deg, #f59e0b, #f97316, #f59e0b);
            background-size: 200% 100%;
            border-radius: 999px;
            animation: progressGlow 2s ease-in-out infinite, progressLoad 2s ease-out forwards;
            position: relative;
        }

        .progress-fill::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 20px;
            height: 100%;
            background: rgba(255, 255, 255, 0.4);
            border-radius: 999px;
            filter: blur(4px);
            animation: progressShine 2s ease-in-out infinite;
        }

        @keyframes progressGlow {
            0%, 100% { background-position: 0% 0%; }
            50% { background-position: 100% 0%; }
        }

        @keyframes progressLoad {
            from { width: 0%; }
            to { width: 75%; }
        }

        @keyframes progressShine {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }

        /* Status dots */
        .status-items {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-bottom: 2rem;
            animation: fadeIn 1s ease-out 1.1s both;
        }

        .status-item {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.75rem;
            color: #64748b;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .status-dot.done { background: #22c55e; }
        .status-dot.active { background: #f59e0b; animation: blink 1.5s ease-in-out infinite; }
        .status-dot.pending { background: #334155; }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }

        /* Badge */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.5rem;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #94a3b8;
            animation: fadeIn 1s ease-out 1.3s both;
            backdrop-filter: blur(8px);
        }

        .badge img {
            width: 20px;
            height: 20px;
            object-fit: contain;
        }
    </style>
</head>
<body>
    <div class="particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <div class="container">
        <!-- Logo Kemenag -->
        <div class="logo-wrapper">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Kemenag">
        </div>

        <!-- Animated wrench icon -->
        <div class="icon-ring">
            <div class="inner">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085" />
                </svg>
            </div>
        </div>

        <h1>Sedang Dalam Pemeliharaan</h1>
        <p class="message">{{ $message }}</p>

        <!-- Progress Bar -->
        <div class="progress-section">
            <div class="progress-label">
                <span>Progress Perbaikan</span>
                <span>75%</span>
            </div>
            <div class="progress-track">
                <div class="progress-fill"></div>
            </div>
        </div>

        <!-- Status items -->
        <div class="status-items">
            <div class="status-item">
                <div class="status-dot done"></div>
                Backup Data
            </div>
            <div class="status-item">
                <div class="status-dot active"></div>
                Pemeliharaan
            </div>
            <div class="status-item">
                <div class="status-dot pending"></div>
                Selesai
            </div>
        </div>

        <!-- Site badge -->
        <div class="badge">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" onerror="this.style.display='none'">
            {{ $siteName ?? 'Website' }}
        </div>
    </div>
</body>
</html>
