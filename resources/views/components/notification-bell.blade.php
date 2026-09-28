<div 
    x-data="{open:false, bell:false}" 
    x-cloak 
    class="relative"
>

    {{-- BUTTON BELL --}}
    <button 
        @click="
            open=!open;
            bell=true;
            setTimeout(()=>bell=false,300)
        "
        class="
            relative 
            flex 
            items-center 
            justify-center
        "
    >


        <svg xmlns="http://www.w3.org/2000/svg"

            class="
                w-7
                h-7
                transition-all
                duration-300
            "

            :class="
                bell 
                ? 'text-[#6C8B6B] scale-125 rotate-12'
                : 'text-[#314233]'
            "

            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor">


            <path stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1"/>


        </svg>
        {{-- BADGE --}}

        @if(auth()->user()->unreadNotifications()->count())

        <span class="
            absolute
            -top-1
            -right-1
            bg-red-500
            text-white
            text-[11px]
            w-5
            h-5
            rounded-full
            flex
            items-center
            justify-center
        ">

            {{ auth()->user()->unreadNotifications()->count() }}

        </span>

        @endif


    </button>

    {{-- DROPDOWN --}}

    <div
        x-show="open"
        @click.outside="open=false"
        x-transition
        class="
            absolute
            right-0
            mt-4
            w-[380px]
            bg-white
            rounded-2xl
            shadow-2xl
            border
            border-gray-100
            overflow-hidden
            z-[999]
        "
    >
        {{-- HEADER --}}

        <div class="
            px-5
            py-4
            border-b
            border-gray-100
        ">


            <h3 class="
                font-bold
                text-[#314233]
            ">
                Notifikasi
            </h3>


        </div>
        {{-- LIST NOTIF --}}

        <div class="
            max-h-[390px]
            overflow-y-auto
        ">


            @forelse(
                auth()->user()
                ->notifications()
                ->latest()
                ->limit(5)
                ->get()
                as $notification
            )


            <a
                href="{{ route('notifications.read',$notification->id) }}"

                @click="
                    open=false
                "

                class="
                    block
                    px-5
                    py-4
                    border-b
                    border-gray-100
                    transition-all
                    duration-200
                    hover:bg-[#F8FAF7]
                "
            >
                <h4 class="
                    text-sm
                    font-semibold
                    text-[#314233]
                ">

                    {{ $notification->data['title'] }}

                </h4>
                <p class="
                    text-xs
                    text-gray-500
                    mt-1
                    leading-relaxed
                    line-clamp-2
                ">

                    {{ $notification->data['message'] }}

                </p>
                <p class="
                    text-[11px]
                    text-gray-400
                    mt-2
                ">

                    {{ $notification->created_at->diffForHumans() }}

                </p>
            </a>

            @empty

            <div class="
                p-6
                text-center
                text-gray-400
            ">

                Belum ada notifikasi

            </div>


            @endforelse


        </div>






        {{-- FOOTER --}}

        <a
            href="{{ route('notifications.index') }}"

            @click="open=false"

            class="
                block
                text-center
                py-4
                border-t
                border-gray-100
                font-semibold
                text-sm
                text-[#6C8B6B]
                hover:bg-[#F8FAF7]
                transition
            "
        >

            Lihat semua pemberitahuan

        </a>
    </div>
</div>