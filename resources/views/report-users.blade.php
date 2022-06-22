<table class="table-auto w-full">
    <thead>
        <tr class="bg-gray-100">
            <th class="border px-4 py-2">Name</th>
            <th class="border px-4 py-2">NIK</th>
            <th class="border px-4 py-2">Email</th>
            <th class="border px-4 py-2">Role</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($users as $user)
            <tr>
                <td class="border px-4 py-2">{{ $user->name }}</td>
                <td class="border px-4 py-2">{{ $user->nik }}</td>
                <td class="border px-4 py-2">{{ $user->email }}</td>
                <td class="border px-4 py-2">{{ $user->roles }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="border px-4 py-2">No Data</td>
            </tr>
        @endforelse
    </tbody>
</table>