#!/bin/bash
sed -i '' '/@empty/,$d' resources/views/form-monitoring-cctv/tabs/cctv.blade.php
cat << 'INNER_EOF' >> resources/views/form-monitoring-cctv/tabs/cctv.blade.php
        @empty
        <div class="text-center text-gray-400 py-4 text-sm">Belum ada data referensi CCTV.</div>
        @endforelse
    </div>
    @if(isset($cctvs) && $cctvs->hasPages())
    <div class="mt-4 pt-4 border-t border-gray-100">
        {{ $cctvs->appends(request()->query())->links() }}
    </div>
    @endif
</div>
INNER_EOF
