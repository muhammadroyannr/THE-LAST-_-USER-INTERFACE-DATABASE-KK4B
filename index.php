<?php
	//koneksi databes
	$server = "localhost";
	$user = "root";
	$pass = "";
	$database = "webonline"; 

	$koneksi = mysqli_connect($server, $user, $pass, $database) or die(mysqli_error($koneksi));

	//jika tombol pesan sekarang dipencet
	if(isset($_POST['bsetuju']))
	{
		//uji data akan diedit atau disimpan baru
		if($_GET['hal'] == "edit")
		{
			//data mau diedit
			$edit = mysqli_query($koneksi, "UPDATE modgame set
												nama = '$_POST[tnam]',
												konten = '$_POST[tkon]',
												jumlah = '$_POST[tjum]'
											WHERE id = '$_GET[id]'
										   ");
			if($edit) //jika edit suksesfull
			{
				echo "<script>
						alert('Pesananmu berhasil diedit');
						document.location='index.php';
				      </script>";
			}
			else
			{
				echo "<script>
						alert('Pesanan kamu Gagal diedit');
						document.location='index.php';
					  </script>";
			}
		}
		else
		{
			//data akan disimpan baru
			$simpan = mysqli_query($koneksi, "INSERT INTO modgame (nama, konten, jumlah)
										  VALUES ('$_POST[tnam]', 
										  		 '$_POST[tkon]', 
										  		 '$_POST[tjum]')
										");
			if($simpan) //jika pesanan diterima
			{
				echo "<script>
						alert('Pesanan kamu sudah diterima, Mohon ditunggu info lebih lanjut');
						document.location='index.php';
				      </script>";
			}
			else
			{
				echo "<script>
						alert('Pesanan kamu Gagal diproses');
						document.location='index.php';
					  </script>";
			}
		}


		
	}

	//uji jika button ubah di pencet
	if(isset($_GET['hal']))
	{
		//ujin data yg diedit
		if($_GET['hal'] == "edit")
		{
			//tampilkan daya yg diedit
			$tampil = mysqli_query($koneksi, "SELECT * FROM modgame WHERE id = '$_GET[id]' ");
			$data = mysqli_fetch_array($tampil);
			if($data)
			{
				//jika data ketemu, njuk ditampung sek neng variabel
				$vnama = $data['nama'];
				$vkonten = $data['konten'];
				$vjumlah = $data['jumlah'];
			}
		}
		else if ($_GET['hal'] == "hapus")
		{
			//persiapan hapus pesanan
			$hapus = mysqli_query($koneksi, "DELETE FROM modgame WHERE id = '$_GET[id]' ");
			if($hapus){
				echo "<script>
						alert('Hapus pemesanan berhasil');
						document.location='index.php';
					  </script>";
			}
		}
	}

 ?>


<!DOCTYPE html>
<html>
<head>
	<title>SUNSOFT STUDIO-Order</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">
		<h1 class="text-center">SUNSOFT STUDIO CONTENT</h1>

	<!----Awalan card form------>
	<div class="card mt-3">
	  <div class="card-header bg-secondary text-white">
	    Form Pemesanan Konten
	  </div>
	  <div class="card-body">
	    <form method="post" action="">
	    	<div class="form-group">
	    		<label>Nama Pemesan</label>
	    		<input type="text" name="tnam" value="<?=@$vnama?>" class="form-control" placeholder="Masukkan Nama Anda..." required>
	    	</div>
	    	<div class="form-group">
	    		<label>Jenis Konten</label>
	    		<input type="text" name="tkon" value="<?=@$vkonten?>" class="form-control" placeholder="Masukkan Jenis Konten Yang Dipesan..." required>
	    	</div>
	    	<div class="form-group">
	    		<label>Jumlah</label>
	    		<input type="text" name="tjum" value="<?=@$vjumlah?>" class="form-control" placeholder="Masukkan Jumlah Yang Dipesan..." required>
	    	</div>

	    	<button type="submit" class="btn btn-success" name="bsetuju">Pesan Sekarang</button>
	    	<button type="reset" class="btn btn-danger" name="bulang">Refresh</button>
	    </form>
	  </div>
	</div>
	<!----Last card form---->

	<!----Awalan card tabel----->
	<div class="card mt-3">
	  <div class="card-header bg-dark text-white">
	    List Tabel Pemesan Konten
	  </div>
	  <div class="card-body">
	    
	    <table class="table table-bordered table-striped">
	    	<tr>
	    		<th>No.</th>
	    		<th>Nama Pemesan</th>
	    		<th>Jenis Konten</th>
	    		<th>Jumlah</th>
	    		<th>Mode</th>
	    	</tr>
	    	<?php 
	    		$no = 1;
	    		$tampil = mysqli_query($koneksi, "SELECT * from modgame order by id desc");
	    		while($data = mysqli_fetch_array($tampil)) :
	    	 ?>
	    	<tr>
	    		<td><?=$no++;?></td>
	    		<td><?=$data['nama']?></td>
	    		<td><?=$data['konten']?></td>
	    		<td><?=$data['jumlah']?></td>
	    		<td>
	    			<a href="index.php?hal=edit&id=<?=$data['id']?>" class="btn btn-info">Ubah</a>
	    			<a href="index.php?hal=hapus&id=<?=$data['id']?>" onclick="return confirm('Apakah anda ingin membatalkan pemesanan konten ini?')" class="btn btn-warning">Hilangkan</a>
	    		</td>
	    	</tr>
	    <?php endwhile; ?>
	    </table>
	  </div>
	</div>
	<!----Last card tabel---->
</div>





<script type="text/javascript" src="js/bootstrap.min.css"></script>
</body>
</html>