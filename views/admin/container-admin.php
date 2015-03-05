<h3 class="inf-admin">Hola, <?php echo $info_replase->user_nick ?></h3>
<p class="inf-admin">Bienvenido a Mi Evento - filmstrip-club.com</p>
<div class="links-admin">
	<a href="<?php echo base_url(); ?>admin/eventos/nuevo-evento/" class="boton inf-admin">Crear nuevo Evento</a>
	<a href="<?php echo base_url(); ?>admin/eventos/" class="boton inf-admin">Ver Eventos</a>
</div>
<div class="ultimos-eventos clearfix">
	<h3>Ultimos Eventos</h3>
	<?php if ( !empty($info_vew['posts']) ):
		foreach ($info_vew['posts'] as $key => $post):

			$url_default = base_url().'uploads/img-p.png';
			$img = ($post->freatured != '') ? url_foto($post->freatured, $post->id_evento, 'thumbnail') : $url_default; ?>
			<div class="content-event">

				<a href="<?php echo base_url(); ?>admin/eventos/editar-evento/<?php echo $post->id_evento; ?>">
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
</div>