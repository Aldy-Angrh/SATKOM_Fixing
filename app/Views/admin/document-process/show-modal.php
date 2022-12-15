<div class="table-responsive">
    <table id="table-process" class="table table-bordered table-striped">
        <tbody>
            <tr>
                <th>Email Pemilik</th>
                <td><?= $data['email_file_owner'] ?></td>
            </tr>
            <tr>
                <th>Nama Pemilik</th>
                <td><?= $data['name_owner'] ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td><?= $data['status_label'] ?></td>
            </tr>
            <tr>
                <th>Deskripsi</th>
                <td><?= $data['description'] ?></td>
            </tr>
            <tr>
                <th>Data</th>
                <td><?= $data['data'] ?></td>
            </tr>
            <tr>
                <th>Dibuat pada</th>
                <td><?= $data['created_at'] ?></td>
            </tr>
            <tr>
                <th>Diubah pada</th>
                <td><?= $data['updated_at'] ?></td>
            </tr>
        </tbody>
    </table>
</div>