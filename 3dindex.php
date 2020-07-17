<?php 

include 'header.php'; 


?>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
        //sayfa açıldığında otomatik açılması için
		$("#modalNesne").modal('show');
	});
</script>
	</head>
 <form action="nedmin/netting/islem.php" method="POST" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
<!-- modal nesnesi başlangıç -->
<div id="modalNesne" class="modal fade">
    <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
               
                <h4 class="modal-title">3D-Room'a Hosgeldiniz- <?php echo $kullanicicek['kullanici_adsoyad'] ?> </h4>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                  <video width="543" controls="controls" >
                 <source src="3d/videos/Urunlerinizi Sectiniz Simdi 3D Deneme Zamani.mp4" type="video/mp4">
                   
                </video>
               </div>
   
               
                     <form action="nedmin/netting/islem.php" method="POST" enctype="multipart/form-data"  id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                    <div class="form-group">
                      <p>3d Modelinizi Yukleyiniz:</p>
                        <input type="file" id="first-name" name="kullanici_3dmodel" value="<?php echo $kullanicicek['kullanici_3dmodel'] ?>" required="required" class="form-control col-md-7 col-xs-12">
                           <input type="hidden" name="kullanici_id" value="<?php echo $kullanicicek['kullanici_id'] ?>"> 
                        <button type="submit" name="3dmodelkaydet" class="btn btn-success">Yukle</button>
                        
                        <button type="button"  class="btn btn-success" data-dismiss="modal" aria-hidden="true">Devam Et</button>
                    </div>
                   </form>
            
            
            </div>
        </div>
    </div>
</div>
<!-- // modal nesnesi bitiş -->

<!-- Baslangic two model images acces to 3dressRoom -->
<div class="container">
  <div>
     <img src="images/displayModelWomen.png">
    <img  src="images/displayModel.png"> 
  </div>
  <div class="clearfix"></div>
  <div style="margin-left: 252px;font-family: monospace;font-size: x-large;">
        Urunlerinizi denemek icin lutfen tiklayiniz.
  </div>
  <div style="margin-left: 100px; margin-right: 100px">
    <a href="3dRoom.php"><button style="height: 65px;width: -webkit-fill-available;background-color: #75cdda;color: black;text-decoration: underline;font-size: xx-large;font-family: inherit;">3Dress Room</button>
  </div>
  </div> 
</div>


<!-- Bitis two model images acces to 3dressRoom -->




<!--Denenecek Urunler Baslangic -->
<div class="container">

  <div class="clearfix"></div>
  <div class="lines"></div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      
    </div>
  </div>
  <div class="title-bg">
    <div class="title">Denenecek Urunler:</div>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered chart">
      <thead>
        <tr>
          <th>Remove</th>
          <th>Ürün Resim</th>
          <th>Ürün ad</th>
          <th>Ürün Kodu</th>
          <th>Adet</th>
          <th>Toplam Fiyat</th>
        </tr>
      </thead>
      <tbody>


        <?php 
        $kullanici_id=$kullanicicek['kullanici_id'];
        $sepetsor=$db->prepare("SELECT * FROM sepet where kullanici_id=:id");
        $sepetsor->execute(array(
          'id' => $kullanici_id
          ));

        while($sepetcek=$sepetsor->fetch(PDO::FETCH_ASSOC)) {

          $urun_id=$sepetcek['urun_id'];

          $urunsor=$db->prepare("SELECT * FROM urun where urun_id=:urun_id");
          $urunsor->execute(array(
            'urun_id' => $urun_id
            ));

          $uruncek=$urunsor->fetch(PDO::FETCH_ASSOC);

          //echo $topla=$uruncek['urun_fiyat']*$sepetcek['urun_adet'];
          ?>

          <tr>
            <td><form method="post" action="nedmin/netting/islem.php">
              <input type="hidden" value="<?php echo $kullanici_id ?>" name="kullanici_id">
              <input type="hidden" value="<?php echo $sepetcek['sepet_id'] ?>" name="sepet_id">
              <button type="submit" name="sepetkaldir" class="btn btn-default btn-red btn-sm"><span>Kaldir</span></button></form></td>
            <td><img src="images\demo-img.jpg" width="100" alt=""></td>
            <td><?php echo $uruncek['urun_ad'] ?></td>
            <td><?php echo $uruncek['urun_id'] ?></td>
            <td><form><input type="text" class="form-control quantity" value="<?php echo $sepetcek['urun_adet'] ?>"></form></td>
            <td><?php echo $uruncek['urun_fiyat'] ?></td>
          </tr>
          <?php } ?>
          

        </tbody>
      </table>
    </div>
    <div class="row">
      <div class="col-md-6">


      </div>
      <div class="col-md-3 col-md-offset-3">
        <div class="subtotal-wrap">
          <!--<div class="subtotal">
            <<p>Toplam Fiyat : $26.00</p>
            <p>Vat 17% : $54.00</p>
          </div>-->
          <div class="total">Toplam Fiyat : <span class="bigprice"><?php echo $toplam_fiyat ?> TL</span></div>
          <div class="clearfix"></div>
          <a href="odeme" class="btn btn-default btn-yellow">Ödeme Sayfası</a>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
    <div class="spacer"></div>
  </div>
<!--Denenecek Urunler Bitis -->
<?php include 'footer.php'; ?>