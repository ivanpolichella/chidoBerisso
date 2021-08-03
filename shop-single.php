<?php
  include("./php/conexion.php");
  if( isset($_GET['id'])){
    $resultado = $conexion ->query("select * from combos where id=".$_GET['id'])or die($conexion->error);
    if(mysqli_num_rows($resultado) > 0 ){
      $combo = mysqli_fetch_array($resultado);
      $resultado = $conexion ->query("select * from productos as p 
      inner join combo_producto as cp 
      on p.id = cp.id_producto 
      where cp.id_combo=".$_GET['id'])or die($conexion->error);
      $resultadoSalsas = $conexion ->query("select * from categorias_salsas")or die($conexion->error);
      $records = array();
      while($r = mysqli_fetch_array($resultadoSalsas)) {
      $records[] = $r;
}
    }else{
      header("Location: ./index.php");
    }
  }else{
    //redireccionar
    header("Location: ./index.php");
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Tienda</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700"> 
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/style.css">
    
  </head>
  <body>
  
  <div class="site-wrap">
    <?php include("./layouts/header.php"); ?> 

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <img src="images/<?php echo $combo['imagen']; ?>" alt="<?php echo $combo['nombre_combo']; ?>" class="img-fluid">
          </div>
          <div class="col-md-6">
            <h2 class="text-black"><?php echo $combo['nombre_combo']; ?></h2>
            <h4><?php echo $combo['descripcion']; ?></h4>
            <p><strong class="text-primary h2">Precio: $<?php echo $combo['precio_combo']; ?></strong></p>

            <form action="cart.php" method="POST">
              <?php while($productosCombo = mysqli_fetch_array($resultado)) {
                if( ($productosCombo['id'] == '3') || ($productosCombo['id'] == '1') ){
                  for ($i=1; $i < ($productosCombo['cantidad'] + 1); $i++) { ?>
                <div class="mb-1 d-flex">
                  <h4 style="padding-right: 30px;"> <?php echo $productosCombo['nombre'].$i; ?> </h4>
                  <label for="opcion-veggie-<?php echo $productosCombo['nombre'].$i?>" class="d-flex mr-3 mb-3">
                    <span class="d-inline-block"><input required type="radio" id="opcion-veggie-<?php echo $productosCombo['nombre'].$i?>" name="<?php echo $productosCombo['nombre'].$i?>" value="veggie"></span> 
                    <span class="d-inline-block text-black" style="font-weight: 600;">Veggie</span>
                  </label>
                  <label for="opcion-pollo-<?php echo $productosCombo['nombre'].$i?>" class="d-flex mr-3 mb-3">
                    <span class="d-inline-block"><input required type="radio" id="opcion-pollo-<?php echo $productosCombo['nombre'].$i?>" name="<?php echo $productosCombo['nombre'].$i?>" value="pollo"></span> 
                    <span class="d-inline-block text-black" style="font-weight: 600;">Pollo</span>
                  </label>
                  <label for="opcion-bondiola-<?php echo $productosCombo['nombre'].$i?>" class="d-flex mr-3 mb-3">
                    <span class="d-inline-block"><input required type="radio" id="opcion-bondiola-<?php echo $productosCombo['nombre'].$i?>" name="<?php echo $productosCombo['nombre'].$i?>" value="bondiola"></span> 
                    <span class="d-inline-block text-black" style="font-weight: 600;">Bondiola</span>
                  </label>
                </div>
                <?php }
                }else{
                  if( ($productosCombo['id'] == '10')){
                    for ($i=1; $i < ($productosCombo['cantidad']+1); $i++) { ?>
                  <div class="mb-1 d-flex">
                    <h4 style="padding-right: 30px;"> <?php echo $productosCombo['nombre'].$i; ?> </h4>
                    <?php foreach ($records as $key => $value) { ?>
                    <label for="opcion-salsa-<?php echo $value['nombre'].$i?>" class="d-flex mr-3 mb-3">
                      <span class="d-inline-block"><input required type="radio" id="opcion-salsa-<?php echo $value['nombre'].$i?>" name="<?php echo $productosCombo['nombre'].$i?>" value="<?php echo $value['nombre'].$i?>" ></span> 
                      <span class="d-inline-block text-black" style="font-weight: 600;"><?php echo $value['nombre'] ?></span>
                    </label>
                    <?php }?>
                  </div>
                  <?php }}else{?>
                <h4> <?php echo $productosCombo['nombre']; ?> x<?php echo $productosCombo['cantidad']; ?> </h4>
              <?php }
              } } ?>
              
              <div class="mb-5">
                <div class="input-group mb-3" style="max-width: 120px;">
                  <div class="input-group-prepend">
                    <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
                  </div>
                  <input type="text" class="form-control text-center" value="1" name="cantidadCombo" placeholder="" aria-describedby="button-addon1">
                  <div class="input-group-append">
                    <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                  </div>
                </div>
              </div>
              <input type="hidden" id="id" name="id" value="<?php echo $combo['id']?>">
              <button type="submit" class="buy-now btn btn-sm btn-primary">Agregar Al Carrito</button>
            </form>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="site-section site-blocks-2">
                <div class="row justify-content-center text-center mb-5">
                  <div class="col-md-7 site-section-heading pt-4">
                    <h2>Categorias</h2>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0" data-aos="fade" data-aos-delay="">
                    <a class="block-2-item" href="#">
                      <figure class="image">
                        <img src="images/veggie.jpg" alt="" class="img-fluid">
                      </figure>
                      <div class="text">
                        <span class="text-uppercase">Preparacion</span>
                        <h3>Veggie</h3>
                      </div>
                    </a>
                  </div>
                  <div class="col-sm-6 col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="100">
                    <a class="block-2-item" href="#">
                      <figure class="image">
                        <img src="images/bondiola.jpg" alt="" class="img-fluid">
                      </figure>
                      <div class="text">
                        <span class="text-uppercase">Preparacion</span>
                        <h3>Bondiola</h3>
                      </div>
                    </a>
                  </div>
                  <div class="col-sm-6 col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="200">
                    <a class="block-2-item" href="#">
                      <figure class="image">
                        <img src="images/pollo.jpg" alt="" class="img-fluid">
                      </figure>
                      <div class="text">
                        <span class="text-uppercase">Preparacion</span>
                        <h3>Pollo</h3>
                      </div>
                    </a>
                  </div>
                </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include("./layouts/footer.php"); ?> 
  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>

  <script src="js/main.js"></script>
    
  </body>
</html>