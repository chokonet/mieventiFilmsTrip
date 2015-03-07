<?php if (!empty($info_vew['post'])) : ?>
	<h3 class="tit-sec"><?php echo $info_vew['post']->eve_nombre; ?></h3>
	<div class="container-fotos-evento" id="cont-imagenes">
		<?php if ( !empty($info_vew['fotos']) ) :
		 	foreach ($info_vew['fotos'] as $key => $foto):
		 		$numero = $key+1;?>
		 		<a class="image shadow galeria_e" href="<?php echo url_foto($foto->title, $foto->id_evento, 'large'); ?>">
					<img src="<?php echo url_foto($foto->title, $foto->id_evento, 'resize'); ?>"  >
				</a>
			<?php endforeach;
		endif; ?>
	</div>
<?php endif; ?>