<div class="min-h-screen bg-[#F4F7F5] lg:grid lg:grid-cols-2">
    <section class="relative hidden min-h-screen overflow-hidden bg-[#0F172A] lg:flex lg:items-center lg:justify-center">
        <img
            src="{{ asset('images/login-bg.jpg') }}"
            alt="Balai KSDA Jakarta"
            class="absolute inset-0 h-full w-full object-cover opacity-35"
        >
        <div class="absolute inset-0 bg-[#0F172A]/75"></div>
        <div class="relative z-10 max-w-xl px-12 text-white">
            <div class="mb-8 flex items-center gap-4">
                <img
                    src="{{ asset('images/logos/logo-bksda.png') }}"
                    alt="Logo BKSDA Jakarta"
                    class="h-20 w-auto object-contain"
                >
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#A87B18]">Balai KSDA Jakarta</p>
                    <h1 class="mt-1 text-4xl font-bold tracking-tight">ARSIP BKSDA</h1>
                </div>
            </div>
            <p class="max-w-lg text-lg leading-8 text-white/80">
                Sistem informasi untuk pencatatan, pencarian, dan pengelolaan arsip laporan digital secara terstruktur.
            </p>
            <div class="mt-10 h-1 w-20 bg-[#A87B18]"></div>
        </div>
    </section>

    <section class="flex min-h-screen items-center justify-center bg-white px-5 py-10 sm:px-8 lg:px-16">
        <div class="w-full max-w-md">
            <div class="mb-8 flex items-center gap-3 lg:hidden">
                <img
                    src="{{ asset('images/logos/logo-bksda.png') }}"
                    alt="Logo BKSDA Jakarta"
                    class="h-14 w-auto object-contain"
                >
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#A87B18]">Balai KSDA Jakarta</p>
                    <p class="text-2xl font-bold text-[#1E293B]">ARSIP BKSDA</p>
                </div>
            </div>

            <div class="mb-8">
                <p class="mb-3 text-sm font-semibold uppercase tracking-[0.16em] text-[#008A3C]">Portal Arsip Digital</p>
                <h2 class="text-3xl font-bold tracking-tight text-[#1E293B]">Masuk ke akun Anda</h2>
                <p class="mt-3 text-sm leading-6 text-[#64748B]">Kelola arsip laporan resmi Balai KSDA Jakarta dari satu tempat.</p>
            </div>

            <form wire:submit="authenticate">
                {{ $this->form }}

                <div class="mt-6">
                    <x-filament::actions
                        :actions="$this->getLoginActions()"
                        :full-width="true"
                    />
                </div>
            </form>

            <p class="mt-8 text-center text-xs text-[#64748B]">Akses terbatas untuk pengguna terdaftar.</p>
        </div>
    </section>
</div>
