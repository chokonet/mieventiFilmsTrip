<div class="links-admin links-event">
	<a href="<?php echo base_url(); ?>admin/eventos/" class="boton inf-admin">Ver Eventos</a>
	<a href="<?php echo base_url(); ?>admin/eventos/nuevo-evento/" class="boton inf-admin">Crear nuevo Evento</a>
</div>
<div class="ultimos-eventos container-eventos clearfix">
	<h3>Categorías</h3>
	<div class="caja-crear-categoria clearfix shadow">
		<h4>Crear Categoría</h4>
		<form action="<?php echo base_url().'admin/categorias'; ?>" method="post" name="ccatego" id="ccatego">
			<label>Nombre de la Categoría</label>
			<input type="text" name="cat_name" id="cat_name">
			<input type="hidden" name="action" id="action" value="setSave">
			<input type="submit" value="Crear categoria">
		</form>
	</div>
	<div class="caja-crear-categoria clearfix shadow">
		<h4>Todas las Categorías</h4>
		<?php if (!empty($info_vew['categorias']) ) :
			foreach ($info_vew['categorias'] as $key => $categoria) : ?>
				<div class="caja-categoria">
					<div class="nombre-cat"><?php echo $categoria->cat_nombre; ?> (<?php echo $categoria->count; ?>)</div>
					<?php if ($categoria->cat_id != 1 AND $categoria->count == 0) : ?>
						<span class="caja-el-cat">
							<a href="<?php echo base_url().'admin/categorias/eliminar-categoria/'.$categoria->cat_id ?>">Eliminar Categoría</a>
						</span>
					<?php elseif ($categoria->cat_id != 1):?>
						<span class="caja-el-cat">
							<p>Para eliminar no debe de tener eventos asignados.</p>
						</span>
					<?php endif; ?>
				</div>
			<?php endforeach;
		endif; ?>
	</div>

</div>