@if(Session::has('success'))
            <div class="bg-green-200 boorder-green-600 p-4 mb-3 rounded-sm shadow-sm">
                {{Session::get('success')}}
            </div>
            @endif

            @if(Session::has('error'))
            <div class="bg-red-200 boorder-red-600 p-4 mb-3 rounded-sm shadow-sm">
                {{Session::get('success')}}
            </div>
            @endif