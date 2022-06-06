<div class="mx-auto">
    <div class="row mt-5">
         <h1 class="fs-5 text-center">Dynamic Form with Laravel 8 & Livewire</h1>
    </div>
    <div class="row justify-center">
        <div class="w-50">
            <div class="card my-3">
                <div class="card-body">
                    <form class="row g-3 justify-center">
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
                            <button class="inline-flex justify-center w-36 rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5 mb-6" wire:click.prevent="add({{$i}})">add</button>
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
                            <button class="inline-flex justify-center w-36 rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-red-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5 mb-6" wire:click.prevent="remove({{$key}})">Remove</button>
                        </div>
                        @endforeach
                        <div class="row">
                            <div class="col-12 ps-0">
                                <button type="button" wire:click.prevent="store()" class="inline-flex justify-center w-36 rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-red-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">Save</button>
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