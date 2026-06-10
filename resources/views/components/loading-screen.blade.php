<div id="loading-screen" style="position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;flex-direction:column;background:#064e3b;transition:opacity 0.5s ease,visibility 0.5s ease;">
    <style>
        @keyframes loaderPulse { 0%,100%{transform:scale(1);opacity:1} 50%{transform:scale(1.08);opacity:0.8} }
        @keyframes loaderSpin { to{transform:rotate(360deg)} }
        @keyframes loaderFadeUp { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:translateY(0)} }
        @keyframes loaderProgress { from{width:0} to{width:100%} }
        #loading-screen .loader-logo { animation: loaderPulse 2s ease-in-out infinite; }
        #loading-screen .loader-ring { animation: loaderSpin 1.5s linear infinite; }
        #loading-screen .loader-text { animation: loaderFadeUp 0.6s ease-out 0.3s both; }
        #loading-screen .loader-bar-fill { animation: loaderProgress 1.8s ease-in-out infinite; }
    </style>
    <div style="position:relative;width:100px;height:100px;margin-bottom:2rem;">
        <!-- Spinner ring -->
        <div class="loader-ring" style="position:absolute;inset:-8px;border-radius:50%;border:3px solid transparent;border-top-color:#34d399;border-right-color:rgba(52,211,153,0.3);"></div>
        <!-- Logo -->
        <div class="loader-logo" style="width:100px;height:100px;border-radius:50%;background:rgba(255,255,255,0.1);backdrop-filter:blur(8px);display:flex;align-items:center;justify-content:center;border:2px solid rgba(255,255,255,0.15);">
             @if(isset($site_logo) && $site_logo)
                <img src="{{ asset('storage/' . $site_logo) }}" alt="Logo" style="width:56px;height:56px;object-fit:contain;filter:drop-shadow(0 0 16px rgba(52,211,153,0.5));">
            @else
                <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width:56px;height:56px;object-fit:contain;filter:drop-shadow(0 0 16px rgba(52,211,153,0.5));">
            @endif
        </div>
    </div>
    <div class="loader-text" style="text-align:center;">
        <div style="font-size:1.1rem;font-weight:800;color:#ecfdf5;letter-spacing:0.05em;text-transform:uppercase;margin-bottom:0.5rem;">{{ $site_name ?? 'Perpustakaan' }}</div>
        <div style="font-size:0.7rem;font-weight:500;color:rgba(167,243,208,0.7);letter-spacing:0.15em;">KEMENTERIAN AGAMA RI</div>
    </div>
    <!-- Progress bar -->
    <div style="margin-top:2rem;width:160px;height:3px;background:rgba(255,255,255,0.1);border-radius:99px;overflow:hidden;">
        <div class="loader-bar-fill" style="height:100%;background:linear-gradient(90deg,#34d399,#10b981,#34d399);border-radius:99px;"></div>
    </div>
</div>
<script>
    (function() {
        function hideLoader() {
            var ls = document.getElementById('loading-screen');
            if (ls) { ls.style.opacity='0'; ls.style.visibility='hidden'; setTimeout(function(){ ls.remove(); }, 500); }
        }
        // Hide on DOMContentLoaded (faster than window.load)
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() { setTimeout(hideLoader, 200); });
        } else {
            setTimeout(hideLoader, 200);
        }
        // Fallback: force hide after 2 seconds max
        setTimeout(hideLoader, 2000);
    })();
</script>
