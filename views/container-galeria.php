<h3 class="tit-sec">Eventos</h3>
<?php if ( !empty($info_vew['posts']) ):
	foreach ($info_vew['posts'] as $key => $post):

		$url_default = base_url().'uploads/img-p.png';
		$img = ($post->freatured != '') ? url_foto($post->freatured, $post->id_evento, 'thumbnail') : $url_default; ?>
		<div class="content-event">

			<a href="<?php echo base_url(); ?>galeria/evento/<?php echo $post->eve_slug; ?>">
				<img src="<?php echo $img; ?>">
			</a>
			<p><a href=""><?php echo $post->eve_nombre; ?></a></p>
			<span><?php echo $post->cat_nombre; ?></span>
			<?php if ($post->estatus != 1): ?>
				<span class="evento-bloqueado">Bloqueado</span>
			<?php  endif; ?>

		</div>
	<?php endforeach;
else:
	echo '<h5>No hay eventos</h5>';
endif; ?>