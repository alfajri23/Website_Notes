<aside id="menu-bar" class="bg-secondary text-white">
            
            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-secondary "><a class="text-decoration-none font-weight-bold text-white" href="{{ url('/dasboard') }}">Dasboard</a></li>
                <li class="list-group-item bg-secondary text-white">
                    <p class="dropdown-toggle collapsed font-weight-bold" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        Team
                    </p>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#menu-bar">
                        <a class="dropdown-item text-white" href="#">Buat Team +</a>
                        @foreach ($team as $tim)
                        <a class="dropdown-item text-white" wire:key="{{ $loop->index }}" href="{{ url('/team/'.$tim->id) }}">{{$tim->name}}</></a>
                        @endforeach
                    </div>
                <li>
            </ul>
            
</aside>