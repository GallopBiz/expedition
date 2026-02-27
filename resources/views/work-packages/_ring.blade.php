{{-- resources/views/work-packages/_ring.blade.php --}}
@php
    $r     = 14;
    $cx    = 19;
    $circ  = 2 * M_PI * $r;
    $dash  = ($pct / 100) * $circ;
    $color = $pct >= 70 ? '#12b981' : ($pct >= 30 ? '#4f7cff' : '#b0b6cc');
@endphp
<div class="ring">
    <svg width="38" height="38" viewBox="0 0 38 38">
        <circle class="ring-bg"
                cx="{{ $cx }}" cy="{{ $cx }}" r="{{ $r }}"/>
        <circle class="ring-fill"
                cx="{{ $cx }}" cy="{{ $cx }}" r="{{ $r }}"
                stroke="{{ $color }}"
                stroke-dasharray="{{ number_format($dash, 2) }} {{ number_format($circ, 2) }}"
                stroke-dashoffset="0"/>
    </svg>
    <div class="ring-label">{{ $pct }}%</div>
</div>
