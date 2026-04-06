@extends("layouts.dashboard")
@section("content")
<!-- ANALYTICS -->
<div class="dash-panel" id="panel-analytics">
    <div class="dash-page-title">Analytics</div>
    <div class="dash-subtitle">Detailed performance metrics for your content.</div>
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-label">Avg. Read Time</div>
            <div class="stat-value">4.2m</div>
            <div class="stat-change up">↑ +0.3m</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Bounce Rate</div>
            <div class="stat-value">38%</div>
            <div class="stat-change up">↑ Better 4%</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Returning Visitors</div>
            <div class="stat-value">61%</div>
            <div class="stat-change up">↑ +2%</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Share Rate</div>
            <div class="stat-value">8.4%</div>
            <div class="stat-change down">↓ -1.2%</div>
        </div>
    </div>
    <div class="dash-grid">
        <div class="dash-card">
            <div class="dash-card-title">Top Performing Posts</div>
            <div id="top-posts-list"></div>
        </div>
        <div class="dash-card">
            <div class="dash-card-title">Traffic Sources</div>
            <div style="display:flex;flex-direction:column;gap:14px;margin-top:8px" id="traffic-sources">
            </div>
        </div>
    </div>
</div>

@endsection
