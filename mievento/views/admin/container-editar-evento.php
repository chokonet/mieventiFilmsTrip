<div class="links-admin links-event">
	<a href="<?php echo base_url(); ?>admin/eventos/nuevo-evento/" class="boton inf-admin">Crear nuevo Evento</a>
</div>

<?php $post = isset($info_vew['posts']) ? $info_vew['posts'][0] : false;
if (isset($_GET['d']) and $post != false):?>
	<div class="ultimos-eventos container-eventos clearfix">
	<h3>Editar Evento : <?php echo $post->eve_nombre; ?></h3>
	<div class="error-login active_error_form" style="display: none;">
		<b>ERROR:</b> El campo del nombre es obligatorio.
	</div>
	<div class="caja-crear-evento clearfix shadow">
		<form action="" method="post" name="cevent" id="cevent">
			<label>Nombre del Evento</label>
			<input type="text" name="event_name" id="event_name" value="<?php echo $post->eve_nombre; ?>">
			<label>Descripción</label>
			<input type="text" name="event_descripcion" id="event_descripcion" value="<?php echo $post->eve_descripcion; ?>">
			<div class="select-options sel-1">
				<span class="caja-select caja-select_cat"><?php echo $post->cat_nombre; ?></span>
				<ul class="list-options">
					<?php if (isset($info_vew['categorias'])):
						foreach ($info_vew['categorias'] as $key => $categoria):
							$count = $key+1;
							$class = ($count%2 === 0) ? 's-gris' : ''; ?>
							<li class="c-option <?php echo $class; ?>" data-id_sel="<?php echo $categoria->id_categoria; ?>" data-tipo="cat" ><?php echo $categoria->cat_nombre; ?></li>
						<?php endforeach;
					endif; ?>
				</ul>
			</div>
			<div class="select-options">
				<span class="caja-select caja-select_usu"><?php echo $post->usu_nombre; ?></span>
				<ul class="list-options">
					<?php if (isset($info_vew['usuarios'])):
						foreach ($info_vew['usuarios'] as $key => $categoria):
							$count = $key+1;
							$class = ($count%2 === 0) ? 's-gris' : ''; ?>
							<li class="c-option <?php echo $class; ?>" data-id_sel="<?php echo $categoria->id_usuario; ?>"  data-tipo="usu"><?php echo $categoria->usu_nombre; ?></li>
						<?php endforeach;
					endif; ?>
				</ul>
			</div>
			<input type="hidden" name="event_categoria" id="event_categoria" value="<?php echo $post->id_categoria; ?>" class="eve_cat">
			<input type="hidden" name="event_usuario" id="event_usuario" value="<?php echo $post->id_usuario; ?>" class="eve_usu">
			<input type="hidden" name="action" id="action" value="setEditEvent">
			<input type="hidden" name="evento_id_edit" id="evento_id_edit" value="<?php echo $post->id_evento; ?>">
			<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>">
			<input type="file" name="subir-fotos-evento" id="subir-fotos-evento"  multiple accept="image/*">

			<input type="submit" value="Crear Evento">
		</form>
	</div>

	<div class="contenedor-carga-fotos shadow">
		<div class="imgenes-evento clearfix" id="manso-event">
			<?php if (!empty($info_vew['fotos'])):
				foreach ($info_vew['fotos'] as $key => $foto):?>
					<img class="item" src="<?php echo url_foto($foto->title, $foto->id_evento, 'resize'); ?>">
				<?php endforeach;
			endif; ?>
		</div>
		<?php $name_bt = !empty($info_vew['fotos']) ? 'Agregas más fotos' : 'Agregar fotos'; ?>
		<span class="boton bt-add-fotos"><?php echo $name_bt; ?></span>
	</div>
<?php else: ?>
	<div class="ultimos-eventos container-eventos clearfix">
		<h3>Eventos</h3>
		<div class="content-event">
			<a href=""><img src="<?php echo base_url(); ?>uploads/img-p.png"></a>
			<p><a href="">Nombre Evento</a></p>
			<span>Boda</span>
			<span class="eliminar-evento">Eliminar</span>
		</div>
		<div class="content-event">
			<a href=""><img src="<?php echo base_url(); ?>uploads/img-p.png"></a>
			<p><a href="">Nombre Evento</a></p>
			<span>XV Años</span>
			<span class="eliminar-evento">Eliminar</span>
		</div>
		<div class="content-event">
			<a href=""><img src="<?php echo base_url(); ?>uploads/img-p.png"></a>
			<p><a href="">Nombre Evento</a></p>
			<span>Primera comunion</span>
			<span class="eliminar-evento">Eliminar</span>
		</div>
		<div class="content-event c-left">
			<a href=""><img src="<?php echo base_url(); ?>uploads/img-p.png"></a>
			<p><a href="">Nombre Evento</a></p>
			<span>Boda</span>
			<span class="eliminar-evento">Eliminar</span>
		</div>
		<div class="content-event">
			<a href=""><img src="<?php echo base_url(); ?>uploads/img-p.png"></a>
			<p><a href="">Nombre Evento</a></p>
			<span>XV Años</span>
			<span class="eliminar-evento">Eliminar</span>
		</div>
		<div class="content-event">
			<a href=""><img src="<?php echo base_url(); ?>uploads/img-p.png"></a>
			<p><a href="">Nombre Evento</a></p>
			<span>Primera comunion</span>
			<span class="eliminar-evento">Eliminar</span>
		</div>
		<div class="content-event">
			<a href=""><img src="<?php echo base_url(); ?>uploads/img-p.png"></a>
			<p><a href="">Nombre Evento</a></p>
			<span>Boda</span>
			<span class="eliminar-evento">Eliminar</span>
		</div>
		<div class="content-event">
			<a href=""><img src="<?php echo base_url(); ?>uploads/img-p.png"></a>
			<p><a href="">Nombre Evento</a></p>
			<span>XV Años</span>
			<span class="eliminar-evento">Eliminar</span>
		</div>
		<div class="content-event">
			<a href=""><img src="<?php echo base_url(); ?>uploads/img-p.png"></a>
			<p><a href="">Nombre Evento</a></p>
			<span>Primera comunion</span>
			<span class="eliminar-evento">Eliminar</span>
		</div>
		<div class="content-event c-left">
			<a href=""><img src="<?php echo base_url(); ?>uploads/img-p.png"></a>
			<p><a href="">Nombre Evento</a></p>
			<span>Boda</span>
			<span class="eliminar-evento">Eliminar</span>
		</div>
		<div class="content-event">
			<a href=""><img src="<?php echo base_url(); ?>uploads/img-p.png"></a>
			<p><a href="">Nombre Evento</a></p>
			<span>XV Años</span>
			<span class="eliminar-evento">Eliminar</span>
		</div>
		<div class="content-event">
			<a href=""><img src="<?php echo base_url(); ?>uploads/img-p.png"></a>
			<p><a href="">Nombre Evento</a></p>
			<span>Primera comunion</span>
			<span class="eliminar-evento">Eliminar</span>
		</div>
	</div>
<?php endif; ?>

</div>