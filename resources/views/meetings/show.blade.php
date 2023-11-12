@extends('layouts.app')
@section('title', 'Meetings')

@section('content')
    <x-breadcrum name="Meetings" page-name="Meeting" />
    <div class="docs-content d-flex flex-column flex-column-fluid">
        <div class="container d-flex flex-column flex-lg-row">
            <div class="card card-docs flex-row-fluid mb-2 bg-gray-100">
                <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15">
                    <div class="pb-10">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-xl-6 col-lg-6 mb-10">
                                <x-label for="subject">Subject</x-label>
                                <p>{{ $meeting->subject }}</p>
                            </div>
                            <div class="col-sm-12 col-md-6 col-xl-6 col-lg-6 mb-10">
                                <x-label for="meeting_date">Meeting Date</x-label>
                                <p>{{ $meeting->meeting_date }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-xl-6 col-lg-6 mb-10">
                                <x-label for="meeting_time">Meeting Time</x-label>
                                <p>{{ $meeting->meeting_time }}</p>
                            </div>
                            <div class="col-sm-12 col-md-6 col-xl-6 col-lg-6 mb-10">
                                <x-label for="Created By">Created By</x-label>
                                <p>{{ $meeting->user->name }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-xl-6 col-lg-6 mb-10">
                                <x-label for="user_one">Attendee One</x-label>
                                <p>{{ $meeting->userOne->name }}</p>
                            </div>
                            <div class="col-sm-12 col-md-6 col-xl-6 col-lg-6 mb-10">
                                <x-label for="user_two">Attendee Two</x-label>
                                <p>{{ $meeting->userTwo->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection





