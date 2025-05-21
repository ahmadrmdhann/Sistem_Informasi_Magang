@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Contoh DataTables di Dashboard Admin</h2>
    <div class="overflow-x-auto">
        <table id="example" class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
            <thead class="bg-blue-100">
                <tr>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Role</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="px-4 py-2">Budi</td>
                    <td class="px-4 py-2">budi@example.com</td>
                    <td class="px-4 py-2">Admin</td>
                </tr>
                <tr>
                    <td class="px-4 py-2">Siti</td>
                    <td class="px-4 py-2">siti@example.com</td>
                    <td class="px-4 py-2">User</td>
                </tr>
                <tr>
                    <td class="px-4 py-2">Andi</td>
                    <td class="px-4 py-2">andi@example.com</td>
                    <td class="px-4 py-2">User</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- DataTables CSS & JS CDN -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>
@endsection
