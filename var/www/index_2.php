<?php
//phpinfo();
?>
<form enctype="multipart/form-data" name="pgp" action="api.php" method="post">
	<label for="file">Filename:</label>
	<input type="file" name="file" id="file"><br>
	<input type="text" name="key_id">
	<input type="submit" value="Send the file">
</form>
<?php

?>
