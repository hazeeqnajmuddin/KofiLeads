{{-- Shared flash-message notifications (RCMS_Architecture.md §8).
     Controllers flash via ->with('success'|'error', '...'); both layouts include this.
     Also renders validation errors when present. Vanilla JS only (no Alpine). --}}

@php
    $flashSuccess = session('success');
    $flashError = session('error');
    $flashErrors = isset($errors) ? $errors->all() : [];
@endphp

@if ($flashSuccess || $flashError || $flashErrors)
    <div id="rcms-flash" class="fixed top-5 right-5 z-[100] max-w-sm w-[calc(100%-2.5rem)] sm:w-full space-y-3">

        @if ($flashSuccess)
            <div class="rcms-flash-item flex items-start gap-3 bg-white border border-emerald-200 shadow-lg rounded-xl px-4 py-3" role="status" aria-live="polite" data-autohide="6000">
                <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.704 5.29a1 1 0 010 1.42l-7.5 7.5a1 1 0 01-1.42 0l-3.5-3.5a1 1 0 111.42-1.42l2.79 2.79 6.79-6.79a1 1 0 011.42 0z" clip-rule="evenodd"/></svg>
                <p class="text-sm text-slate-700 leading-snug flex-1">{{ $flashSuccess }}</p>
                <button type="button" onclick="this.closest('.rcms-flash-item').remove()" class="text-slate-400 hover:text-slate-600 flex-shrink-0" aria-label="Tutup">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        @if ($flashError)
            <div class="rcms-flash-item flex items-start gap-3 bg-white border border-rose-200 shadow-lg rounded-xl px-4 py-3" role="alert" aria-live="assertive">
                <svg class="w-5 h-5 text-rose-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10A8 8 0 11 2 10a8 8 0 0116 0zm-8-5a1 1 0 00-1 1v4a1 1 0 002 0V6a1 1 0 00-1-1zm0 9a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/></svg>
                <p class="text-sm text-slate-700 leading-snug flex-1">{{ $flashError }}</p>
                <button type="button" onclick="this.closest('.rcms-flash-item').remove()" class="text-slate-400 hover:text-slate-600 flex-shrink-0" aria-label="Tutup">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        @if ($flashErrors)
            <div class="rcms-flash-item bg-white border border-rose-200 shadow-lg rounded-xl px-4 py-3" role="alert" aria-live="assertive">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-rose-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10A8 8 0 11 2 10a8 8 0 0116 0zm-8-5a1 1 0 00-1 1v4a1 1 0 002 0V6a1 1 0 00-1-1zm0 9a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/></svg>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-slate-700 mb-1">Sila semak semula borang anda:</p>
                        <ul class="text-xs text-slate-600 list-disc list-inside space-y-0.5">
                            @foreach ($flashErrors as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" onclick="this.closest('.rcms-flash-item').remove()" class="text-slate-400 hover:text-slate-600 flex-shrink-0" aria-label="Tutup">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        @endif
    </div>

    <script>
        document.querySelectorAll('#rcms-flash .rcms-flash-item[data-autohide]').forEach(function (el) {
            setTimeout(function () { el.remove(); }, parseInt(el.dataset.autohide, 10));
        });
    </script>
@endif
