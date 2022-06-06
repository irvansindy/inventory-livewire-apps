<div>
    <x-slot name="header">
        <h2 class="text-left">List Data Procurement</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="container">
                    <div class="row mt-5">
                        <h1 class="fs-5 text-center">Dynamic Form with Laravel 8 & Livewire</h1>
                    </div>
                    <div class="row justify-content-center">
                        <div class="w-50">
                            <div class="card my-3">
                                <div class="card-body">
                                    <form class="row g-3 justify-content-center">
                                        <div class="col-4">
                                            <label class="visually-hidden">Account</label>
                                            <select class="form-select" aria-label="Default select example" wire:model="account.0">
                                                <option selected>Account</option>
                                                <option value="facebook">Facebook</option>
                                                <option value="instagram">Instagram</option>
                                                <option value="twitter">Twitter</option>
                                                <option value="github">Github</option>
                                            </select>
                                            @error('account.0') <span class="text-danger error">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-6">
                                            <label class="visually-hidden">Username</label>
                                            <input type="text" class="form-control" wire:model="username.0" placeholder="Your Username">
                                            @error('username.0') <span class="text-danger error">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-2">
                                            <button class="btn btn-primary mb-3" wire:click.prevent="add({{$i}})"><i class="bi bi-plus"></i></button>
                                        </div>
                                        {{-- Add Form --}}
                                        @foreach ($inputs as $key => $value)
                                        <div class="col-4">
                                            <label class="visually-hidden">Account</label>
                                            <select class="form-select" aria-label="Default select example" wire:model="account.{{ $value }}">
                                                <option selected>Account</option>
                                                <option value="facebook">Facebook</option>
                                                <option value="instagram">Instagram</option>
                                                <option value="twitter">Twitter</option>
                                                <option value="github">Github</option>
                                            </select>
                                            @error('account.') <span class="text-danger error">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-6">
                                            <label class="visually-hidden">Username</label>
                                            <input type="text" class="form-control" wire:model="username.{{ $value }}" placeholder="Your Username">
                                            @error('username.') <span class="text-danger error">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-2">
                                            <button class="btn btn-light mb-3" wire:click.prevent="remove({{$key}})"><i class="bi bi-x"></i></button>
                                        </div>
                                        @endforeach
                                        <div class="row">
                                            <div class="col-12 ps-0">
                                                <button type="button" class="btn btn-primary" wire:click.prevent="store()">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                {{ session('message') }}
                                </div>
                            @endif
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Account</th>
                                        <th scope="col">Username</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $no = 0;
                                    @endphp
                                    @foreach ($data as $data)
                                    <tr>
                                        <th scope="row">{{ ++$no }}</th>
                                        <td>{{ $data->account }}</td>
                                        <td>{{ $data->username }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  