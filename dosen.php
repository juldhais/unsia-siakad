<?php
// Atur koneksi database
$host = "localhost";
$username = "root";
$password = "P@ssw0rd";
$database = "siakad";
$koneksi = mysqli_connect($host, $username, $password, $database);

// Fungsi Create
function createDosen($nama, $nidn, $jenjang)
{
    global $koneksi;
    $query = "INSERT INTO Dosen (Nama, NIDN, JenjangPendidikan) VALUES ('$nama', '$nidn', '$jenjang')";
    mysqli_query($koneksi, $query);
}

// Fungsi Read
function getAllDosen()
{
    global $koneksi;
    $query = "SELECT * FROM Dosen";
    $result = mysqli_query($koneksi, $query);
    $dosens = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $dosens;
}

// Fungsi Update
function updateDosen($id, $nama, $nidn, $jenjang)
{
    global $koneksi;
    $query = "UPDATE Dosen SET Nama='$nama', NIDN='$nidn', JenjangPendidikan='$jenjang' WHERE ID=$id";
    mysqli_query($koneksi, $query);
}

// Fungsi Delete
function deleteDosen($id)
{
    global $koneksi;
    $query = "DELETE FROM Dosen WHERE ID=$id";
    mysqli_query($koneksi, $query);
}

// Tombol "Simpan" ditekan
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $nidn = $_POST['nidn'];
    $jenjang = $_POST['jenjang'];

    createDosen($nama, $nidn, $jenjang);
}

// Tombol "Update" ditekan
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $nidn = $_POST['nidn'];
    $jenjang = $_POST['jenjang'];

    updateDosen($id, $nama, $nidn, $jenjang);
}

// Jika tombol "Delete" ditekan
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    deleteDosen($id);
}

// Mendapatkan semua data Dosen
$semuaDosen = getAllDosen();

?>

<!DOCTYPE html>
<html>

<head>
    <title>Dosen</title>
</head>

<body>
    <h2>Data Dosen</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>NIDN</th>
            <th>Jenjang Pendidikan</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($semuaDosen as $dosen) : ?>
            <tr>
                <td><?php echo $dosen['ID']; ?></td>
                <td><?php echo $dosen['Nama']; ?></td>
                <td><?php echo $dosen['NIDN']; ?></td>
                <td><?php echo $dosen['JenjangPendidikan']; ?></td>
                <td>
                    <form method="POST" action="">
                        <input type="
                        hidden" name="id" value="<?php echo $dosen['ID']; ?>">
                        <input type="submit" name="edit" value="Edit">
                        <input type="submit" name="delete" value="Delete">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Tambah Dosen</h2>
    <form method="POST" action="">
        <label>Nama:</label>
        <input type="text" name="nama" required><br><br>
        <label>NIDN:</label>
        <input type="text" name="nidn" required><br><br>
        <label>Jenjang Pendidikan:</label>
        <select name="jenjang" required>
            <option value="S2">S2</option>
            <option value="S3">S3</option>
        </select><br><br>
        <input type="submit" name="create" value="Create">
    </form>

    <?php
    // Jika tombol "Edit" ditekan
    if (isset($_POST['edit'])) {
        $id = $_POST['id'];

        $query = "SELECT * FROM Dosen WHERE ID=$id";
        $result = mysqli_query($koneksi, $query);
        $dosen = mysqli_fetch_assoc($result);
    ?>

        <h2>Edit Dosen</h2>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $dosen['ID']; ?>">
            <label>Nama:</label>
            <input type="text" name="nama" value="<?php echo $dosen['Nama']; ?>" required><br><br>
            <label>NIDN:</label>
            <input type="text" name="nidn" value="<?php echo $dosen['NIDN']; ?>" required><br><br>
            <label>Jenjang Pendidikan:</label>
            <select name="jenjang" required>
                <option value="S2" <?php echo ($dosen['JenjangPendidikan'] == 'S2') ? 'selected' : ''; ?>>S2</option>
                <option value="S3" <?php echo ($dosen['JenjangPendidikan'] == 'S3') ? 'selected' : ''; ?>>S3</option>
            </select><br><br>
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
