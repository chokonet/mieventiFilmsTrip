<div class="links-admin links-event">
	<a href="<?php echo base_url(); ?>admin/eventos/" class="boton inf-admin">Ver Eventos</a>
</div>

<div class="ultimos-eventos container-eventos clearfix">
	<h3>Nuevo Evento</h3>
	<div class="error-login active_error_form" style="display: none;">
		<b>ERROR:</b> El campo del nombre es obligatorio.
	</div>
	<div class="caja-crear-evento clearfix shadow">
		<form action="<?php echo base_url().'admin/eventos/nuevo-evento'; ?>" method="post" name="cevent" id="cevent">
			<label>Nombre del Evento</label>
			<input type="text" name="event_name" id="event_name">
			<label>Descripción</label>
			<input type="text" name="event_descripcion" id="event_descripcion">
			<div class="select-options sel-1">
				<span class="caja-select caja-select_cat">SELECCIONAR CATEGORIA</span>
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
				<span class="caja-select caja-select_usu">SELECCIONAR USUARIO</span>
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
			<input type="hidden" name="event_categoria" id="event_categoria" value="1" class="eve_cat">
			<input type="hidden" name="event_usuario" id="event_usuario" value="1" class="eve_usu">
			<input type="hidden" name="action" id="action" value="setSave">

			<input type="submit" value="Crear Evento">
		</form>
	</div>

	<div class="contenedor-carga-fotos shadow">
		<div class="texto-foto-info">
			<span>Para cargar las imagenes es necesario crear primero el evento.</span>
		</div>
	</div>
</div>