<?php
// Atur koneksi database
$host = "localhost";
$username = "root";
$password = "P@ssw0rd";
$database = "siakad";
$koneksi = mysqli_connect($host, $username, $password, $database);

// Fungsi Create
function createMataKuliah($nama, $kode, $deskripsi)
{
    global $koneksi;
    $query = "INSERT INTO MataKuliah (Nama, Kode, Deskripsi) VALUES ('$nama', '$kode', '$deskripsi')";
    mysqli_query($koneksi, $query);
}

// Fungsi Read
function getAllMataKuliah()
{
    global $koneksi;
    $query = "SELECT * FROM MataKuliah";
    $result = mysqli_query($koneksi, $query);
    $matakuliah = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $matakuliah;
}

// Fungsi Update
function updateMataKuliah($id, $nama, $kode, $deskripsi)
{
    global $koneksi;
    $query = "UPDATE MataKuliah SET Nama='$nama', Kode='$kode', Deskripsi='$deskripsi' WHERE ID=$id";
    mysqli_query($koneksi, $query);
}

// Fungsi Delete
function deleteMataKuliah($id)
{
    global $koneksi;
    $query = "DELETE FROM MataKuliah WHERE ID=$id";
    mysqli_query($koneksi, $query);
}

// Tombol "Create" ditekan
if (isset($_POST['create'])) {
    $nama = $_POST['nama'];
    $kode = $_POST['kode'];
    $deskripsi = $_POST['deskripsi'];

    createMataKuliah($nama, $kode, $deskripsi);
}

// Tombol "Update" ditekan
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $kode = $_POST['kode'];
    $deskripsi = $_POST['deskripsi'];

    updateMataKuliah($id, $nama, $kode, $deskripsi);
}

// Tombol "Delete" ditekan
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    deleteMataKuliah($id);
}

// Mendapatkan semua data Mata Kuliah
$semuaMataKuliah = getAllMataKuliah();

?>

<!DOCTYPE html>
<html>

<head>
    <title>Mata Kuliah</title>
</head>

<body>
    <h2>Data Mata Kuliah</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Kode</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($semuaMataKuliah as $matakuliah) : ?>
            <tr>
                <td><?php echo $matakuliah['ID']; ?></td>
                <td><?php echo $matakuliah['Nama']; ?></td>
                <td><?php echo $matakuliah['Kode']; ?></td>
                <td><?php echo $matakuliah['Deskripsi']; ?></td>
                <td>
                    <form method="POST" action="">
                    <input type="hidden" name="id" value="<?php echo $matakuliah['ID']; ?>">
                        <input type="submit" name="edit" value="Edit">
                        <input type="submit" name="delete" value="Delete">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Tambah Mata Kuliah</h2>
    <form method="POST" action="">
        <label>Nama:</label>
        <input type="text" name="nama" required><br><br>
        <label>Kode:</label>
        <input type="text" name="kode" required><br><br>
        <label>Deskripsi:</label>
        <textarea name="deskripsi" required></textarea><br><br>
        <input type="submit" name="create" value="Create">
    </form>

    <?php
    // Jika tombol "Edit" ditekan
    if (isset($_POST['edit'])) {
        $id = $_POST['id'];

        $query = "SELECT * FROM MataKuliah WHERE ID=$id";
        $result = mysqli_query($koneksi, $query);
        $matakuliah = mysqli_fetch_assoc($result);
    ?>

        <h2>Edit Mata Kuliah</h2>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $matakuliah['ID']; ?>">
            <label>Nama:</label>
            <input type="text" name="nama" value="<?php echo $matakuliah['Nama']; ?>" required><br><br>
            <label>Kode:</label>
            <input type="text" name="kode" value="<?php echo $matakuliah['Kode']; ?>" required><br><br>
            <label>Deskripsi:</label>
            <textarea name="deskripsi" required><?php echo $matakuliah['Deskripsi']; ?></textarea><br><br>
            <input type="submit" name="update" value="Update">
        </form>
    <?php
    }
    ?>

</body>

</html>

<?php
// Tutup koneksi database
mysqli_close($koneksi);
?>
