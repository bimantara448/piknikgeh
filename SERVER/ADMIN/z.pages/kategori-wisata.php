<?php
if(isset($_POST['hapuscat'])){
	$id_hapus = $koneksi->real_escape_string(trim(stripslashes(strip_tags(htmlspecialchars($_POST['id_hapus'],ENT_QUOTES)))));
	
	$cek = $koneksi->query("SELECT * FROM kategori_wisata WHERE id_kat = '$id_hapus'");
	$data_order = mysqli_fetch_assoc($cek);
	
	$fotonya = $data_order['logo_kat'];
	
	$deletefile = "../assets/icon/".$fotonya;

	if(!unlink($deletefile)){
		$msgg="FOTO GAGAL DIHAPUS. (Mungkin sudah dihapus)";
	} 
	
	$delete = $koneksi->query("DELETE FROM kategori_wisata WHERE id_kat = '$id_hapus'");	

	if($delete){
		$msg_type = "success";
		$msg_content = "Berhasil Dihapus!!";
	} else {
		$msg_type = "error";
		$msg_content = "Gagal Hapus Database! $msgg";
	}

}
if(isset($_POST['tambah_kat'])){
	$nama_kat = $koneksi->real_escape_string(trim(stripslashes(strip_tags(htmlspecialchars($_POST['nama_kat'],ENT_QUOTES)))));
	
	if(empty($nama_kat)){
		$msg_type = "error";
		$msg_content = " Masih ada yang kosong.";
	} else {
		
		$filename = $_FILES["foto_kat"]["name"];
		$tempname = $_FILES["foto_kat"]["tmp_name"]; 
		$file_type = $_FILES['foto_kat']['type'];
		
		$nama_file = str_replace(" ","",$nama_kat);
		
		$folder = "../assets/icon/".$nama_file.".png";
		
		$allowed = array("image/jpeg", "image/gif", "image/png");
		if(!in_array($file_type, $allowed)) {
			$msg_type = "error";
			$msg_content = "Gagal Upload! Hanya boleh Gambar";
		} else {
			if (move_uploaded_file($tempname, $folder))  {
				$insert_kategori = $koneksi->query("INSERT INTO kategori_wisata (nama_kat, logo_kat) VALUES 
				('$nama_kat', '$nama_file.png')");	
				if($insert_kategori){
					$msg_type = "success";
					$msg_content = "Berhasil Insert!!";
				} else {
					$msg_type = "error";
					$msg_content = "Gagal Insert Database!";
				}
			}else{
				$msg_type = "error";
				$msg_content = "Gagal Upload!";
			}
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
            <li class="breadcrumb-item active">DataTables</li>
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
              <h3 class="card-title">Kategori Wisata</h3>
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
                <i class="fa fa-plus"></i> Tambah Kategori </button>
				<div class="modal fade" id="modal-default">
					<div class="modal-dialog">
					  <div class="modal-content">
						<div class="modal-header">
						  <h4 class="modal-title">Tambah Kategori</h4>
						  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						  </button>
						</div>
						<form method="POST" enctype="multipart/form-data">
							<div class="modal-body">
							  <div class="form-group">
								<label for="xx">Nama Kategori</label>
								<input type="text" class="form-control" id="xx" placeholder="Wisata Pantai" name="nama_kat">
							  </div>
							  <div class="form-group">
								<label for="exampleInputFile">Logo Icon Kategori</label>
								<div class="input-group">
								  <div class="custom-file">
									<input type="file" class="custom-file-input" name="foto_kat">
									<label class="custom-file-label" for="exampleInputFile">Choose file</label>
								  </div>
								</div>
							  </div>
							 
							</div>
							<div class="modal-footer justify-content-between">
							  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							  <button type="submit" class="btn btn-primary" name="tambah_kat">Save changes</button>
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
                    <th>id_kat</th>
                    <th>nama_kat</th>
                    <th>logo_kat</th>
                    <th>action</th>
                  </tr>
                </thead>
                <tbody>
				<?php
					$cek = $koneksi->query("SELECT * FROM kategori_wisata");
					while ($data_order = mysqli_fetch_assoc($cek)) {
				?>
				 <tr>
                    <td><?php echo $data_order['id_kat'];?></td>
                    <td><?php echo $data_order['nama_kat'];?></td>
                    <td><img src="<?php echo $base_url."assets/icon/".$data_order['logo_kat'];?>" width="50px"></td>
                    <td>
                     
                      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapus<?php echo $data_order['id_kat'];?>">
                        <i class="fas fa-trash"></i>
                      </button>
						<div class="modal fade" id="hapus<?php echo $data_order['id_kat'];?>">
							<div class="modal-dialog">
							  <div class="modal-content bg-danger">
								<form method="POST">
									<div class="modal-header">
									  <h4 class="modal-title">Hapus Kategori</h4>
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									  </button>
									</div>
									<div class="modal-body">
									  <p>Hapus kategori : <?php echo $data_order['nama_kat'];?></p>
									  <input type="hidden" name="id_hapus" value="<?php echo $data_order['id_kat'];?>">
									</div>
									<div class="modal-footer justify-content-between">
									  <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
									  <button type="submit" name="hapuscat" class="btn btn-outline-light">Hapus</button>
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
                    <th>id_kat</th>
                    <th>nama_kat</th>
                    <th>logo_kat</th>
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