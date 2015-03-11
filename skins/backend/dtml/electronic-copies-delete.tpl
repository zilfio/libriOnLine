<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Eliminazione copia elettronica</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<form method="post" enctype="multipart/form-data">
	<input type="hidden" name="page" value="1" />
		<div class="form-group">
            <label for="libro">Libro</label>
            <select class="form-control" name="libro" disabled="disabled">
                <option value="{$electronicCopy->getLibro()->getIsbn()}">{$electronicCopy->getLibro()->getTitolo()} </option>
            </select>
        </div>
	<div class="form-group">
            <label for="mimetype">Mimetype</label>
            <input type="text" class="form-control" name="mimetype" value="{$electronicCopy->getMimetype()}" disabled="disabled" />
    </div>
    <div class="form-group">
            <label for="path">Path</label>
            <input type="text" class="form-control" name="path" value="{$electronicCopy->getPath()}" disabled="disabled" />
    </div>
    <button type="submit" class="btn btn-danger">Elimina Copia Elettronica</button>
</form>