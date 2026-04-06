@extends('layouts.dashboard')
@section('content')
    <!-- OVERVIEW -->
    <div class="dash-panel active" id="panel-overview">
        <div class="dash-page-title">Dashboard Overview</div>
        <div class="dash-subtitle">Welcome back — here's what's happening today.</div>
        <div class="stats-row">
            <div class="stat-card fade-up">
                <div class="stat-label">Total Posts</div>
                <div class="stat-value" id="stat-posts">{{ $totalPosts }}</div>
                <div class="stat-change up">↑ {{ $postsThisMonth }} this month</div>
            </div>
            <div class="stat-card fade-up">
                <div class="stat-label">Page Views</div>
                <div class="stat-value" id="stat-views">{{ $viewsCount }}</div>
                <div class="stat-change up">↑ +12% vs last month</div>
            </div>
            <div class="stat-card fade-up">
                <div class="stat-label">Subscribers</div>
                <div class="stat-value">{{ $subscribers }}</div>
                <div class="stat-change up">↑ +87 this week</div>
            </div>
            <div class="stat-card fade-up">
                <div class="stat-label">Comments</div>
                <div class="stat-value">{{ $commentsCount }}</div>
                <div class="stat-change down">↓ -5% vs last week</div>
            </div>
        </div>
        <div class="dash-grid">
            <div>
                <div class="dash-card">
                    <div class="dash-card-title">Weekly Traffic <span
                            style="font-family:'DM Mono',monospace;font-size:12px;color:var(--muted)">Last 7
                            days</span></div>
                    <div class="chart-bars" id="chart-bars"></div>
                    <div class="chart-labels">
                        <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
                    </div>
                </div>
                <div class="dash-card">
                    <div class="dash-card-title">Recent Posts <button class="tbl-btn" onclick="showPanel('posts')">View
                            All</button></div>
                    <table class="posts-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="overview-tbody">
                            @foreach ($latestPosts as $post)
                                <tr>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->category->name }}</td>
                                    <td>{{ $post->status }}</td>
                                    <td>{{ $post->views }}</td>
                                    <td>
                                        <div class="action-btns">
                                            <a class="tbl-btn" href="{{ route('admin.posts.show', $post->id) }}"
                                                target="_blank">View</a>
                                            <a href="{{ route('admin.posts.edit', $post->id) }}" class="tbl-btn">Edit</a>
                                            {{-- <form method="POST" action="{{ route('admin.posts.destroy', $post->id) }}">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="tbl-btn">Del</button>
                                            </form> --}}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div>
                <div class="dash-card">
                    <div class="dash-card-title">Quick Draft</div>
                    <div class="quick-form">
                        <div class="form-field"><label>Title</label><input type="text" id="quick-title"
                                placeholder="Enter a title…"></div>
                        <div class="form-field"><label>Content</label>
                            <textarea id="quick-content" style="min-height:80px" placeholder="Start writing…"></textarea>
                        </div>
                        <div class="form-actions">
                            <button class="btn-cancel"
                                onclick="document.getElementById('quick-title').value='';document.getElementById('quick-content').value=''">Clear</button>
                            <button class="btn-save" onclick="saveDraft()">Save Draft</button>
                        </div>
                    </div>
                </div>
                <div class="dash-card">
                    <div class="dash-card-title">Recent Activity</div>
                    <div id="activity-list"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
