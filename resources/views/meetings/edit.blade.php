@extends('layouts.app')
@section('title', 'Meetings')

@section('content')
    <x-breadcrum name="Meetings" page-name="Edit Meeting" />
    <div class="docs-content d-flex flex-column flex-column-fluid">
        <div class="container d-flex flex-column flex-lg-row">
            <div class="card card-docs flex-row-fluid mb-2 bg-gray-100">
                <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15">
                    <div class="pb-10">
                        <form class="form w-100" action="{{ route('meetings.update', $meeting->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-xl-6 col-lg-6 mb-10">
                                    <x-label for="subject" class="required">Subject</x-label>
                                    <x-input id="subject" name="subject" value="{{ old('subject') ?: $meeting->subject }}"
                                             placeholder="Meeting Subject" autofocus />
                                    @error('subject')
                                    <x-error>{{ $message }}</x-error>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-6 col-xl-6 col-lg-6 mb-10">
                                    <x-label for="meeting_date" class="required">Meeting Date</x-label>
                                    <x-input type="date" id="meeting_date" name="meeting_date" value="{{ old('meeting_date') ?: $meeting->meeting_date }}" />
                                    @error('meeting_date')
                                    <x-error>{{ $message }}</x-error>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-xl-6 col-lg-6 mb-10">
                                    <x-label for="meeting_time" class="required">Meeting Time</x-label>
                                    <x-input type="time" id="meeting_time" name="meeting_time" value="{{ old('meeting_time') ?: $meeting->meeting_time }}" />
                                    @error('meeting_time')
                                    <x-error>{{ $message }}</x-error>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-xl-6 col-lg-6 mb-10">
                                    <x-label for="user_one" class="required">Attendee One</x-label>
                                    <x-select-two name="user_one" id="user_one" message="Select Attendee One">
                                        <option value=""></option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ ( (old('user_one') ?? $meeting->user_one) == $user->id) ? 'selected' : '' }}>{{ $user->name }}</option>
                                        @endforeach
                                    </x-select-two>
                                    @error('user_one')
                                    <x-error>{{ $message }}</x-error>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-6 col-xl-6 col-lg-6 mb-10">
                                    <x-label for="user_two" class="required">Attendee Two</x-label>
                                    <x-select-two name="user_two" id="user_two" message="Select Attendee Two">
                                        <option value=""></option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ ( (old('user_two') ?? $meeting->user_two) == $user->id) ? 'selected' : '' }}>{{ $user->name }}</option>
                                        @endforeach
                                    </x-select-two>
                                    @error('user_two')
                                    <x-error>{{ $message }}</x-error>
                                    @enderror
                                </div>
                            </div>

                            <x-button class="btn-primary">Update Meeting</x-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection





