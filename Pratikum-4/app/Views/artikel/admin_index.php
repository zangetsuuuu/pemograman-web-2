<?= $this->include('template/header'); ?>
<section class="section">
    <div class="section-header">
        <h1>Daftar Artikel</h1>
        <div class="section-header-button" style="display: flex; justify-content: space-between;">
            <a href="<?= base_url('admin/artikel/create'); ?>" class="">Tambah Artikel</a>
            <form method="get" class="form-control">
                <input type="text" name="q" value="<?= $q; ?>" placeholder="Cari data">
                <input type="submit" value="Cari" class="">
            </form>
        </div>
    </div>

    <div class="section-body">
        <?php if ($artikel) : ?>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-striped" id="artikel-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Judul</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($artikel as $row) : ?>
                                    <tr>
                                        <td><?= $row['id']; ?></td>
                                        <td>
                                            <b><?= $row['judul']; ?></b>
                                            <p><small><?= substr($row['isi'], 0, 50); ?></small></p>
                                        </td>
                                        <td><?= $row['status']; ?></td>
                                        <td>
                                            <a class="" href="<?= base_url('admin/artikel/edit/' .
                                                                    $row['id']); ?>">Ubah</a>
                                            <a class="" onclick="return confirm('Yakin menghapus data?');" href="<?= base_url('admin/artikel/delete/' .
                                                                                                                        $row['id']); ?>">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <div class="alert alert-warning">
                Belum ada data.
            </div>
        <?php endif; ?>
    </div>
</section>

<?= $pager->only(['q'])->links(); ?>
<?= $this->include('template/footer'); ?>