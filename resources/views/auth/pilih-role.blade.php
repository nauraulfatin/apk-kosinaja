{{-- POP-UP PILIH ROLE --}}
{{-- Cara pakai: include komponen ini di layout utama, lalu trigger dengan JS --}}

{{-- OVERLAY + MODAL --}}
<div id="modal-pilih-role" class="fixed inset-0 z-[999] flex items-center justify-center p-4
            bg-black/40 backdrop-blur-sm
            opacity-0 pointer-events-none
            transition-all duration-300">

    <div id="modal-box" class="relative bg-[#FDFBF7] rounded-3xl shadow-2xl
                w-full max-w-2xl
                px-10 py-12
                scale-95 opacity-0
                transition-all duration-300">

        {{-- CLOSE BUTTON --}}
        <button onclick="tutupModal()" class="absolute top-5 right-5
                       w-9 h-9 rounded-full
                       flex items-center justify-center
                       bg-[#edf1ed] hover:bg-[#d4e0d4]
                       text-[#526453] hover:text-[#102313]
                       transition-all duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        {{-- HEADER --}}
        <div class="text-center mb-10">
            <h2 class="text-2xl font-extrabold text-[#102313] mb-2">
                Pilih peran Anda
            </h2>
            <p class="text-[#526453] text-[15px]">
                Daftarkan diri sebagai penghuni atau pemilik kos
            </p>
        </div>

        {{-- ROLE CARDS --}}
        <div class="grid grid-cols-2 gap-5 mb-10">

            {{-- PENGHUNI --}}
            <a href="{{ route('register.penghuni') }}" class="group relative flex flex-col items-center gap-5
                      p-8 rounded-2xl border-2
                      border-[#dde8dd] hover:border-[#6C8B6B]
                      bg-white hover:bg-[#f4f8f4]
                      transition-all duration-250 cursor-pointer
                      shadow-sm hover:shadow-md">

                {{-- Ilustrasi penghuni --}}
                <div class="w-28 h-28 flex items-center justify-center">
                    <svg viewBox="0 0 120 140" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        {{-- Kepala --}}
                        <ellipse cx="60" cy="28" rx="16" ry="18" fill="#C8956C" />
                        {{-- Rambut --}}
                        <ellipse cx="60" cy="16" rx="16" ry="10" fill="#4A3728" />
                        <ellipse cx="74" cy="26" rx="5" ry="14" fill="#4A3728" />
                        <rect x="55" y="36" width="18" height="10" rx="5" fill="#4A3728" />
                        {{-- Badan --}}
                        <rect x="42" y="52" width="36" height="44" rx="10" fill="#6C8B6B" />
                        {{-- Lengan kiri --}}
                        <rect x="28" y="54" width="14" height="32" rx="7" fill="#6C8B6B" />
                        <ellipse cx="35" cy="87" rx="7" ry="6" fill="#C8956C" />
                        {{-- Lengan kanan --}}
                        <rect x="78" y="54" width="14" height="32" rx="7" fill="#6C8B6B" />
                        <ellipse cx="85" cy="87" rx="7" ry="6" fill="#C8956C" />
                        {{-- Celana --}}
                        <rect x="42" y="90" width="16" height="38" rx="8" fill="#3D3D3D" />
                        <rect x="62" y="90" width="16" height="38" rx="8" fill="#3D3D3D" />
                        {{-- Sepatu --}}
                        <ellipse cx="50" cy="128" rx="10" ry="6" fill="#2C2C2C" />
                        <ellipse cx="70" cy="128" rx="10" ry="6" fill="#2C2C2C" />
                    </svg>
                </div>

                <span class="text-[16px] font-bold text-[#102313]
                             group-hover:text-[#6C8B6B] transition-colors duration-200">
                    Penghuni
                </span>

                <span class="text-[12px] text-[#526453] text-center leading-5">
                    Saya mencari kos untuk ditempati
                </span>

                {{-- Checkmark saat hover --}}
                <div class="absolute top-3 right-3 w-6 h-6 rounded-full
                            bg-[#6C8B6B] opacity-0 group-hover:opacity-100
                            flex items-center justify-center
                            transition-all duration-200 scale-75 group-hover:scale-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-white" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

            </a>

            {{-- ADMIN/OWNER --}}
            <a href="{{ route('register.admin') }}" class="group relative flex flex-col items-center gap-5
                      p-8 rounded-2xl border-2
                      border-[#dde8dd] hover:border-[#6C8B6B]
                      bg-white hover:bg-[#f4f8f4]
                      transition-all duration-250 cursor-pointer
                      shadow-sm hover:shadow-md">

                {{-- Ilustrasi admin/owner --}}
                <div class="w-28 h-28 flex items-center justify-center">
                    <svg viewBox="0 0 140 140" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        {{-- Rumah --}}
                        <polygon points="90,65 115,65 115,110 90,110" fill="#C4A882" />
                        <polygon points="88,68 78,55 117,55 107,68" fill="#A08060" />
                        <rect x="95" y="80" width="14" height="30" rx="3" fill="#7A6040" />
                        {{-- Jendela rumah --}}
                        <rect x="93" y="62" width="8" height="8" rx="2" fill="#E8D5B0" />
                        <rect x="105" y="62" width="8" height="8" rx="2" fill="#E8D5B0" />
                        {{-- Kunci --}}
                        <circle cx="72" cy="95" r="10" fill="#6C8B6B" stroke="#4A6B4A" stroke-width="2" />
                        <circle cx="72" cy="95" r="4" fill="none" stroke="#FDFBF7" stroke-width="2" />
                        <rect x="78" y="93" width="14" height="4" rx="2" fill="#6C8B6B" stroke="#4A6B4A"
                            stroke-width="1.5" />
                        <rect x="88" y="97" width="4" height="5" rx="1" fill="#6C8B6B" stroke="#4A6B4A"
                            stroke-width="1.5" />
                        {{-- Kepala --}}
                        <ellipse cx="45" cy="28" rx="15" ry="17" fill="#C8956C" />
                        {{-- Rambut / jenggot --}}
                        <ellipse cx="45" cy="16" rx="15" ry="9" fill="#4A3728" />
                        <rect x="32" y="38" width="26" height="8" rx="4" fill="#7A6050" />
                        {{-- Badan --}}
                        <rect x="28" y="52" width="34" height="44" rx="10" fill="#6C8B6B" />
                        {{-- Lengan kiri --}}
                        <rect x="14" y="54" width="14" height="30" rx="7" fill="#6C8B6B" />
                        <ellipse cx="21" cy="85" rx="7" ry="6" fill="#C8956C" />
                        {{-- Lengan kanan memegang kunci --}}
                        <rect x="62" y="54" width="14" height="42" rx="7" fill="#6C8B6B" />
                        <ellipse cx="69" cy="98" rx="7" ry="6" fill="#C8956C" />
                        {{-- Celana --}}
                        <rect x="28" y="90" width="14" height="36" rx="7" fill="#3D3D3D" />
                        <rect x="48" y="90" width="14" height="36" rx="7" fill="#3D3D3D" />
                        {{-- Sepatu --}}
                        <ellipse cx="35" cy="126" rx="10" ry="6" fill="#2C2C2C" />
                        <ellipse cx="55" cy="126" rx="10" ry="6" fill="#2C2C2C" />
                    </svg>
                </div>

                <span class="text-[16px] font-bold text-[#102313]
                             group-hover:text-[#6C8B6B] transition-colors duration-200">
                    Admin / Owner
                </span>

                <span class="text-[12px] text-[#526453] text-center leading-5">
                    Saya pemilik atau pengelola kos
                </span>

                {{-- Checkmark saat hover --}}
                <div class="absolute top-3 right-3 w-6 h-6 rounded-full
                            bg-[#6C8B6B] opacity-0 group-hover:opacity-100
                            flex items-center justify-center
                            transition-all duration-200 scale-75 group-hover:scale-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-white" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

            </a>

        </div>

        {{-- FOOTER NOTE --}}
        <p class="text-center text-[13px] text-[#7A9A7B]">
            Sudah punya akun?
            <a href="{{ route('login') }}"
                class="font-semibold text-[#6C8B6B] hover:text-[#102313] transition-colors duration-200">
                Masuk di sini
            </a>
        </p>

    </div>
</div>

{{-- SCRIPT --}}
<script>
function bukaModal() {
    const modal = document.getElementById('modal-pilih-role');
    const box = document.getElementById('modal-box');
    modal.classList.remove('opacity-0', 'pointer-events-none');
    setTimeout(() => {
        box.classList.remove('scale-95', 'opacity-0');
        box.classList.add('scale-100', 'opacity-100');
    }, 10);
    document.body.style.overflow = 'hidden';
}

function tutupModal() {
    const modal = document.getElementById('modal-pilih-role');
    const box = document.getElementById('modal-box');
    box.classList.remove('scale-100', 'opacity-100');
    box.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('opacity-0', 'pointer-events-none');
        document.body.style.overflow = '';
    }, 300);
}

// Klik luar modal = tutup
document.getElementById('modal-pilih-role').addEventListener('click', function(e) {
    if (e.target === this) tutupModal();
});

// ESC = tutup
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') tutupModal();
});
</script>