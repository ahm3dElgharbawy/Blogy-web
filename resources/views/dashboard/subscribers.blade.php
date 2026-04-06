@extends('layouts.dashboard')
@section('content')
<!-- SUBSCRIBERS -->
<div class="dash-panel" id="panel-subscribers">
    <div class="dash-page-title">Subscribers</div>
    <div class="dash-subtitle">Manage your newsletter subscriber list.</div>
    <div class="dash-card">
        <div class="dash-card-title">Subscriber List <span
                style="font-family:'DM Mono',monospace;font-size:12px;color:var(--muted)">{{ $users->count() }}
                total</span></div>
        <table class="posts-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Email</th>
                    <th>Joined</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="subscribers-tbody">
                @foreach ($users as $user )
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->created_at->format('M d, Y')}}</td>
                        <td>{{$user->status ?? "Active"}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

