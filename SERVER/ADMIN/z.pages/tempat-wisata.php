<?php
if(isset($_POST['hapuswisata'])){
	$id_hapus = $koneksi->real_escape_string(trim(stripslashes(strip_tags(htmlspecialchars($_POST['id_hapus'],ENT_QUOTES)))));
	
	$cek = $koneksi->query("SELECT * FROM tempat_wisata WHERE id_wisata = '$id_hapus'");
	$data_order = mysqli_fetch_assoc($cek);
	
	$fotonya1 = $data_order['pic1'];
	$fotonya2 = $data_order['pic2'];
	$fotonya3 = $data_order['pic3'];
	$fotonya4 = $data_order['pic4'];
	
	$deletefile1 = "../assets/galery/".$fotonya1;
	$deletefile2 = "../assets/galery/".$fotonya2;
	$deletefile3 = "../assets/galery/".$fotonya3;
	$deletefile4 = "../assets/galery/".$fotonya4;

	if(!unlink($deletefile1) || !unlink($deletefile2) || !unlink($deletefile3) || !unlink($deletefile4)){
		$msg01 = "Gagal Hapus Foto (Mungkin sdh dihapus).";
	}

	$delete = $koneksi->query("DELETE FROM tempat_wisata WHERE id_wisata = '$id_hapus'");	

		if($delete){
			$msg_type = "success";
			$msg_content = "Berhasil Dihapus!!<br>$msg01";
		} else {
			$msg_type = "error";
			$msg_content = "Gagal Hapus Database!";
		}
	
}
if(isset($_POST['tambah'])){
	$id_cat = $koneksi->real_escape_string(trim(stripslashes(strip_tags(htmlspecialchars($_POST['id_cat'],ENT_QUOTES)))));
	$nama_wisata = $koneksi->real_escape_string(trim(stripslashes(strip_tags(htmlspecialchars($_POST['nama_wisata'],ENT_QUOTES)))));
	$deskripsi_wisata = $koneksi->real_escape_string(trim(stripslashes(strip_tags(htmlspecialchars($_POST['deskripsi_wisata'],ENT_QUOTES)))));
	$harga_wisata = $koneksi->real_escape_string(trim(stripslashes(strip_tags(htmlspecialchars($_POST['harga_wisata'],ENT_QUOTES)))));
	
	$files = $_FILES;
	$jumlahFile = count($files['listGambar']['name']);

	if(empty($id_cat) || empty($nama_wisata) || empty($deskripsi_wisata) || empty($harga_wisata)){
		$msg_type = "error";
		$msg_content = " Masih ada yang kosong.";
	} else if($jumlahFile != 4){
		$msg_type = "error";
		$msg_content = " Saat ini harus 4 foto.";
	} else {
		// MULAI UPLOAD
		$folderUpload = "../assets/galery/";

		# periksa apakah folder tersedia
		if (!is_dir($folderUpload)) {
			# jika tidak maka folder harus dibuat terlebih dahulu
			mkdir($folderUpload, 0777, $rekursif = true);
		}
		
		$namaBaru0 = str_replace(" ","",$nama_wisata);

		$msgg = "";
		
		for ($i = 0; $i < $jumlahFile; $i++) {
			$namaFile = $files['listGambar']['name'][$i];
			$lokasiTmp = $files['listGambar']['tmp_name'][$i];
			$file_type = $_FILES['listGambar']['type'][$i];
			
			$xxx = $i+1;
			$namaBaru = $namaBaru0.$xxx.".jpg";
			$lokasiBaru = "{$folderUpload}/{$namaBaru}";

			$allowed = array("image/jpeg", "image/gif", "image/png");
			if(!in_array($file_type, $allowed)) {
				// $msgg += $msgg."$namaFile Gagal <br> ";
			} else {
				$prosesUpload = move_uploaded_file($lokasiTmp, $lokasiBaru);

				// if ($prosesUpload) {
				// 	$msgg += $msgg."$namaFile Berhasil <br> ";
				// } else {
				// 	$msgg += $msgg."$namaFile Gagal (Type)<br> ";
				// }
			}

		}
		// SELESAI UPLOAD

		$insert_wisata = $koneksi->query("INSERT INTO tempat_wisata (id_kat, nama_wisata, deskripsi, harga_tiket, pic1, pic2, pic3, pic4) VALUES 
		('$id_cat','$nama_wisata','$deskripsi_wisata','$harga_wisata', '".$namaBaru0."1.jpg', '".$namaBaru0."2.jpg', '".$namaBaru0."3.jpg', '".$namaBaru0."4.jpg')");	
		if($insert_wisata){
			$msg_type = "success";
			$msg_content = "Berhasil Insert!!";
		} else {
			$msg_type = "error";
			$msg_content = "Gagal Insert Database!";
		}
		
	}
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>DataTables</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <a href="#">Home</a>
            </li>
            <li class="breadcrumb-item active">Tempat Wisata</li>
          </ol>
        </div>
      </div>
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Tempat Wisata</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
			<?php if($msg_type == "success"){ ?>
				<div class="alert alert-success alert-dismissible">
				  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				  <h5><i class="icon fas fa-check"></i> Sukses!</h5>
					<?php echo $msg_content;?>
				</div>
			<?php } else if ($msg_type == "error") { ?>
				<div class="alert alert-danger alert-dismissible">
				  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				  <h5><i class="icon fas fa-ban"></i> Gagal!</h5>
					<?php echo $msg_content;?>
				</div>
			<?php } ?>
              <button type="button" class="btn btn-primary" style="float: right; margin-right:5%;" data-toggle="modal" data-target="#modal-default">
                <i class="fa fa-plus"></i> Tambah Wisata </button>
				<div class="modal fade" id="modal-default">
					<div class="modal-dialog">
					  <div class="modal-content">
						<div class="modal-header">
						  <h4 class="modal-title">Tambah Wisata</h4>
						  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						  </button>
						</div>
						<form method="POST" enctype="multipart/form-data">
							<div class="modal-body">
							  <div class="form-group">
								<label>Kategori Wisata</label>
								<select class="form-control" name="id_cat">
									<?php 
										$cek0 = $koneksi->query("SELECT * FROM kategori_wisata");
										while ($data_cat = mysqli_fetch_assoc($cek0)) {
									?>
										<option value="<?php echo $data_cat['id_kat'];?>"><?php echo $data_cat['nama_kat'];?></option>
									<?php } ?>
								</select>
							  </div>
							  <div class="form-group">
								<label for="xx">Nama Wisata</label>
								<input type="text" class="form-control" id="xx" placeholder="Wisata Pantai" name="nama_wisata">
							  </div>
							  <div class="form-group">
								<label for="xx">Deskripsi Wisata</label>
								<textarea class="form-control" rows="3" placeholder="Enter ..."  name="deskripsi_wisata"></textarea>
							  </div>
							  <div class="form-group">
								<label for="xx">Harga Tiket</label>
								<div class="input-group mb-3">
								  <div class="input-group-prepend">
									<span class="input-group-text">Rp</span>
								  </div>
								  <input type="number" class="form-control" placeholder="100000" name="harga_wisata">
								</div>
								
							  </div>
							  <div class="form-group">
								<label for="exampleInputFile">Pic Tempat Wisata (4 Foto)(400x600)</label>
								<div class="input-group">
								  <div class="custom-file">
									<input type="file" class="custom-file-input" name="listGambar[]" accept="image/*" multiple>
									<label class="custom-file-label" for="exampleInputFile">Choose file</label>
								  </div>
								</div>
							  </div>
							
							</div>
							<div class="modal-footer justify-content-between">
							  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							  <button type="submit" class="btn btn-primary" name="tambah">Save changes</button>
							</div>
						</form>
						
					  </div>
					  <!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				  </div>
              <br>
              <br>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>id_wisata</th>
                    <th>kategori</th>
                    <th>nama</th>
                    <th>deskripsi</th>
                    <th>harga_tiket</th>
                    <th>foto</th>
                    <th>action</th>
                  </tr>
                </thead>
                <tbody>
				<?php
					$cek = $koneksi->query("SELECT * FROM tempat_wisata INNER JOIN kategori_wisata USING(id_kat)");
					while ($data_order = mysqli_fetch_assoc($cek)) {
				?>
				 <tr>
                    <td><?php echo $data_order['id_wisata'];?></td>
                    <td><?php echo $data_order['nama_kat'];?></td>
                    <td><?php echo $data_order['nama_wisata'];?></td>
                    <td><?php echo $data_order['harga_tiket'];?></td>
                    <td><?php echo $data_order['deskripsi'];?></td>
                    <td>
						<img src="../assets/galery/<?php echo $data_order['pic1'];?>" width="50px">
						<img src="../assets/galery/<?php echo $data_order['pic2'];?>" width="50px">
						<img src="../assets/galery/<?php echo $data_order['pic3'];?>" width="50px">
						<img src="../assets/galery/<?php echo $data_order['pic4'];?>" width="50px">
					</td>
                    <td>
                     
                      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapus<?php echo $data_order['id_wisata'];?>">
                        <i class="fas fa-trash"></i>
                      </button>
						<div class="modal fade" id="hapus<?php echo $data_order['id_wisata'];?>">
							<div class="modal-dialog">
							  <div class="modal-content bg-danger">
								<form method="POST">
									<div class="modal-header">
									  <h4 class="modal-title">Hapus Wisata</h4>
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									  </button>
									</div>
									<div class="modal-body">
									  <p>Hapus Wisata : <?php echo $data_order['nama_wisata'];?></p>
									  <input type="hidden" name="id_hapus" value="<?php echo $data_order['id_wisata'];?>">
									</div>
									<div class="modal-footer justify-content-between">
									  <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
									  <button type="submit" name="hapuswisata" class="btn btn-outline-light">Hapus</button>
									</div>
								</form>
							  </div>
							  <!-- /.modal-content -->
							</div>
							<!-- /.modal-dialog -->
						  </div>
                    </td>
                  </tr>
				<?php
					}
				?>
                </tbody>
                <tfoot>
            		<tr>
						<th>id_wisata</th>
						<th>kategori</th>
						<th>nama</th>
						<th>deskripsi</th>
						<th>harga_tiket</th>
						<th>foto</th>
						<th>action</th>
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>