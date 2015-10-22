<?php
if (!empty($_GET['key'])) {
	require 'src/class/Query.php';
	$query = new Query();
	$res = $query->setQuery($_GET['key'])->getKeywords();

	if (@$_GET['json']) {
		echo $res;
	} else {
		if (sizeof(json_decode(json_decode($res)->data)) > 0) {
			if (!empty($_GET['id'])) {
				$query->_setId($_GET['id']);
				$result = $query->getDetailsData();
				if ($result['success'] === 0) {
					echo $result['message'];
					return false;
				}

				foreach ($result['data'] as $key => $value) {
					echo $key . ': ' . $value . '<br/>';
				}
			} else {
				$res = json_decode(json_decode($res)->data, true);
				foreach ($res as $key => $value) {
					echo '<a href="?key=' . $_GET['key'] . '&id=' . $value['id'] . '"> ' . $value['location'] . '</a><br/>';
				}
			}
		} else {
			echo 'No any result fouund';
		}
	}
} else {
	header('Location: .');
}