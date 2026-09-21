@extends('layouts.public')
@section('content')

<div class="min-h-screen bg-[#F8FAF7] py-12">
<div class="px-5">

<div class="mb-10">
<h1 class="text-3xl font-bold text-[#314233]">Notifikasi</h1>
<p class="mt-2 text-gray-500">Semua informasi terbaru terkait aktivitas akun KosinAja.</p>

@if(auth()->user()->unreadNotifications()->count() > 0)
<form action="{{ route('notifications.readAll') }}" method="POST" class="mt-5">
@csrf
<button type="submit" style="background:#5F7D61;color:white;padding:10px 18px;border-radius:12px;font-size:14px;font-weight:600;">
Tandai semua dibaca
</button>
</form>
@endif

</div>


<div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

@forelse($notifications as $notification)

<div class="relative flex gap-4 px-6 py-5 border-b border-gray-100 transition
@if(!$notification->read_at)
bg-[#E4F0E1] border-l-4 border-[#5F7D61]
@else
bg-white
@endif
hover:bg-[#F8FAF7]">


@if(!$notification->read_at)
<span class="absolute left-0 top-0 h-full w-1 bg-[#5F7D61]"></span>
@endif



<div class="flex-shrink-0">
<div class="w-11 h-11 rounded-full
@if(!$notification->read_at)
bg-[#D5E8D1]
@else
bg-gray-100
@endif
flex items-center justify-center">

@if(str_contains($notification->data['title'],'Pembayaran'))

<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#5F7D61]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3 1.343 3 3-1.343 3-3 3m0-12V5m0 14v-3"/>
</svg>

@else

<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#5F7D61]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1"/>
</svg>

@endif

</div>
</div>



<div class="flex-1">

<div class="flex items-start justify-between gap-3">

<h3 class="text-[#314233] {{ !$notification->read_at ? 'font-bold' : 'font-normal text-gray-500' }}">
{{ $notification->data['title'] }}
</h3>


@if(!$notification->read_at)

<span class="text-[11px] px-3 py-1 rounded-full bg-[#5F7D61] text-white font-semibold">
Baru
</span>

@endif

</div>



<p class="mt-1 text-sm leading-relaxed {{ !$notification->read_at ? 'text-gray-700' : 'text-gray-400' }}">
{{ $notification->data['message'] }}
</p>



<div class="mt-3 flex items-center justify-between">

<span class="text-xs {{ !$notification->read_at ? 'text-[#5F7D61] font-medium' : 'text-gray-400' }}">
{{ $notification->created_at->diffForHumans() }}
</span>


@if(isset($notification->data['url']))

<a href="{{ route('notifications.read',$notification->id) }}" class="text-sm font-medium text-[#5F7D61] hover:text-[#314233]">
Lihat →
</a>

@endif

</div>


</div>

</div>


@empty

<div class="py-16 text-center">
<div class="mx-auto w-14 h-14 rounded-full bg-[#EEF5EC] flex items-center justify-center text-2xl">
🔔
</div>
<p class="mt-4 text-gray-500">
Belum ada notifikasi.
</p>
</div>

@endforelse

</div>



@if($notifications->hasPages())
<div class="mt-6">
{{ $notifications->links() }}
</div>
@endif


</div>
</div>

@endsection