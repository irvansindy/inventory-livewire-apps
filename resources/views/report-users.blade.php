<table class="table-auto w-full">
    <thead>
        <tr class="bg-gray-100">
            <th class="border px-4 py-2">Name</th>
            <th class="border px-4 py-2">Email</th>
            <th class="border px-4 py-2">Username</th>
            <th class="border px-4 py-2">NIK</th>
            <th class="border px-4 py-2">Role</th>
        </tr>
    </thead>
    <tbody>
        {{-- @php
            dd($data);
        @endphp --}}
        @forelse ($data as $item)
        <tr>
            <td class="border px-4 py-2">{{ $item->name }}</td>
            <td class="border px-4 py-2">{{ $item->email }}</td>
            <td class="border px-4 py-2">{{ $item->username }}</td>
            <td class="border px-4 py-2">{{ $item->nik }}</td>
            <td class="border px-4 py-2">{{ $item->roles }}</td>
        </tr>
        @empty
            <tr>
                <td colspan="5">No data</td>
            </tr>
        @endforelse
    </tbody>
</table>