<?php
	 function deleteRecord(mysqli $db, $id){
		$sql ="DELETE FROM `wanted` WHERE id='".$id."'";
		$result = $db->query($sql);
		if(!$result){
			throw new Exception('Cannot delete');
		}
	}
    header("Location: /add_a_person.php");
?>