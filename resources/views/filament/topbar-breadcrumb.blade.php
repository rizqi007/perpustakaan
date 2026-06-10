@php
    $segments = request()->segments();
    // Remove 'admin' prefix
    $pageSegments = array_slice($segments, 1);

    // Map common slugs to Indonesian labels
    $labelMap = [
        'dashboard' => 'Dashboard',
        'banners' => 'Banner',
        'news' => 'Berita',
        'contact-infos' => 'Contact Infos',
        'forms' => 'Layanan',
        'surveys' => 'Survey',
        'testimonials' => 'Testimoni',
        'profil-perpustakaans' => 'Profil Perpustakaan',
        'sejarah-perpustakaans' => 'Sejarah Perpustakaan',
        'users' => 'Users',
        'website-settings' => 'Website Settings',
        'isbn-submissions' => 'Pengajuan ISBN',
        'form-submissions' => 'Form Submissions',
        'create' => 'Tambah',
        'edit' => 'Edit',
    ];

    $breadcrumbs = collect($pageSegments)
        ->filter(fn($s) => !is_numeric($s))
        ->map(fn($s) => $labelMap[$s] ?? ucfirst(str_replace('-', ' ', $s)))
        ->values();

    $currentPage = $breadcrumbs->last() ?? 'Dashboard';
@endphp

@if($breadcrumbs->isNotEmpty())
<div style="display: flex; align-items: center; gap: 0.5rem; padding: 0 0.75rem; font-size: 0.8rem; color: rgba(255,255,255,0.5);">
    <span style="color: rgba(255,255,255,0.3);">/</span>
    @foreach($breadcrumbs as $i => $crumb)
        @if($loop->last)
            <span style="color: rgb(129, 140, 248); font-weight: 600;">{{ $crumb }}</span>
        @else
            <span>{{ $crumb }}</span>
            <span style="color: rgba(255,255,255,0.3);">/</span>
        @endif
    @endforeach
</div>
@endif
