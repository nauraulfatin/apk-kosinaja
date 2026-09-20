@extends('layouts.public')

@section('content')

<div class="min-h-screen bg-[#F8FAF7] py-12">

    <div class="max-w-3xl mx-auto px-5">


        {{-- HEADER --}}
        <div class="mb-10">

            <h1 class="text-3xl font-bold text-[#314233]">
                Notifikasi
            </h1>


            <p class="mt-2 text-gray-500">
                Semua informasi terbaru terkait aktivitas akun KosinAja.
            </p>



            {{-- MARK ALL READ --}}

            @if(auth()->user()->unreadNotifications()->count())

            <form action="{{ route('notifications.readAll') }}"
                  method="POST"
                  class="mt-5">

                @csrf

                <button type="submit"
                        class="px-4 py-2
                               rounded-xl
                               bg-[#5F7D61]
                               text-white
                               text-sm
                               font-medium
                               hover:bg-[#314233]
                               transition">

                    Tandai semua dibaca

                </button>

            </form>

            @endif


        </div>




        {{-- LIST NOTIFICATION --}}

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">



            @forelse($notifications as $notification)



            <div class="relative flex gap-4 px-6 py-5
                        border-b border-gray-100
                        hover:bg-[#F8FAF7]
                        transition">



                {{-- UNREAD INDICATOR --}}

                @if(!$notification->read_at)

                <span class="absolute left-0 top-0 h-full w-1 bg-[#5F7D61]"></span>

                @endif





                {{-- ICON --}}

                <div class="flex-shrink-0">

                    <div class="w-11 h-11 rounded-full
                                bg-[#EEF5EC]
                                flex items-center justify-center">


                        @if(str_contains($notification->data['title'], 'Pembayaran'))


                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-5 h-5 text-[#5F7D61]"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3
                                  3 1.343 3 3-1.343 3-3 3m0-12V5m0 14v-3"/>

                        </svg>


                        @else



                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-5 h-5 text-[#5F7D61]"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159
                                  c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1"/>

                        </svg>


                        @endif


                    </div>

                </div>






                {{-- CONTENT --}}

                <div class="flex-1">


                    <div class="flex items-start justify-between gap-3">


                        <h3 class="font-semibold text-[#314233]">

                            {{ $notification->data['title'] }}

                        </h3>



                        @if(!$notification->read_at)

                        <span class="text-[11px]
                                     px-2.5 py-1
                                     rounded-full
                                     bg-[#E6F0E4]
                                     text-[#5F7D61]
                                     font-medium">

                            Baru

                        </span>

                        @endif


                    </div>





                    <p class="mt-1 text-sm text-gray-600 leading-relaxed">

                        {{ $notification->data['message'] }}

                    </p>





                    <div class="mt-3 flex items-center justify-between">


                        <span class="text-xs text-gray-400">

                            {{ $notification->created_at->diffForHumans() }}

                        </span>




                        @if(isset($notification->data['url']))

                        <a href="{{ route('notifications.read', $notification->id) }}"
                           class="text-sm font-medium
                                  text-[#5F7D61]
                                  hover:text-[#314233]">

                            Lihat →

                        </a>

                        @endif



                    </div>


                </div>



            </div>




            @empty



            <div class="py-16 text-center">


                <div class="mx-auto w-14 h-14 rounded-full
                            bg-[#EEF5EC]
                            flex items-center justify-center
                            text-2xl">

                    🔔

                </div>



                <p class="mt-4 text-gray-500">

                    Belum ada notifikasi.

                </p>


            </div>



            @endforelse



        </div>





        {{-- PAGINATION --}}

        @if($notifications->hasPages())

        <div class="mt-6">

            {{ $notifications->links() }}

        </div>

        @endif




    </div>

</div>


@endsection