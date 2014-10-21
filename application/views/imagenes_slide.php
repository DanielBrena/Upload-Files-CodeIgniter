


<?php if(isset($imgs) && count($imgs)){ ?>
<div class="widget-content">
	<table class="table table-striped table-bordered">
		<thead>
			<th>Imagen</th>
			<th>Nombre de la Imagen</th>
			<th>Direccion URL</th>
			<th>Activar</th>
			<th>Principal</th>
			<th>Eliminar</th>
	    </thead>
		<tbody>
			<?php foreach ($imgs as $img) {	?>
			<tr>

				<td> <img class="img-daniel"src="<?= base_url().'imagenes/'.$img->sli_img_nombre ?>" alt="<?php echo $img->sli_img_nombre ?>">  </td>
				<td> <?=$img->sli_img_nombre ?> </td>
				<td><p data-img-id="<?=$img->sli_id ?>" class="url-p"><?=$img->sli_url  ?></p></td>
				<td class="opcion"><input value="<?=$img->sli_id ?>" class="activo" type="checkbox" name="activo"   <?= (($img->sli_estado  == 0) ? '' : 'checked') ?>  ></td>;
				<td class="opcion"><input value="<?=$img->sli_id ?>" class="principal" type="radio" name="principal"   <?= (($img->sli_estado  == 2) ? 'checked' : '') ?>  ></td>;

				
				<td class="td-actions"><a href="javascript:;" class="btn btn-danger btn-small"><i data-img-id="<?=$img->sli_id ?>" class="btn-icon-only icon-remove delete"> </i></a></td>
			</tr>

		<?php  } ?>
	                  
	                
		</tbody>
	</table>
</div>
<?php } ?>
