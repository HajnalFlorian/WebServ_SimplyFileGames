<?php

	class SFG{
		
		private $config_file_path;
		private $score_file_path;
		private $comment_file_path;
		private $data_folder_path;


		function __construct($new_config_file_path,$new_score_file_path,$new_comment_file_path,$new_data_folder_path){
			$this->data_folder_path=$new_data_folder_path;
			$this->file_config_path=$this->data_folder_path.$new_config_file_path;
			$this->file_score_path=$this->data_folder_path.$new_score_file_path;
			$this->file_comment_path=$this->data_folder_path.$new_comment_file_path;
		}

		function Install($gameId,$mdp){
			$this->InitConfig($gameId,$mdp);
			$this->Reinstall($mdp);
		}

		function Reinstall($mdp){
			if(file_exists($this->file_config_path)){
				$file_content_array = $this->get_file_json_as_object($this->file_config_path);
				if($mdp==$file_content_array["password"]){
					$this->InitScore($file_content_array['gameId']);
					$this->InitComments($file_content_array['gameId']);
				}
			}
		}

		function InitConfig($gameId,$mdp){
			$data = [
				"gameId" => $gameId,
				"password" => $mdp
			];

			$this->check_file($this->file_config_path,$data);
		}

		function InitScore($gameId){
			$data = [
				"gameId" => $gameId,
				"scores" => []
			];

			$this->check_file($this->file_score_path,$data);
		}

		function InitComments($gameId){
			$data = [
				"gameId" => $gameId,
				"comments" => []
			];
			$this->check_file($this->file_comment_path,$data);
		}

		function check_file($file_path,$data){
			if(!file_exists($file_path)){
				$this->set_file_json_from_object($file_path,$data);
				return true;
			}
		}

		function echo_file($file_path){
			$file_content_array = $this->get_file_json_as_object($file_path);u
			foreach ($file_content_array as $key => $value)
			{
				switch ( $key ) {
					case 'gameId' :
						echo "gameId: $value";
						break;
					case 'scores' : 
						foreach ($value as $key2 => $value2){
							echo ' username : ' . $value2['username'] . ']<br />';
							echo ' score : ' . $value2['score'] . ']<br />';
						}
						break;
					case 'comments' :
						foreach ($value as $key2 => $value2){
							echo ' username : ' . $value2['username'] . ']<br />';
							echo ' comment : ' . $value2['comment'] . ']<br />';
							echo ' date : ' . $value2['date'] . ']<br />';
						}
						break;
					case 'password' :
						echo "password: $value";
						break;
					default :
						break;
				}
			}
		}

		function get_file_json_as_object($file_path){
			$file_content_json = file_get_contents($file_path);
			$file_content_array = json_decode($file_content_json,true);
			return $file_content_array;
		}

		function set_file_json_from_object($file_path,$data){
			$file_content_json = json_encode($data);
			file_put_contents($file_path, $file_content_json);
		}

		function success($data) {

			echo json_encode(

				[

					"success" => true,

					"data" => $data

				]

			);

			die;
		}


		function error($code,$message) {

			echo json_encode(

				[

					"success" => false,

					"error" => [

						"code" => $code,

						"message" => $message

					]

				]

			);

			die;

		}

		function __call($FunctionName, $arguments) {

			if($FunctionName == 'AddInfo') {n
				switch (count($arguments)) {
					case 4:
						$file_content_array = $this->get_file_json_as_object($this->file_score_path);

						array_push($file_content_array[$arguments[0]],(object) ["username" => $arguments[2],$arguments[1] => $arguments[3]]);

						$this->set_file_json_from_object($this->file_score_path,$file_content_array);
						break;
					case 5:
						$file_content_array = $this->get_file_json_as_object($this->file_comment_path);

						array_push($file_content_array[$arguments[0]],(object) ["username" => $arguments[2],$arguments[1] => $arguments[3], "date" => $arguments[4]]);

						$this->set_file_json_from_object($this->file_comment_path,$file_content_array);
						break;
				}
			}
		}

		public static function sort_score($a,$b){
			if ($a['score'] == $b['score']) {
				return 0;
			}
			if($a['score'] < $b['score']){
				return 1;
			}else{
				return -1;
			}
		}

		function interact($datas){
			switch ($datas["action"]){
				case 'install':
					$this->Install($datas['gameId'],$datas['password']);
					if(!file_exists($this->file_score_path)){
						$this->error(1,"le fichier config est corrompu");
					}else{
						$this->success($this->get_file_json_as_object($this->file_config_path));
					}
					break;
				case 'reinstall':
					$this->Reinstall($datas['password']);
					if(!file_exists($this->file_score_path)){
						$this->error(1,"le fichier config est corrompu");
					}else{
						$this->success($this->get_file_json_as_object($this->file_config_path));
					}
					break;
				case 'get_highscores':
					if(!file_exists($this->file_score_path)){
						$this->error(200,"fichier inexistant");
					}else{
						$this->success($this->get_file_json_as_object($this->file_score_path));
					}
					break;
				case 'set_highscore':
					if(!file_exists($this->file_score_path)){
						$this->error(200,"fichier inexistant");
					}else{
						$this->AddInfo('scores','score',$datas['username'],$datas['info']);
						$json_content=$this->get_file_json_as_object($this->file_score_path);
						usort($json_content["scores"], array('SFG','sort_score'));
						$this->set_file_json_from_object($this->file_score_path,$json_content);
						$this->success($this->get_file_json_as_object($this->file_score_path));
					}
					break;
				case 'get_comments':
					if(!file_exists($this->file_comment_path)){
						$this->error(200,"fichier inexistant");
					}else{
						$this->success($this->get_file_json_as_object($this->file_comment_path));
					}
					break;
				case 'set_comment':
					if(!file_exists($this->file_comment_path)){
						$this->error(200,"fichier inexistant");
					}else{
						$this->AddInfo('comments','comment',$datas['username'],$datas['info'],date("Y-m-d H:i:s"));
						$this->success($this->get_file_json_as_object($this->file_comment_path));
					}
					break;
				default:
					$this->error(12, "ressource indéfinie");
					die;
					break;
			}
		}
	}

	$my_SFG = new SFG("/config.json","/highscores.json","/comments.json","../data");

	$my_SFG->interact(json_decode($_GET['request'],true));

?>