 @php
     function active($route)
     {
         return request()->routeIs($route) ? 'active' : '';
     }
 @endphp
 <aside class="dash-sidebar">
     {{-- <div class="dash-user">
         <div class="dash-avatar" id="dash-avatar-letter">A</div>
         <div class="dash-role" id="dash-user-role">Author</div>
     </div> --}}
     <div class="dash-nav-label">Main</div>
     <a href="{{ route('admin.dashboard') }}" class="dash-nav-item {{ active('admin.dashboard') }}"
         data-panel="overview"><span class="icon">◈</span> Overview</a>
     <a href="{{ route('admin.posts.index') }}" class="dash-nav-item {{ active('admin.posts.index') }}" data-panel="posts"><span class="icon">✦</span>
         All
         Posts</a>
     <a href="{{ route('admin.posts.create') }}" class="dash-nav-item {{ active('admin.posts.create') }}"
         data-panel="new-post"><span class="icon">✏</span>
         New Post</a>
     {{-- <a href="{{ route('admin.comments.index') }}" class="dash-nav-item {{ active('admin.comments.index') }}"
         data-panel="comments"><span class="icon">◉</span>
         Comments</a> --}}
     <div class="dash-nav-label">Data</div>
     <a href="{{ route('admin.analytics.index') }}" class="dash-nav-item {{ active('admin.analytics.index') }}"
         data-panel="analytics"><span class="icon">▦</span> Analytics</a>
     <a href="{{ route('admin.subscribers.index') }}" class="dash-nav-item {{ active('admin.subscribers.index') }}"
         data-panel="subscribers"><span class="icon">◎</span> Subscribers</a>
     <div class="dash-nav-label">Account</div>
     <a href="{{ route('admin.settings.index') }}" class="dash-nav-item {{ active('admin.settings.index') }}"
         data-panel="settings"><span class="icon">⚙</span>
         Settings</a>
     <a href="{{ route('logout') }}" class="dash-nav-item"><span class="icon">↩</span> Sign
         Out</a>
 </aside>
