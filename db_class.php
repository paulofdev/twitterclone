<?php 
	
class db{

	private $host = "127.0.0.1";

	private $user = "root";

	private $password = "";

	private $db = "twitter_clone"; 

	public function connMysql() {
		$conn = mysqli_connect($this->host, $this->user, $this->password, $this->db);

		mysqli_set_charset($conn, 'utf8');

		if (mysqli_connect_errno($conn)) {
			echo "Erro ao se conectar no banco de dados".mysqli_connect_error();
		} 

		return $conn; 
	}

}

?>