<div class="w-[calc(100vw-13rem)] h-16 bg-flash-white mx-2 my-2 px-5 rounded-lg">
    <div class="flex items-center justify-between h-full w-full">
        <div>
            {{$header}}
        </div>

        <div class="flex items-center gap-2">
            <p class="text-lg text-indigo"> 
                {{ auth()->user()->name }}
            </p>
            <a href="/profile">
                <img class="w-8" src="{{ asset('img/settings-icon.svg') }}" alt="">
            </a>
        </div>
    </div>

    

</div>