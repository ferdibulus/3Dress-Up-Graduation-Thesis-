<?php
ob_start();
session_start();
include 'nedmin/netting/baglan.php';
include 'nedmin/production/fonksiyon.php';
//Belirli veriyi seçme işlemi
$ayarsor=$db->prepare("SELECT * FROM ayar where ayar_id=:id");
$ayarsor->execute(array(
  'id' => 0
  ));
$ayarcek=$ayarsor->fetch(PDO::FETCH_ASSOC);


$kullanicisor=$db->prepare("SELECT * FROM kullanici where kullanici_mail=:mail");
$kullanicisor->execute(array(
  'mail' => $_SESSION['userkullanici_mail']
  ));
$say=$kullanicisor->rowCount();
$kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>3Dress-Up|3dRoom</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
		<link type="text/css" rel="stylesheet" href="main.css">
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	</head>
	<body>
		<div id="info" style="color:black">
			<a href="https://www.technocodee.com" style="color:blue">Technocodee</a> - <a style="color:black" href="index.php">3Dress-Up</a>- 3dRoom<br />
			
		</div>

		<script type="module">
			import * as THREE from 'https://threejsfundamentals.org/threejs/resources/threejs/r115/build/three.module.js';
			import {OrbitControls} from 'https://threejsfundamentals.org/threejs/resources/threejs/r115/examples/jsm/controls/OrbitControls.js';
			import {FBXLoader} from 'https://threejsfundamentals.org/threejs/resources/threejs/r115/examples/jsm/loaders/FBXLoader.js';
			//import {GLTFLoader} from 'https://threejsfundamentals.org/threejs/resources/threejs/r115/examples/jsm/loaders/GLTFLoader.js';
			import {DRACOLoader} from 'https://threejsfundamentals.org/threejs/resources/threejs/r115/examples/jsm/loaders/DRACOLoader.js';
			import {OBJLoader} from 'https://threejsfundamentals.org/threejs/resources/threejs/r115/examples/jsm/loaders/OBJLoader.js';
			import {MTLLoader} from 'https://threejsfundamentals.org/threejs/resources/threejs/r115/examples/jsm/loaders/MTLLoader.js';
			import {MtlObjBridge} from 'https://threejsfundamentals.org/threejs/resources/threejs/r115/examples/jsm/loaders/obj2/bridge/MtlObjBridge.js';
			import Stats from 'https://threejsfundamentals.org/threejs/resources/threejs/r115/examples/jsm/libs/stats.module.js';
			import {GUI} from 'https://threejsfundamentals.org/threejs/resources/threejs/r115/examples/jsm/libs/dat.gui.module.js';
			import { RectAreaLightUniformsLib } from 'https://threejsfundamentals.org/threejs/resources/threejs/r115/examples/jsm/lights/RectAreaLightUniformsLib.js';
			import { TransformControls } from 'https://threejsfundamentals.org/threejs/resources/threejs/r115/examples/jsm/controls/TransformControls.js';
			import { DragControls  } from 'https://threejsfundamentals.org/threejs/resources/threejs/r115/examples/jsm/controls/DragControls.js';
			import {Color} from './3d/threejs/Color.js';
			

			var cameraPersp, cameraOrtho, currentCamera;
			var scene, renderer, control, orbit, light, object,color;
			var gui,parameters;
			var objects = [];
			var manager = new THREE.LoadingManager();

			init();
			render();

			function init() {
		//Fbs,ms,mb baslangic

			var stats = new Stats();
			stats.showPanel( 0 ); // 0: fps, 1: ms, 2: mb, 3+: custom
			document.body.appendChild( stats.dom );

			function animate() {

				stats.begin();

				// monitored code goes here

				stats.end();

				requestAnimationFrame( animate );

			}

			requestAnimationFrame( animate );
		//Fbs,ms,mb bitis

		

		//ScreenShot Bitis

				renderer = new THREE.WebGLRenderer();
				renderer.setPixelRatio( window.devicePixelRatio );
				renderer.setClearColor(0xFFFFFF);
				renderer.setSize( window.innerWidth, window.innerHeight );
				document.body.appendChild( renderer.domElement );

				const aspect = window.innerWidth / window.innerHeight;

				cameraPersp = new THREE.PerspectiveCamera( 50, aspect, 0.01, 30000 );
				cameraOrtho = new THREE.OrthographicCamera( - 600 * aspect, 600 * aspect, 600, - 600, 0.01, 30000 );
				currentCamera = cameraPersp;

				currentCamera.position.set( 1000, 500, 1000 );
				currentCamera.lookAt( 0, 200, 0 );

				scene = new THREE.Scene();
				var gridHelper = new THREE.GridHelper( 500, 500, 0x303030, 0x303030 );
				scene.add( gridHelper );
				var gridHelper = new THREE.GridHelper( 250, 250, 0xffffff, 0xffffff );
				scene.add( gridHelper );

				light = new THREE.HemisphereLight( 0xffffff, 0x444444 );
				light.position.set( 0, 1, 0 );
				scene.add( light );

				light = new THREE.DirectionalLight( 0xffffff );
				light.position.set( 0, 1, 0 );
				scene.add( light );

				orbit = new OrbitControls( currentCamera, renderer.domElement );
				orbit.update();
				orbit.addEventListener( 'change', render );

				control = new TransformControls( currentCamera, renderer.domElement );
				control.addEventListener( 'change', render );

				control.addEventListener( 'dragging-changed', function ( event ) {

					orbit.enabled = ! event.value;

				} );
				control.enabled = true ;

			//Gui Baslangic

			displaygui();

			//Gui Bitis


			//Urun ve Model Cekme	
			
			//FBXLoader Baslangic
				//
				
				var loader = new FBXLoader();
				 loader.load('<?php echo $kullanicicek['kullanici_3dmodel'] ?>' , function ( object ) {
					scene.add( object );
					
					//modelViewMatrix(object);	
				});
  			

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
			    
				 var loader = new FBXLoader();		
				 loader.load( '<?php echo $uruncek['urun_3d'] ?>' , function ( object ) {
				 	
					scene.add( object );
					objects.push(object);
					//modelViewMatrix(object);
					control.attach( object );
					
				});

				<?php } ?>
				 

		    //FBXLoader Bitis
		    
		    //Urun ve Model Bitis

		    		
					scene.add( control );
						
					

				window.addEventListener( 'resize', onWindowResize, false );

				window.addEventListener( 'keydown', function ( event ) {
					 //var controller = new TransformControls( [ ... objects ], currentCamera, renderer.domElement );

					switch ( event.keyCode ) {

						case 81: // Q
							control.setSpace( control.space === "local" ? "world" : "local" );
							break;

						case 16: // Shift
							control.setTranslationSnap( 100 );
							control.setRotationSnap( THREE.MathUtils.degToRad( 15 ) );
							control.setScaleSnap( 0.25 );
							break;

						case 87: // W
							control.setMode( "translate" );
							//controller.setMode( "translate" );
							break;

						case 69: // E
							control.setMode( "rotate" );
							break;

						case 82: // R
							control.setMode( "scale" );
							break;

						case 67: // C
							const position = currentCamera.position.clone();

							currentCamera = currentCamera.isPerspectiveCamera ? cameraOrtho : cameraPersp;
							currentCamera.position.copy( position );

							orbit.object = currentCamera;
							control.camera = currentCamera;

							currentCamera.lookAt( orbit.target.x, orbit.target.y, orbit.target.z );
							onWindowResize();
							break;

						case 86: // V
							const randomFoV = Math.random() + 0.1;
							const randomZoom = Math.random() + 0.1;

							cameraPersp.fov = randomFoV * 160;
							cameraOrtho.bottom = - randomFoV * 500;
							cameraOrtho.top = randomFoV * 500;

							cameraPersp.zoom = randomZoom * 5;
							cameraOrtho.zoom = randomZoom * 5;
							onWindowResize();
							break;

						case 187:
						case 107: // +, =, num+
							control.setSize( control.size + 0.1 );
							break;

						case 189:
						case 109: // -, _, num-
							control.setSize( Math.max( control.size - 0.1, 0.1 ) );
							break;

						case 88: // X

							control.showX = ! control.showX;
							break;

						case 89: // Y
							control.showY = ! control.showY;
							break;

						case 90: // Z
							control.showZ = ! control.showZ;
							break;

						case 32: // Spacebar
							control.enabled = ! control.enabled;
							break;

						case 48: 		
							var temp0 = objects[0]; 
							if(temp0 == undefined){
								swal("Seçili Ürün Bulunmamaktadir");		
							}
							else{
					
								control.attach(temp0);
							swal(temp0.name,"Seçili Ürün Üzerinde Değişiklikler Yapabilirsiniz.");	
							}
							break;

						case 49: 
							var temp1 = objects[1]; 
							if(temp1 == undefined){
								swal("Seçili Ürün Bulunmamaktadir");		
							}
							else{

								control.attach(temp1);
							swal(temp1.name,"Seçili Ürün Üzerinde Değişiklikler Yapabilirsiniz.");	
							}
							break;	

						case 50: 
							var temp2 = objects[2]; 
							if(temp2 == undefined){
								swal("Seçili Ürün Bulunmamaktadir");		
							}
							else{
								control.attach(temp2);
							swal(temp2.name,"Seçili Ürün Üzerinde Değişiklikler Yapabilirsiniz.");	
							}
							break;

						case 51: 
							var temp3 = objects[3]; 
							if(temp3 == undefined){
								swal("Seçili Ürün Bulunmamaktadir");		
							}
							else{
								control.attach(temp3);
							swal(temp3.name,"Seçili Ürün Üzerinde Değişiklikler Yapabilirsiniz.");	
							}
							break;
										
						case 52: 
							var temp4 = objects[4]; 
							if(temp4 == undefined){
								swal("Seçili Ürün Bulunmamaktadir");		
							}
							else{
								control.attach(temp4);
							swal(temp4.name,"Seçili Ürün Üzerinde Değişiklikler Yapabilirsiniz.");	
							}
							break;

						case 53: 
							var temp5 = objects[5]; 
							if(temp5 == undefined){
								swal("Seçili Ürün Bulunmamaktadir");		
							}
							else{
								control.attach(temp5);
							swal(temp5.name,"Seçili Ürün Üzerinde Değişiklikler Yapabilirsiniz.");	
							}
							break;


						case 54: 
							var temp6 = objects[6]; 
							if(temp6 == undefined){
								swal("Seçili Ürün Bulunmamaktadir");		
							}
							else{
								control.attach(temp6);
							swal(temp6.name,"Seçili Ürün Üzerinde Değişiklikler Yapabilirsiniz.");	
							}
							break;

						case 55: 
							var temp7 = objects[7]; 
							if(temp7 == undefined){
								swal("Seçili Ürün Bulunmamaktadir");		
							}
							else{
								control.attach(temp7);
							swal(temp7.name,"Seçili Ürün Üzerinde Değişiklikler Yapabilirsiniz.");	
							}
							break;

						case 56: 
							var temp8 = objects[8]; 
							if(temp8 == undefined){
								swal("Seçili Ürün Bulunmamaktadir");		
							}
							else{
								control.attach(temp8);
							swal(temp8.name,"Seçili Ürün Üzerinde Değişiklikler Yapabilirsiniz.");	
							}
							break;	

						case 57: 
							var temp9 = objects[9]; 
							if(temp9 == undefined){
								swal("Seçili Ürün Bulunmamaktadir");		
							}
							else{
								control.attach(temp9);
							swal(temp9.name,"Seçili Ürün Üzerinde Değişiklikler Yapabilirsiniz.");	
							}
							break;		
					}

				} );
				
				window.addEventListener( 'keyup', function ( event ) {

					switch ( event.keyCode ) {

						case 16: // Shift
							control.setTranslationSnap( null );
							control.setRotationSnap( null );
							control.setScaleSnap( null );
							break;

					}

				} );

			}





		//Gui fonksiyon baslangic
			function displaygui(){
				var gui = new GUI();
				parameters = {
					t: "Ayarlar",
					a: "W",
					b: "E",
					c: "R",
					d: "Q",
					e: "Shift",
					f: "X",
					g: "Y",
					h: "Z",
					i: "Spacebar",
					j: "C",
				 	k: "V",
				 	l: "+/-", 
				 	m: "Tusa Bas: 0-1-2-3-4-5-6-7-8-9",
					

				}

				


				gui.add(parameters,'t').name("3Dress-Up:");
				
				var transform = gui.addFolder('Dönüştürme İşlemleri');
				transform.add(parameters, 'a').name('Yer Değiştir:');
				transform.add(parameters, 'b').name('Döndür:');
				transform.add(parameters, 'c').name('Ölçeklendir:');

				var alan = gui.addFolder('Alan İşlemleri');
				alan.add(parameters, 'l').name('Olcek Boyutu Arttirma/Azaltma:');
				alan.add(parameters, 'd').name('Yerel Alan Aç/Kapa:');
				alan.add(parameters, 'e').name('Rotasyona Ayarlama:');

				var dimension = gui.addFolder('Eksen İşlemleri');
				dimension.add(parameters, 'f').name('X ekseni:');
				dimension.add(parameters, 'g').name('Y ekseni:');
				dimension.add(parameters, 'h').name('Z ekseni:');

				var ayarAc = gui.addFolder('Acma Kapama İşlemleri:');
				ayarAc.add(parameters, 'i').name('Ayarları Aç/Kapa:');

				var cam = gui.addFolder('Kamera İşlemleri');
				cam.add(parameters, 'j').name('Kamera Açısı:');
				cam.add(parameters, 'k').name('Random Zoom:');
				gui.add(parameters,'m').name("Ürün Değiştir:");


			//ScreenShot Baslangic
				var obj = {
				add: function(ScreenShot) {
				var w = window.open('', '');
			    w.document.title = "Screenshot";
			    var img = new Image();
			    renderer.render(scene, currentCamera);
			    img.src = renderer.domElement.toDataURL();
			    w.document.body.appendChild(img);  


			    var a = document.createElement('a');
			  
			    renderer.render(scene, currentCamera);
			    a.href = renderer.domElement.toDataURL().replace("image/png", "image/octet-stream");
			    a.download = '3Dress-Up(Model-Kiyafet).png';
			    a.click();  
					  }
					};

				gui.add(obj, "add").name("Ekran Görüntüsü");
			//ScreenShot Bıtıs




				var odeme1 = {
				  add1: function() {
				     window.location = "http://localhost/3Dress-Up/odeme";
				  }
				};
				gui.add(odeme1, "add1").name("Ödeme Sayfası");
				
				gui.close();

				}

			//Gui fonksiyon bitis
			
			function onWindowResize() {

				const aspect = window.innerWidth / window.innerHeight;

				cameraPersp.aspect = aspect;
				cameraPersp.updateProjectionMatrix();

				cameraOrtho.left = cameraOrtho.bottom * aspect;
				cameraOrtho.right = cameraOrtho.top * aspect;
				cameraOrtho.updateProjectionMatrix();

				renderer.setSize( window.innerWidth, window.innerHeight );

				render();

			}

			function render() {

				renderer.render( scene, currentCamera );

			}

		</script>

	</body>
</html>