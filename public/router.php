<?php

if (php_sapi_name() == 'cli-server') {
	if(preg_match('@^/assets/@', $_SERVER["REQUEST_URI"])) {
		return false;
	}
	if(preg_match('@^/semanticui/@', $_SERVER["REQUEST_URI"])) {
		return false;
	}
	if(preg_match('@\.(png|jpg|gif)$@', $_SERVER["REQUEST_URI"])) {
		return false;
	}
	if(preg_match('@^/demo/@', $_SERVER["REQUEST_URI"])) {
		return false;
	}
	if(preg_match('@^/rest/@', $_SERVER["REQUEST_URI"])) {
		if(isset($_GET['search'])) {
			$words = [];
			foreach(preg_split('/\s+/', $_GET['search']) as $word) {
				$word = strtolower(trim($word));
				if($word!='') $words[] = $word;
			}
		
			$a = [
				[ 'name' => '<img class="ui avatar image" src="/semanticui/john.jpg" /> '.htmlspecialchars('John Doe'), 'value' => 'usr01' ],
				[ 'name' => '<img class="ui avatar image" src="/semanticui/jane.jpg" /> '.htmlspecialchars('Jane Doe'), 'value' => 'usr02' ],
				[ 'name' => '<img class="ui avatar image" src="/semanticui/chris.jpg" /> '.htmlspecialchars('Chris Mastermind'), 'value' => 'administrator' ],
			];
			$r = ['success' => true, 'results' => []];
			foreach($a as $v) {
				foreach($words as $word) {
					if(stripos($v['name'], $word)!==false || stripos($v['value'], $word)!==false) {
						$r['results'][] = $v;
						continue(2);
					}
				}
			}
			echo json_encode($r);
		}
		else {
			echo json_encode(['success' => true, 'results' => []]);
		}
	}
	else {
		include('index.php');
	}
}


