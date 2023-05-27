<?php
// Atur koneksi database
$host = "localhost";
$username = "root";
$password = "P@ssw0rd";
$database = "siakad";
$koneksi = mysqli_connect($host, $username, $password, $database);

// Fungsi Create
function createMahasiswa($nama, $nim, $programStudi)
{
    global $koneksi;
    $query = "INSERT INTO Mahasiswa (Nama, NIM, ProgramStudi) VALUES ('$nama', '$nim', '$programStudi')";
    mysqli_query($koneksi, $query);
}

// Fungsi Read
function getAllMahasiswa()
{
    global $koneksi;
    $query = "SELECT * FROM Mahasiswa";
    $result = mysqli_query($koneksi, $query);
    $mahasiswa = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $mahasiswa;
}

// Fungsi Update
function updateMahasiswa($id, $nama, $nim, $programStudi)
{
    global $koneksi;
    $query = "UPDATE Mahasiswa SET Nama='$nama', NIM='$nim', ProgramStudi='$programStudi' WHERE ID=$id";
    mysqli_query($koneksi, $query);
}

// Fungsi Delete
function deleteMahasiswa($id)
{
    global $koneksi;
    $query = "DELETE FROM Mahasiswa WHERE ID=$id";
    mysqli_query($koneksi, $query);
}

// Tombol "Create" ditekan
if (isset($_POST['create'])) {
    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $programStudi = $_POST['programStudi'];

    createMahasiswa($nama, $nim, $programStudi);
}

// Tombol "Update" ditekan
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $programStudi = $_POST['programStudi'];

    updateMahasiswa($id, $nama, $nim, $programStudi);
}

// Tombol "Delete" ditekan
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    deleteMahasiswa($id);
}

// Mendapatkan semua data Mahasiswa
$semuaMahasiswa = getAllMahasiswa();

?>

<!DOCTYPE html>
<html>

<head>
    <title>Mahasiswa</title>
</head>

<body>
    <h2>Data Mahasiswa</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>NIM</th>
            <th>Program Studi</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($semuaMahasiswa as $mahasiswa) : ?>
            <tr>
                <td><?php echo $mahasiswa['ID']; ?></td>
                <td><?php echo $mahasiswa['Nama']; ?></td>
                <td><?php echo $mahasiswa['NIM']; ?></td>
                <td><?php echo $mahasiswa['ProgramStudi']; ?></td>
                <td>
                    <form method="POST" action="">
                        <input type="hidden" name="id" value="<?php echo $mahasiswa['ID'];
?>">
<input type="submit" name="edit" value="Edit">
<input type="submit" name="hapus" value="Hapus">
</form>
</td>
</tr>
<?php endforeach; ?>
</table>

<h2>Tambah Mahasiswa</h2>
<form method="POST" action="">
<label>Nama:</label>
<input type="text" name="nama" required><br><br>
<label>NIM:</label>
<input type="text" name="nim" required><br><br>
<label>Program Studi:</label>
<input type="text" name="programStudi" required><br><br>
<input type="submit" name="create" value="Create">
</form>

<?php
// Jika tombol "Edit" ditekan
if (isset($_POST['edit'])) {
$id = $_POST['id'];

$query = "SELECT * FROM Mahasiswa WHERE ID=$id";
$result = mysqli_query($koneksi, $query);
$mahasiswa = mysqli_fetch_assoc($result);
?>

<h2>Edit Mahasiswa</h2>
<form method="POST" action="">
<input type="hidden" name="id" value="<?php echo $mahasiswa['ID']; ?>">
<label>Nama:</label>
<input type="text" name="nama" value="<?php echo $mahasiswa['Nama']; ?>" required><br><br>
<label>NIM:</label>
<input type="text" name="nim" value="<?php echo $mahasiswa['NIM']; ?>" required><br><br>
<label>Program Studi:</label>
<input type="text" name="programStudi" value="<?php echo $mahasiswa['ProgramStudi']; ?>" required><br><br>
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
