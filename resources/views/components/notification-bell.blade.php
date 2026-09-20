@auth

<a href="{{ route('notifications.index') }}"
   class="relative flex items-center justify-center w-10 h-10 rounded-full hover:bg-[#F1F5EF] transition">

    <svg xmlns="http://www.w3.org/2000/svg"
         class="w-6 h-6 text-[#314233]"
         fill="none"
         viewBox="0 0 24 24"
         stroke="currentColor">

        <path stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
    </svg>


  @if(auth()->user()->unreadNotifications()->count())

<span class="absolute -top-1 -right-1
             bg-red-500 text-white
             text-xs font-bold
             w-5 h-5
             rounded-full
             flex items-center justify-center">

    {{ auth()->user()->unreadNotifications()->count() }}

</span>

@endif

</a>

@endauth