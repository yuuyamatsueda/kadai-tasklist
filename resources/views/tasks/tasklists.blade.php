@if (count($tasklists) > 0)
    <ul class="list-unstyled">
        @foreach ($tasklists as $tasklist)
            <li class="media mb-3">
               
                <div class="media-body">
                   
                    <div>
                        {{-- 投稿内容 --}}
                        <p class="mb-0">{!! nl2br(e($tasklist->content)) !!}</p>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
  
@endif