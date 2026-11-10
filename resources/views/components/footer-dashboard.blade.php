{{-- Footer tipis untuk layout dashboard (penghuni & admin kost) --}}
<footer class="border-t border-gray-200/70 px-4 sm:px-6 lg:px-8 py-4">

    <div class="flex flex-col items-center gap-2 text-center sm:flex-row sm:justify-between sm:text-left">

        <p class="text-xs sm:text-sm text-gray-500">
            © {{ date('Y') }} KosinAja! — Orbit
        </p>

        <div class="flex items-center gap-4 text-xs sm:text-sm">

            <span class="text-gray-500">Butuh bantuan?</span>

            <a href="{{ route('hubungi') }}" class="font-semibold text-[#3A5C3A] hover:underline">
                Hubungi
            </a>

            <a href="https://wa.me/6282264676843" target="_blank" rel="noopener"
                class="font-semibold text-[#3A5C3A] hover:underline">
                WhatsApp
            </a>

        </div>

    </div>

</footer>