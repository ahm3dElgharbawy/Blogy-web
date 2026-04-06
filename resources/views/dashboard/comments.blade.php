@extends("layouts.dashboard")
@section("content")
<!-- COMMENTS -->
<div class="dash-panel" id="panel-comments">
    <div class="dash-page-title">Comments</div>
    <div class="dash-subtitle">Moderate and respond to reader comments.</div>
    <div class="dash-card">
        <div class="dash-card-title">Pending Moderation</div>
        <div id="comments-list"></div>
    </div>
</div>

@endsection
