<?php if(isset($not) && count($not)){ ?>
<div class="widget-content">
	<table class="table table-striped table-bordered">
		<thead>
			<th>Tipo</th>
			<th>Titulo</th>
			<th>Previsualizacion</th>
			<th>Nombre del archivo</th>
			<th>Direccion URL</th>
			<th>Activar</th>
			<th>Principal</th>
			<th>Eliminar</th>
	    </thead>
		<tbody>
			<?php foreach ($not as $n) {	?>
			<tr>
				<td> <?=$n->not_tipo?> </td>
				<td><p data-not-id="<?=$n->not_id?>" class="titulo-p"><?=$n->not_titulo?></p>  </td>
				<td> <img class="img-daniel"src="<?= base_url().'previsualizacion/'.$n->not_img_nombre_vp ?>" alt="<?php echo $n->not_img_nombre_vp?>">  </td>
				<td> <?=$n->not_archivo_nombre?> </td>
				<td><p data-not-id="<?=$n->not_id?>" class="url-p"><?=$n->not_url?></p></td>

				<td class="opcion"><input value="<?=$n->not_id?>" class="activo" type="checkbox" name="activo"   <?=(($n->not_estado  == 0) ? '' : 'checked')?>  ></td>;
				<td class="opcion"><input value="<?=$n->not_id?>" class="principal" type="radio" name="principal"   <?=(($n->not_estado  == 2) ? 'checked' : '')?>  ></td>;
				
				
				<td class="td-actions"><a href="javascript:;" class="btn btn-danger btn-small"><i  data-not-id="<?=$n->not_id?>" class="btn-icon-only icon-remove delete"> </i></a></td>
			</tr>

		<?php  } ?>
	                  
	                
		</tbody>
	</table>
</div>
<?php } ?>
